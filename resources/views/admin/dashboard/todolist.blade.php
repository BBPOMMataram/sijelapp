<script>
    $(function(){
        function fillTodoList(url, currentPage){

            let route = url ? url : "{{route('getTodoList')}}"
            route += currentPage ? `?page=${currentPage}` : ""

            $.get(route, res => {
                console.log(res);
                const linkEl = res.links.map(item => {
                    let label = item.label === '&laquo; Previous' ? '«' : item.label === 'Next &raquo;' ? '»' : item.label

                    return (`
                        <li class="page-item">
                            <a href="${item.url}" class="page-link ${item.active && 'bg-secondary'}">${label}</a>
                        </li>
                    `)
                })
                
                const itemEl = res.data.map(item => {
                    return (`
                        <li class="${item.isDone && 'done' }">
                            <!-- checkbox -->
                            <div class="icheck-primary d-inline ml-2">
                                <input type="checkbox" class="todoCb" page="${res.current_page}" id="${item.id}" ${item.isDone && 'checked' }>
                                <label for="${item.id}"></label>
                            </div>
                            <!-- todo text -->
                            <span class="text name">${item.name}</span>
                            <!-- Emphasis label -->
                            <small class="badge badge-warning"><i class="far fa-clock"></i> ${item.created_at}</small>
                            <!-- General tools such as edit or delete-->
                            <div class="tools">
                                <i class="fas fa-edit edit" page="${res.current_page}" id="${item.id}"></i>
                                <i class="fas fa-trash remove" page="${res.current_page}" id="${item.id}"></i>
                            </div>
                        </li>
                    `)
                } )

                $('.todo-list').empty().append(itemEl)
                $('.pagination').empty().append(linkEl)
            })
        }

        fillTodoList()

        // HANLDE EDIT CLICK
        $('.todo-list').on('click', '.edit', function(e){
            const id = $(this).attr('id')
            const currentPage = $(this).attr('page');
            const name = $(this).closest('li').find('.name').text();

            $('.card-footer>.form-input').attr('mode', 'update')
            $('.card-footer>.form-input').attr('dataId', id)
            $('.card-footer>.form-input').attr('currentPage', currentPage)
            $('#addTodoInput').val(name)
            $('#addTodoBtn').text('Save')
        })

        // EDIT FUNCTION
        function editTodo(name, dataId, currentPage) {
            let route = "{{route('todolist.update', "_id")}}"
            route = route.replace('_id', dataId)

            $.post(route, 
                {
                    _token: '{{csrf_token()}}',
                    _method: 'patch',
                    name
                }
            ).done( res => fillTodoList(null, currentPage))
        }

        // SAVE FUNCTION
        function addTodo(name) {
            $.post("{{route('todolist.store')}}", 
                {
                    _token: '{{csrf_token()}}',
                    userId: '{{auth()->user()->id}}',
                    name
                }
            ).done( res => fillTodoList())
        }

        // HANDLE STORE OR UPDATE
        $('#addTodoBtn').on('click', function(e){
            const name = $('#addTodoInput').val();
            const mode = $('.card-footer .form-input').attr('mode')
            const dataId = $('.card-footer .form-input').attr('dataId')
            const currentPage = $('.card-footer .form-input').attr('currentPage')

            if (mode === 'update') {
                editTodo(name, dataId, currentPage);
            } else if(mode === 'save') {
                addTodo(name);
            }
            
            resetAddBtn()
        })
        
        function resetAddBtn() {
            // RESET KE SAVE MODE
            $('#addTodoInput').val('')
            $('.card-footer>.form-input').attr('mode', 'save')
            $('.card-footer>.form-input').removeAttr('dataId')
            $('.card-footer>.form-input').removeAttr('currentPage')
            $('#addTodoBtn').text('Tambah')
        }

        // HANLDE PAGINATION
        $(".pagination").on("click", "a.page-link", function(e){
            e.preventDefault();

            const link = $(this).attr('href');
            
            link !== 'null' && fillTodoList(link)
        })

        // HANDLE ISDONE FUNCTION
        $('.todo-list').on('change', 'input.todoCb', function(){
            const isDone = $(this).is(':checked');
            const id = $(this).attr('id');
            const currentPage = $(this).attr('page');
            
            setDone(id, isDone, currentPage);
        })
        
        function setDone(id, isDone, currentPage){
            let route = "{{route('todolist.setDone', "_id")}}"
            route = route.replace('_id', id)

            $.post(route, 
                {
                    _token: '{{csrf_token()}}',
                    isDone
                }
            ).done( res => fillTodoList(null, currentPage))
        }

        // HANLDE REMOVE
        $('.todo-list').on('click', '.remove', function(e){
            const id = $(this).attr('id')
            const currentPage = $(this).attr('page');
            destroy(id, currentPage)
            resetAddBtn()
        })

        function destroy(id, currentPage) {
            let route = "{{route('todolist.destroy', "_id")}}"
            route = route.replace('_id', id)

            $.post(route, {
                _token: '{{csrf_token()}}',
                _method: 'delete'
            }).done( res => fillTodoList(null, currentPage))
        }

    })
</script>