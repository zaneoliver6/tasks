<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Laravel</title>
      <!-- Fonts -->
      <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

      <!-- CSS -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
      <link href="https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css"/>
      <script src="https://kit.fontawesome.com/0b2269a982.js" crossorigin="anonymous"></script>
      <!-- Styles -->
         <style>
            html, body {
               background-color: #fff;
               color: #636b6f;
               font-family: 'Nunito', sans-serif;
               font-weight: 200;
               height: 100vh;
               margin: 0;
            }

            .full-height {
               height: 100vh;
            }

            .flex-center {
               align-items: center;
               display: flex;
               justify-content: center;
            }

            .position-ref {
               position: relative;
            }

            .top-right {
               position: absolute;
               right: 10px;
               top: 18px;
            }

            /* .content {
               text-align: center;
            } */

            .links > a {
               color: #636b6f;
               padding: 0 25px;
               font-size: 13px;
               font-weight: 600;
               letter-spacing: .1rem;
               text-decoration: none;
               text-transform: uppercase;
            }

            .m-b-md {
               margin-bottom: 30px;
            }

            .handle {
               min-width: 18px;
               background: #607D8B;
               height: 15px;
               display: inline-block;
               cursor: move;
               margin-right: 10px;
            }

            .highlight {
               background: #f7e7d3;
               min-height: 30px;
               list-style-type: none;
            }

         </style>
   </head>
   <body>
         <div class="flex-center position-ref full-height">
            <!-- <div class="top-right links">
                  <a href="{{ route('projects.index') }}">Projects</a>
            </div> -->

            <div class="content">
               <div class="m-b-md">
                  <form id="task_form" method="POST" action="{{ route('tasks.store') }}">
                     @csrf
                     <div class="form-group">
                        <label for="project">Select Project</label>
                        <select class="form-control" id="project" name="project">
                        <option value="0">-- Please select a Project --</option>
                           @foreach($projects as $project)
                              <option value="{{ $project->id }}">{{ $project->name }}</option>
                           @endforeach
                        </select>
                     </div>
                     
                     <div class="form-group">
                        <button type="button" class="btn btn-block btn-outline-success" data-toggle="modal" data-target="#newTask">
                           Add New Task
                           <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-plus-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                              <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                           </svg>
                        </button>
                     </div>

                     <div class="modal fade" id="newTask" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                           <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                 <div class="modal-header">
                                 <h5 class="modal-title" id="ModalLabel">New Task</h5>
                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                 </button>
                              </div>
                              <div class="modal-body">
                                 <!-- <form> -->
                                    <div class="form-group">
                                       <label for="name" class="col-form-label">Name:</label>
                                       <input type="text" class="form-control" id="name" name="name">
                                    </div>
                                    <div class="form-group">
                                       <label for="priority" class="col-form-label">Priority:</label>
                                       <input type="number" class="form-control" id="priority" name="priority">
                                    </div>
                                 <!-- </form> -->
                              </div>
                              <div class="modal-footer">
                                 <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                                 <button id="saveBtn" type="submit" class="btn btn-outline-primary">Save</button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </form>
                  <div class="">
                     <ul id="tasks" class="sort_task list-group">
                     </ul>
                  </div>
               </div>
            </div>
         </div>
         <!-- jQuery and JS bundle w/ Popper.js -->
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
      <script src="https://unpkg.com/jquery@2.2.4/dist/jquery.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
      <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
      <script type="text/javascript">
         $(document).ready(function(){

            function updatePriority(idArr) {
               $.ajaxSetup({ headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
               $.ajax({
                  url:"{{ url('/tasks/reorder') }}",
                  method: 'POST',
                  data:{ids:idArr},
                  success: function(){
                     // alert('update successful');
                  }
               });
            }

            $('.sort_task').sortable({
               axis:"y",
               update: function(e,ui) {
                  var sortData = $('.sort_task').sortable('toArray', {attribute:'data-id'})
                  updatePriority(sortData)
               }
            });

            function reloadTasks(project_id) {
               $.ajax({
                  url:"{{ url('/project/getTasks') }}" + "/" + project_id,
                  type:'get',
                  dataType: 'json',
                  success: function(response) {
                     console.log(response['data']);
                     var len  = 0;
                     if(response['data'] != null) {
                        len   = response['data'].length;
                        console.log(len);
                     }

                     if(len > 0) {
                        for(var taskItr=0; taskItr < len; taskItr++) {
                           var taskId        = response['data'][taskItr].id;
                           var taskName      = response['data'][taskItr].name;
                           var taskPriority  = response['data'][taskItr].priority;
                           var taskItem = "<li class='task_item list-group-item' data-id='"+ taskId +"'>"
                                          + taskName 
                                          + "<span class='float-right'>"
                                          + "<a href='#' class='edit_task' data-id='"+ taskId +"' data-name='"+ taskName +"' data-priority='"+taskPriority+"'><i class='far fa-edit text-primary'></i></a>"
                                          + "&nbsp;"
                                          + "<a href='#' class='del_task' data-id='"+ taskId +"'><i class='far fa-trash-alt text-danger'></i></a>"
                                          +"</span>"
                                          "</li>";
                           $('#tasks').append(taskItem);
                        }
                     }
                  }
               });
            }

            $('#project').change(function(){
               $('.task_item').remove();
               var project_id = $(this).val();
               if(project_id != 0){
                  console.log(project_id);
                  reloadTasks(project_id);
               }
            });

            $('body').on('click', 'a.edit_task', function(){
               $('#newTask').modal('toggle');
               $('.modal-title').text('Edit Task');
               $('#name').val($(this).data('name'));
               $('#priority').val($(this).data('priority'));
               var taskId = $(this).data('id').toString();
               $('#task_form').attr('action', "");
               $('#task_form').on('submit', function(){
                  var formData = {
                     'name': $('#name').val(),
                     'priority' : $('#priority').val(),
                     'project_id': $('#project').val()
                  };
                  var route = "{{ route('tasks.update', ':id') }}"
                  route = route.replace(':id', [taskId]);
                  $.ajaxSetup({ headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
                  $.ajax({
                     url:route,
                     method: 'PUT',
                     data: formData,
                     success: function(){
                        //alert('update successful');
                        $('#newTask').modal('toggle');
                        $('.task_item').remove();
                        reloadTasks($('#project').val());
                     },
                     complete: function(){
                        unsetTaskData();
                     }
                  });
                  return false;
               });
            });

            function unsetTaskUpdateData() {
               $('.modal-title').text('New Task');
               $('#name').val($(this).data(''));
               $('#priority').val('');
               $('#task_form').attr('action', "{{ route('tasks.store') }}");
               $('#task_form').off();
            }

            $('#newTask').on('hidden.bs.modal', function(e){
               unsetTaskData();
            });

            $('body').on('click', 'a.del_task', function(){
               var taskId = $(this).data('id').toString();
               var route = "{{ route('tasks.destroy', ':id') }}"
               route = route.replace(':id', [taskId]);
               $.ajaxSetup({ headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}' } });
               $.ajax({
                  url:route,
                  type:'DELETE',
                  success: function(){
                     $('.task_item').remove();
                     reloadTasks($('#project').val());
                  }
               });
            });

         });
      </script>
   </body>
</html>
