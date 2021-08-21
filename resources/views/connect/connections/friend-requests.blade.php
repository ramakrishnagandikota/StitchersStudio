
@extends('layouts.connect')
@section('title','My Connections')
@section('content')
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
<label class="container">Friends
<input type="checkbox" value="friends"> <span class="checkmark"></span>
</label>
<label class="container">Followers
<input type="checkbox" value="followers"> <span class="checkmark"></span>
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
    <label class="container"> {{$sk->name}}
      <input type="checkbox" value="{{$sk->slug}}"> <span class="checkmark"></span>
    </label>
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

</div>
</div> 

</div>
<div class="col-lg-9">
<div class="row">


<div class="col-lg-9">
  @if($myfriend_requests->count() > 0)
<h5 class="m-b-25 theme-heading">Respond to your {{$myfriend_requests->count()}} friend requests</h5>
@endif
</div>
<div class="col-lg-12">
<div class="row users-card">

@if($myfriend_requests->count() > 0)
@foreach($myfriend_requests as $myreq)
@php 

$user = App\User::find($myreq->user_id);

if($user->picture){
  $userpicture = $user->picture;
}else{
  $a = $user->first_name;
  $firstChar = mb_substr($a, 0, 1, "UTF-8");
  $userpicture = 'https://via.placeholder.com/150/cccccc/bc7c8f?text='.strtoupper($firstChar);
}

if($user->username){
  $username = $user->username;
}else{
  $exp = explode('@', $user->email);
  $username = $exp[0];
}

$UserSkills = App\User::find($user->id)->profile->professional_skills;
$skills = str_replace(',', ' ', $UserSkills);

@endphp
<div class="col-lg-3 col-xl-3 col-md-4 hidethis sectionContent {{strtolower($skills)}}" id="friendDiv{{$user->id}}">
  <div class="rounded-card user-card">
      <div class="card">
          <div class="img-hover">
              <img class="img-fluid img-radius p-10" src="{{ $userpicture }}" alt="round-img">
              <div class="img-overlay img-radius">
                  <span>
                      <a href="{{url('connect/profile/'.$username.'/'.encrypt($user->id))}}" class="btn btn-sm btn-primary" data-popup="lightbox"><i class="fa fa-eye"></i></a>
                      
                  </span>
              </div>
          </div>
          <div class="user-content">
              <a href="{{url('connect/profile/'.$username.'/'.encrypt($user->id))}}"><h4 class="">{{ucfirst($user->first_name)}} {{ucfirst($user->last_name)}}</h4></a>
              <p class="m-b-0 text-muted">{{ ($user->hasRole('Knitter')) ? 'Knitter' : 'Designer' }}</p>
          </div>
          <p>
              <div class="row justify-content-center">      
                  <div class="col-lg-12 text-center">
              <button type="button" class="btn theme-btn request-btn acceptRequest" data-id="{{$user->id}}" id="friend{{$user->id}}">Accept</button>
              <button type="button" class="btn theme-outline-btn request-btn rejectFriendRequest" id="reject{{$myreq->id}}" data-friendid="{{$user->id}}" data-id="{{$myreq->id}}" >Reject</button>
              </div>
              </div>
          </p>
         
      </div>
  </div>
</div>

@endforeach
@endif

</div>
<div>
</div>
</div>


<div class="col-lg-9"> <h5 class="m-b-25 theme-heading">Friend requests sent</h5></div>

<div class="col-lg-12">
    <div class="row users-card">
@if($sentfriend_requests->count() > 0)
@foreach($sentfriend_requests as $sendreq)
@php 
$suser = App\User::find($sendreq->friend_id);
if($suser->picture){
  $Senduserpicture = $suser->picture;
}else{
   $a1 = $suser->first_name;
  $char = mb_substr($a1, 0, 1, "UTF-8");
$Senduserpicture = 'https://via.placeholder.com/150/cccccc/bc7c8f?text='.strtoupper($char);
}

if($suser->username){
  $uname = $suser->username;
}else{
  $exp1 = explode('@', $suser->email);
  $uname = $exp1[0];
}

$UserSkills1 = App\User::find($suser->id)->profile->professional_skills;
$skills1 = str_replace(',', ' ', $UserSkills1);
@endphp
        <div class="col-lg-3 col-xl-3 col-md-4 hidethis sectionContent {{strtolower($skills1)}}" id="cancelRequest{{$suser->id}}">
            <div class="rounded-card user-card">
                <div class="card">
                    <div class="img-hover">
                        <img class="img-fluid img-radius p-10" src="{{ $Senduserpicture }}" alt="round-img">
                        <div class="img-overlay img-radius">
                            <span>
                                <a href="{{url('connect/profile/'.$uname.'/'.encrypt($suser->id))}}" class="btn btn-sm btn-primary" data-popup="lightbox"><i class="fa fa-eye"></i></a>
                            </span>
                        </div>
                    </div>
                    <div class="user-content">
                        <a href="{{url('connect/profile/'.$uname.'/'.encrypt($suser->id))}}"><h4 class="">{{ucfirst($suser->first_name)}} {{ucfirst($suser->last_name)}}</h4></a>
                        <p class="m-b-0 text-muted">{{ ($suser->hasRole('Knitter')) ? 'Knitter' : 'Designer' }}</p>
                    </div>
                    <p>
                        <div class="row justify-content-center">      
                            <div class="col-lg-12 text-center">
                        <button id="cancel{{$suser->id}}" data-id="{{$suser->id}}" type="button" class="btn theme-outline-btn request-btn cancelRequest">Cancel request</button>
                        </div>
                        </div>
                    </p>
                   
                </div>
            </div>
        </div>
