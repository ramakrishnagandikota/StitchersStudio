  'use strict';
  $(document).ready(function() {
    if($("#task-list li").length > 0){
      $('.blank-message').hide();
    }
	
      //  main button click function
      $('#to-do').on('submit', function(e) {
        e.preventDefault();
          $(".md-form-control").removeClass("md-valid");

          // remove nothing message
          if ('.nothing-message') {
              $('.nothing-message').hide('slide', { direction: 'left' }, 300)
          };

          // create the new li from the form input
          var task = $('input[name=task-insert]').val();
          // Alert if the form in submitted empty
          if (task.length == 0) {
              alert('please enter a task');
          } else {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

            $.post(insertTaskURL, { note: task },function(res){
              if(res.status == 'success'){
                var newTask = '<li id="task-card'+res.id+'" data-id="'+res.id+'" class="">' + '<i class="fa fa-trash delete-item" data-id="'+res.id+'"></i>'+'<p>' + task + '</p>' + '</li>'
                $('#task-list').prepend(newTask);
              }else{
                alert('Unable to add notes, Try again after some time.');
              }
            });
              

              // clear form when button is pressed
              $('input').val('');

              // makes other controls fade in when first task is created
              $('#controls').fadeIn();
              $('.task-headline').fadeIn();
			  $('.blank-message').hide();
          }

      });

      // mark as complete
      $(document).on('click', 'li', function() {

        var notes_id = $(this).attr('data-id');

        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $.post(completeTaskURL, { id: notes_id},function(res){
        if(res.status == 'success'){
          $("#task-card"+notes_id).toggleClass('complete');
        }else{
          alert('Unable to mark the note complete, Try again after some time.');
        }
      });

          
      });

      // double click to remove
      $(document).on('dblclick', '#task-container li', function() {
         // $(this).remove();
      });

      $(document).on('click','.delete-item', function() {
      {
          var id = $(this).attr('data-id');
          $("#notes_id").val(id);
          //$('#delete-single-Modal').modal('show');
        //$(this).closest('li').remove();
        if(confirm('Are you sure want to delet this note ?')){
          $.get(deleteTodo+'/'+id,function(res){
            $("#task-card"+id).remove();
          });
        }
      }});
    
      // Clear all tasks button
      $('button#clear-all-tasks').on('click', function() {

      $.get(deleteAllNote,function(res){
        if(res.status == 'success'){
          $('#task-list li').remove();
          $('.task-headline').fadeOut();
          $('#controls').fadeOut();
          $('.nothing-message').show('fast');
          $('.blank-message').show();
        }else{
          alert('Unable to mark the note complete, Try again after some time.');
        }
      });

      });

      /*2nd todo*/
      $(".icofont icofont-ui-delete").on("click", function() {

          $(this).parent().parent().parent().fadeOut();
      });
      var i = 7;
      $("#add-btn").on("click", function() {
          $(".md-form-control").removeClass("md-valid");
          var task = $('.add_task_todo').val();
          if (task == "") {
              alert("please enter task");
          } else {
              var add_todo = $('<div class="to-do-list" id="' + i + '"><div class="checkbox-fade fade-in-primary"><label class="check-task"><input type="checkbox" onclick="check_task(' + i + ')" id="checkbox' + i + '"><span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span><span>' + task + '</span></label></div><div class="f-right"><a onclick="delete_todo(' + i + ');" href="#!" class="delete_todolist"><i class="icofont icofont-ui-delete" ></i></a></div></div>');
              i++;
              $(add_todo).appendTo(".new-task").hide().fadeIn(300);
              $('.add_task_todo').val('');
          }
      });

      $(".delete_todolist").on("click", function() {


          $(this).parent().parent().fadeOut();
      });


      /*3rd todo list code*/
      $(".save_btn").on("click", function() {
          $(".md-form-control").removeClass("md-valid");
          var saveTask = $('.save_task_todo').val();
          if (saveTask == "") {
              alert("please enter task");
          } else {
              var add_todo = $('<div class="to-do-label" id="' + i + '"><div class="checkbox-fade fade-in-primary"><label class="check-task"><input type="checkbox" onclick="check_label(' + i + ')" id="checkbox' + i + '"><span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span><span class="task-title-sp">' + saveTask + '</span><div class="f-right hidden-phone"><i class="icofont icofont-ui-delete delete_todo" onclick="delete_todo(' + i + ');"></i></div></label></div></div>');
              i++;
              $(add_todo).appendTo(".task-content").hide().fadeIn(300);
              $('.save_task_todo').val('');
              $("#flipFlop").modal('hide');
          }

      });

      $(".close_btn").on("click", function() {
          $('.save_task_todo').val('');
      });

      $(".delete_todo").on("click", function() {
          $(this).parent().parent().parent().parent().fadeOut();
      });
  });

  function delete_todo(e) {

      $('#' + e).fadeOut();
  }
  $('.to-do-list input[type=checkbox]').on("click", function() {
      if ($(this).prop('checked'))
          $(this).parent().addClass('done-task');
      else
          $(this).parent().removeClass('done-task');
  });

  function check_task(elem) {
      if ($('#checkbox' + elem).prop('checked'))
          $('#checkbox' + elem).parent().addClass('done-task');
      else
          $('#checkbox' + elem).parent().removeClass('done-task');
  }

  $('.to-do-label input[type=checkbox]').on('click', function() {
      if ($(this).prop('checked'))
          $(this).parent().addClass('done-task');
      else
          $(this).parent().removeClass('done-task');
  });

  function check_label(elem) {
      if ($('#checkbox' + elem).prop('checked'))
          $('#checkbox' + elem).parent().addClass('done-task');
      else
          $('#checkbox' + elem).parent().removeClass('done-task');
  }
