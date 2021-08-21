
@extends('layouts.connect')
@section('title','My Connections')
@section('content')
<form action="{{url("connect/find-connections")}}" id="find-connections" >
<div class="page-body m-t-15">
<div class="row">
<div class="col-lg-3">
<div id="MainMenu" class="card">
<div class="list-group panel" id="collection-filter">

 <a href="#accordion3" class="list-group-item list-group-item f-w-600" data-toggle="collapse" data-parent="#MainMenu"> Filters <i class="fa fa-caret-down"></i></a>
<div class="collapse show" id="accordion3">
<div class="list-group-item" style="border-bottom: none;">
<div class="col-lg-12">
<div class="skills-mutliSelect">
<ul>
<label class="container">Followers
<input type="checkbox" name="followers" value="followers"> <span class="checkmark"></span>
</label>
</ul>
</div>
</div>
</div>
</div> <a href="#accordion1" class="list-group-item list-group-item f-w-600" data-toggle="collapse" data-parent="#MainMenu"> Skills <i class="fa fa-caret-down"></i></a>
<div class="collapse show" id="accordion1">
<div class="list-group-item" style="border-bottom: none;">
<div class="col-lg-12">
<div class="skills-mutliSelect">
<ul>
@if($skills->count() > 0)
	@foreach($skills as $sk)
		<label class="container" class="parentCheckbox"> {{$sk->name}}
			<input type="checkbox" id="{{$sk->slug}}" onclick="getCheck('{{$sk->slug}}')"  name="skill[]" value="{{$sk->slug}}"> <span class="checkmark"></span>
		</label>

<div class="ratings-mutliSelect submenu hide" id="submenu{{$sk->slug}}">
	<ul>
	@if($skill_level->count() > 0)
	<?php $i=0; ?>
		@foreach($skill_level as $sl)
<?php 
if($sl->slug == 'beginner'){
	$rating = 1;
}else if($sl->slug == 'advanced-beginner'){
	$rating = 2;
}else if($sl->slug == 'experienced'){
	$rating = 3;
}else if($sl->slug == 'very-experienced'){
	$rating = 4;
}else if($sl->slug == 'expert'){
	$rating = 5;
}else{
	$rating = 0;
}
?>
@if($i == 0)
<label class="container" style="display: none;">{{$sl->name}}
<input type="checkbox" id="{{$sk->slug}}_rating0" name="{{$sk->slug}}_rating[]" value="0"  ><span class="checkmark"></span>
</label>
@endif
		<label class="container">{{$sl->name}}
			<input type="checkbox" class="{{$sk->slug}}_rating" id="{{$sk->slug}}_rating" name="{{$sk->slug}}_rating[]" value="{{$rating}}"> <span class="checkmark"></span>
		</label>
		<?php $i++; ?>
		@endforeach
	@endif
	</ul>
</div>

	@endforeach
@endif
<label class="container">
<button class="btn btn-default micro-btn waves-effect waves-light pull-right" id="reset1">Clear All</button>
</label>
<br>
</ul>
</div>
</div>
</div>
</div>
<!--New Accordion--> 
<!--
<a href="#accordion4" class="list-group-item list-group-item f-w-600" style="margin-bottom: 10px;" data-toggle="collapse" data-parent="#MainMenu"> Skill level<i class="fa fa-caret-down"></i></a>
<div class="collapse" id="accordion4">
<div class="list-group-item" style="border-bottom: none;">
<div class="col-lg-12">
<div class="ratings-mutliSelect">
<ul>
@if($skill_level->count() > 0)
	@foreach($skill_level as $sl)
	<label class="container">{{$sl->name}}
		<input type="checkbox" value="{{$sl->slug}}"> <span class="checkmark"></span>
	</label>


	@endforeach
@endif
<label class="container">
<button class="btn btn-default micro-btn waves-effect waves-light pull-right" id="reset4">Clear All</button>
</label>
<br>
</ul>
</div>
</div>
</div>
</div>
-->
<!--End of Accordion-->
</div>
</div>
</div>
<div class="col-lg-9">
<div class="row">
<div class="col-lg-12 col-xl-12 col-md-12">
<div class="card">

