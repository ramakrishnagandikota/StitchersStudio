@if($myfriend_requests->count() > 0)

	<div class="users-card">
<h5 class="m-b-25 theme-heading">Respond to your {{$myfriend_requests->count()}} friend requests</h5> 
@if($myfriend_requests->count() > 4)
<a href="{{url('connect/friend-requests')}}" class="friendrequestlink">View more friend requests</a>
@endif
<div class="clearfix"></div>
<div class="row">
	<?php $i=0; ?>
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

@if($i < 4)
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
@endif
<?php $i++; ?>
	    @endforeach
	</div>

@endif