@endforeach
@else

<div class="m-auto">You didn't sent any friend requests</div>
@endif


    </div>
</div>


</div>
</div>
</div>
</div>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
          <div class="modal-header">
              <!-- <h4 class="modal-title">Modal Header</h4> -->
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
        <div class="modal-body text-center m-t-15">
          <p id="popupClass" class="text-center"></p>
          <p id="popupMessage"></p>
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
</style>
<script type="text/javascript">
  var sections = $('.sectionContent');
  $(function(){

    $('[data-toggle="tooltip"]').tooltip();
    updateContentVisibility();


    $('#reset1').click(function()
    {
        $('.skills-mutliSelect input[type=checkbox]').prop('checked',false); 
        updateContentVisibility();
    });

    $('#reset4').click(function()
    {
        $('.ratings-mutliSelect input[type=checkbox]').prop('checked',false); 
        updateContentVisibility();
    });

    $("#collection-filter :checkbox").click(updateContentVisibility);


$(document).on('click','.acceptRequest',function(){
  var id = $(this).attr('data-id');

  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


  $.ajax({
    url : '{{url("connect/acceptRequest")}}',
    type : 'POST',
    data : 'friend_id='+id,
    beforeSend : function(){
      //$(".loader-bg").show();
      $("#friend"+id).html('<i class="fa fa-spinner fa-spin"></i>');
    },
    success : function(res){
      if(res.success){
        $('#myModal').modal('toggle');
        $("#popupMessage").html('Friend request has been accepted!');
        $("#popupClass").html('<i class="fa fa-check f-46 KFpink"></i>');
        $("#friendDiv"+id).remove();
            setTimeout(function(){ $('#myModal').modal('hide'); },2000);

        //addProductCartOrWishlist('fa fa-check','success',res.success);
      }else{
        $("#friend"+id).html('Accept');
        addProductCartOrWishlist('fa fa-times','error',res.error);
      }
    },
    complete : function(){
      //$(".loader-bg").hide();
    }
  });

});


$(document).on('click','.rejectFriendRequest',function(){
  var id = $(this).attr('data-id');
  var fid = $(this).attr('data-friendid');

  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

Swal.fire({
  title: '',
  text: "Are you sure want to reject this friend request ?",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, Remove'
}).then((result) => {
  if (result.value) {

  $.ajax({
    url : '{{url("connect/rejectFriendRequest")}}',
    type : 'POST',
    data : 'id='+id,
    beforeSend : function(){
      //$(".loader-bg").show();
      $("#reject"+id).html('<i class="fa fa-spinner fa-spin"></i>');
    },
    success : function(res){
      if(res.success){
        $('#myModal').modal('toggle');
        $("#popupMessage").html('Request has been Rejected!');
        $("#popupClass").html('<img class="img-fluid" src="{{ asset('resources/assets/files/assets/images/delete.png') }}" alt="Theme-Logo">');
        $("#friendDiv"+fid).remove();
        setTimeout(function(){ $('#myModal').modal('hide'); },2000);
        
        //addProductCartOrWishlist('fa fa-check','success',res.success);
      }else{
        $("#reject"+id).html('Reject');
        addProductCartOrWishlist('fa fa-times','error',res.error);
      }
    },
    complete : function(){
      //$(".loader-bg").hide();
    }
  });
}

});
});


$(document).on('click','.cancelRequest',function(){
  var id = $(this).attr('data-id');

  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

Swal.fire({
  title: '',
  text: "Are you sure want to remove this friend request ?",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, Remove'
}).then((result) => {
  if (result.value) {

  $.ajax({
    url : '{{url("connect/cancelFriendRequest")}}',
    type : 'POST',
    data : 'friend_id='+id,
    beforeSend : function(){
      $("#cancel"+id).html('<i class="fa fa-spinner fa-spin"></i>');
    },
    success : function(res){
      if(res.success){
        $('#myModal').modal('toggle');
        $("#popupMessage").html('Request has been cancled!');
        $("#popupClass").html('<img class="img-fluid" src="{{ asset('resources/assets/files/assets/images/delete.png') }}" alt="Theme-Logo">');
        $("#cancelRequest"+id).remove();
        setTimeout(function(){ $('#myModal').modal('hide'); },2000);
        //addProductCartOrWishlist('fa fa-check','success',res.success);
      }else{
        $("#cancel"+id).html('Cancel request');
        addProductCartOrWishlist('fa fa-times','error',res.error);
      }
    },
    complete : function(){
    }
  });
}

});
});
  });


  function updateContentVisibility(){
    var checked = $("#collection-filter :checkbox:checked");

    if(checked.length){
        sections.addClass('hide');
        checked.each(function(){
            $("." + $(this).val()).removeClass('hide');

        });
    } else {
        sections.removeClass('hide');
    }

     if ( $("div.sectionContent:visible").length === 0){
        $("#noproducts").removeClass('hide');
     }else{
        $("#noproducts").addClass('hide');
     }
        
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
</script>
@endsection