<div class="rounded rounded-pill">
<div class="input-group" style="margin-bottom: 1px;">
<input type="search" id="searchconnections" name="search" placeholder="Search for my connections..." aria-describedby="button-addon1" value="" class="form-control border-0">
<div class="input-group-append theme-btn">
			<button id="button-addon1" type="submit" class="btn theme-btn searchresult"><i class="fa fa-search" style="color:#fff;"></i>
		</button>
		</div>
</div>
</div>

</div>
</div>
<div class="col-lg-9">
<h5 class="m-b-25 theme-heading">My connections ( {{$friends->count()}} )</h5>
</div>
<div class="col-lg-12">
<div class="row users-card" id="findConnectionResults">


<div id="noproducts" class="col-md-12 text-center hide" style="margin:auto;">No connections to show for the search</div>

</div>

<div>

</div>
</div>
</div>
</div>
</div>
</div>

</form>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
          <div class="modal-header">
              <!-- <h4 class="modal-title">Modal Header</h4> -->
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
        <div class="modal-body text-center m-t-15">
          <p id="popupClass" class="text-center"></p>
          <p id="popupMessage">Request has been successfully sent!</p>
        </div>
      </div>
    </div>
 </div>

@endsection
@section('footerscript')
<style type="text/css">
	.hide{
		display: none;
	}
	.submenu{
		position: relative;
	    left: 36px;
	}
</style>
<script type="text/javascript">
	var sections = $('.sectionContent');
	$(function(){
		$('[data-toggle="tooltip"]').tooltip();
		filterResults();


		$('#reset1').click(function()
    {
        $('.skills-mutliSelect input[type=checkbox]').prop('checked',false); 
        filterResults();
    });

    $('#reset4').click(function()
    {
        $('.ratings-mutliSelect input[type=checkbox]').prop('checked',false); 
        filterResults();
    });


		$("#collection-filter :checkbox").click(updateContentVisibility);


		$(document).on('click','.unfriend',function(){
	var id = $(this).attr('data-id');

	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


Swal.fire({
  title: '',
  text: "Are you sure want to remove this user from friend list ?",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, Remove'
}).then((result) => {
  if (result.value) {
    
    $.ajax({
		url : '{{url("connect/removeFriend")}}',
		type : 'POST',
		data : 'friend_id='+id,
		beforeSend : function(){
			$(".loader-bg").show();
			$("#friend"+id).find('i').removeClass('fa-user-times').addClass('fa-spinner fa-spin');
		},
		success : function(res){
			if(res.success){
				$('#myModal').modal('toggle');
				$("#popupMessage").html('You have successfully unfriend the user!');
				$("#popupClass").html('<img class="img-fluid" src="{{ asset('resources/assets/files/assets/images/delete.png') }}" alt="Theme-Logo">');
				setTimeout(function(){ $('#myModal').modal('hide'); },2000);

				$("#friend"+id).remove();
				//addProductCartOrWishlist('fa fa-check','success',res.success);
			}else{
				$("#friend"+id).find('i').removeClass('fa-spinner fa-spin').addClass('fa-user');
				addProductCartOrWishlist('fa fa-times','error',res.error);
			}
		},
		complete : function(){
			$(".loader-bg").hide();
		}
	});


  }
});
});

$(document).on('click','.follow',function(){
	var id = $(this).attr('data-id');

	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


	$.ajax({
		url : '{{url("connect/follow")}}',
		type : 'POST',
		data : 'follow_user_id='+id,
		beforeSend : function(){
			$(".loader-bg").show();
			$("#follow"+id).find('i').removeClass('icofont icofont-ui-social-link').addClass('fa-spinner fa-spin');
		},
		success : function(res){
			if(res.success){

		$('#myModal').modal('toggle');
				$("#popupMessage").html('You are following the user now!');
				$("#popupClass").html('<i class="fa fa-check f-46 KFpink"></i>');

				setTimeout(function(){ $('#myModal').modal('hide'); },2000);

				$("#follow"+id).find('i').removeClass('fa-spinner fa-spin').addClass('icofont icofont-undo');
		$("#follow"+id).attr('data-original-title','Unfollow');
		$("#follow"+id).removeClass('follow').addClass('unfollow');
				//addProductCartOrWishlist('fa fa-check','success',res.success);
			}else{
				$("#follow"+id).find('i').removeClass('fa-spinner fa-spin').addClass('icofont-undo');
				addProductCartOrWishlist('fa fa-times','error',res.error);
			}
		},
		complete : function(){
			$(".loader-bg").hide();
		}
	});

});


$(document).on('click','.unfollow',function(){
	var id = $(this).attr('data-id');

	$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


	$.ajax({
		url : '{{url("connect/unfollow")}}',
		type : 'POST',
		data : 'follow_user_id='+id,
		beforeSend : function(){
			$(".loader-bg").show();
			$("#follow"+id).find('i').removeClass('icofont-undo').addClass('fa-spinner fa-spin');
		},
		success : function(res){
			if(res.success){
			$('#myModal').modal('toggle');
				$("#popupMessage").html('You have unfollowed now!');
				$("#popupClass").html('<i class="icofont icofont-undo f-46 KFpink"></i>');
				setTimeout(function(){ $('#myModal').modal('hide'); },2000);

				$("#follow"+id).find('i').removeClass('fa-spinner fa-spin').addClass('icofont-ui-social-link');
		$("#follow"+id).attr('data-original-title','Follow');
		$("#follow"+id).removeClass('unfollow').addClass('follow');
				//addProductCartOrWishlist('fa fa-check','success',res.success);
			}else{
				$("#follow"+id).find('i').removeClass('fa-spinner fa-spin').addClass('icofont-ui-social-link');
				addProductCartOrWishlist('fa fa-times','error',res.error);
			}
		},
		complete : function(){
			$(".loader-bg").hide();
		}
	});

});



$(document).on('submit','#find-connections',function(e){
	e.preventDefault();
	var search = $("#searchconnections").val();
	$("#searchResult").html(search);
	$("#search1").val(search);
	if(search == ""){
		$("#searchconnections").addClass('red');
		return false;
	}else{
		$("#searchconnections").removeClass('red');
	}
	filterResults();
	
});

$(document).bind('keyup keydown','#searchconnections',function(){
		if($(this).length > 0){
			$("#searchconnections").removeClass('red');
		}
});


	});


