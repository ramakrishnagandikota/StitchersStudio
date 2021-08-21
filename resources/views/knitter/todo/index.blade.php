@extends('layouts.knitterapp')
@section('title','Todo')
@section('content')
<div class="pcoded-wrapper">

<div class="pcoded-content">

<div class="pcoded-inner-content">
<div class="main-body">
<div class="page-wrapper">
<!-- Page-body start -->
<div class="page-body">
<div class="row">
<div class="col-xl-12">
<!-- To Do Card List card start -->
<div class="card">
  <div class="card-header">
      <h5 class="theme-heading">To-do List</h5>
  </div>
  <div class="card-block">
      <div class="form-material">
          <div class="right-icon-control">
              <form class="form-material" id="to-do" method="POST">
                  <div class="form-group form-primary" >
                      <input type="text" name="task-insert" class="form-control" required="">
                      <span class="form-bar"></span>
                      <label class="float-label">Create your task list</label>
                  </div>

                  <div class="form-icon ">
                      <button type="submit" class="btn btn-success theme-btn btn-icon  waves-effect waves-light" id="create-task">
                          <i class="fa fa-plus"></i>
                      </button>
                  </div>
              </form>
              
          </div>
      </div>
      
      <section id="task-container">
          <p></p>
          <h5 class="text-center blank-message">You don't have any Tasks</h5>
          <br><p></p>
          <ul id="task-list">
            @if($todos->count() > 0)
            @foreach($todos as $todo)
              <li id="task-card{{$todo->id}}" data-id="{{$todo->id}}" class="@if($todo->status == 2) complete @endif" >
                <i class="fa fa-trash delete-item" data-id="{{$todo->id}}"></i>
                  <p>{{$todo->notes}}</p>
              </li>
            @endforeach
            @endif
          </ul>
          <div class="text-center">
              <button data-toggle="modal" data-target="#delete-Modal" class="btn btn-danger theme-outline-btn m-b-0" type="button">Clear All Tasks</button>
          </div>
      </section>
  </div>
</div>
<!-- To Do Card List card end -->
</div>

</div>

</div>
<!-- Page-body end -->
</div>
</div>
</div>
</div>
<!-- Main-body end -->

</div>


<div class="modal fade" id="delete-single-Modal" role="dialog">
<div class="modal-dialog modal-md">
  <div class="modal-content">
	<div class="modal-header">
		  <h5 class="modal-title">Confirmation</h5>
	  <button type="button" class="close" data-dismiss="modal">&times;</button>
	</div>
	<div class="modal-body">
		<p></p>
		<input type="hidden" id="notes_id" value="0">
		   <p class="text-center"> <img class="img-fluid" src="{{ asset('resources/assets/files/assets/images/delete.png') }}" alt="Theme-Logo" /></p>
		   <h6 class="text-center">Do You really want to delete a selected note ?</h6>
		   <p></p>
	</div>
	<div class="modal-footer">
			<button class="btn waves-effect waves-light btn-primary theme-outline-btn" data-dismiss="modal">Cancel</button>
			<button type="button" class="btn btn-danger delete-single-card" data-dismiss="modal">Delete</button>
	</div>
  </div>
</div>
</div>


  <!--Modal forClear All Confirmation-->
  <div class="modal fade" id="delete-Modal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
              <h5 class="modal-title">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <p></p>
               <p class="text-center"> <img class="img-fluid" src="{{ asset('resources/assets/files/assets/images/delete.png') }}" alt="Theme-Logo" /></p>
               <h6 class="text-center">Do you really want to delete all tasks ?</h6>
               <h6 class="text-center">Action cannot be undone !</h6>
               <p></p>
        </div>
        <div class="modal-footer">
                <button class="btn waves-effect waves-light btn-primary theme-outline-btn" data-dismiss="modal">Cancel</button>
                <button  id="clear-all-tasks" type="button" class="btn theme-btn delete-card" data-dismiss="modal">Delete</button>
        </div>
      </div>
    </div>
  </div>        
@endsection

@section('footerscript')
<script type="text/javascript">
  var insertTaskURL = "{{url('knitter/addTodo')}}";
  var completeTaskURL = "{{url('knitter/todoComplete')}}";
  var deleteTodo = "{{url('knitter/deleteTodo')}}";
  var deleteAllNote = "{{url('knitter/deleteAllTodo')}}";
</script>
<script type="text/javascript" src="{{ asset('resources/assets/files/assets/pages/todo/todo1.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js') }}"></script>
<script type="text/javascript">
$(function(){
//setTimeout(function(){ $('.alert-success').hide() },2000);
});
</script>

@endsection