function updateContentVisibility(){
    	

    var checked = $("#collection-filter :checkbox:checked");
    if(checked.length){
    	$(".submenu").addClass('hide');

        checked.each(function(){
        	var rating = $(this).attr('id');
            $("." + $(this).val()).removeClass('hide');
            $("#submenu"+$(this).val()).removeClass('hide');
			$("#"+rating+"_rating0").prop('checked', true);
        });
    } else {
		$("#submenu"+$(this).val()+":checkbox").prop('checked',false);
    	$(".submenu").addClass('hide');

    } 

		filterResults();
	}

function addProductCartOrWishlist(icon,status,msg){
        $.notify({
            icon: 'fa '+icon,
            title: status+'!',
            message: msg
        },{
            element: 'body',
            position: null,
            type: "info",
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: true,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 10000,
            delay: 3000,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            },
            icon_type: 'class',
            template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
            '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            '</div>' +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
            '</div>'
        });
    }

 function filterResults(){
	var Data = $("#find-connections").serializeArray();
	
	$("#searchconnections").val('');

	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	$.ajax({
		url: '{{url("connect/filter-my-connections")}}',
		type: 'POST',
		data: Data,
		beforeSend: function(){
			$(".loader-bg").show();
		},
		success: function(res){
			if(res.error){
				$("#searchResult").html(res.error);
				$("#searchconnections").addClass('red');
			}else{
				$("#searchconnections").removeClass('red');
			}
			$("#findConnectionResults").html(res);
		},
		complete: function(){
			$(".loader-bg").hide();
		}
	});
}

function getCheck(value){
	if($("#"+value).prop('checked') == false){
		$("."+value+"_rating").each(function(){
			if($(this).prop('checked') == true){
				$(this).prop('checked',false);
			}
		});
	}
}

</script>
@endsection