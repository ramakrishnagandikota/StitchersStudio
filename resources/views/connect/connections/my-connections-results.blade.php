
@if($users)
@foreach($users as $user)
@php
	if($user->picture){
		$picture = $user->picture;
	}else{
		$picture = 'https://via.placeholder.com/150?text='.$user->first_name;
	}
$friend = App\Models\Friends::where('user_id',Auth::user()->id)->where('friend_id',$user->id)->count();
$follow = App\Models\Follow::where('user_id',Auth::user()->id)->where('follow_user_id',$user->id)->count();
$frequest = App\Models\Friendrequest::where('user_id',Auth::user()->id)->where('friend_id',$user->id)->count();
$myfrequest = App\Models\Friendrequest::where('user_id',$user->id)->where('friend_id',Auth::user()->id)->count();

if($user->username){
	$username = $user->username;
}else{
	$ds = explode('@', $user->email);
	$username = $ds[0];
}

@endphp



<div class="col-lg-4 col-xl-3 col-md-4 hidethis" >
	<div class="rounded-card user-card">
		<div class="card">
			<div class="img-hover">
			<img class="img-fluid img-radius p-10" src="{{$picture}}" alt="round-img">
			<div class="img-overlay img-radius">

				<span>
					 @if($friend == 1)
			        <a href="#" class="btn btn-sm btn-primary unfriend" id="friend{{$user->id}}" data-toggle="tooltip" data-id="{{$user->id}}" data-placement="top" title="Unfriend"data-popup="lightbox"> <i class="fa fa-user-times"></i></a>

			        @else
			        	@if($frequest == 0)
			        		@if($myfrequest == 0)
					<a href="javascript:;" id="friend{{$user->id}}" class="btn btn-sm btn-primary friendRequest" data-toggle="tooltip" data-placement="top" title="Add Friend" data-id="{{$user->id}}" data-popup="lightbox"> <i class="fa fa-user-plus"></i></a>
							@else
					<a href="javascript:;" id="friend{{$user->id}}" class="btn btn-sm btn-primary acceptRequest" data-toggle="tooltip" data-placement="top" title="Accept Request" data-id="{{$user->id}}" data-popup="lightbox"> <i class="fa fa-user-plus"></i></a>
							@endif
						@else
					<a href="javascript:;" id="friend{{$user->id}}" class="btn btn-sm btn-primary cancelRequest" data-toggle="tooltip" data-placement="top" title="Request Sent" data-id="{{$user->id}}" data-popup="lightbox"> <i class="fa fa-user-plus"></i></a>
						@endif
			        @endif

					@if($follow == 1)
			        <a href="javascript:;" id="follow{{$user->id}}" class="btn btn-sm btn-primary unfollow" data-id="{{$user->id}}" data-toggle="tooltip" data-placement="top" title="Unfollow" ><i class="fa icofont icofont-undo"></i></a>
			        @else
					<a href="javascript:;" id="follow{{$user->id}}" class="btn btn-sm btn-primary follow" data-id="{{$user->id}}" data-toggle="tooltip" data-placement="top" title="Follow" ><i class="fa icofont icofont-ui-social-link"></i></a>
			        @endif
			    </span>
			</div>
			</div>
		<div class="user-content"> <a href="{{url('connect/profile/'.$username.'/'.encrypt($user->id))}}"><h4 class="">{{ucfirst($user->first_name)}} {{ucfirst($user->last_name)}} </h4></a>
			<p class="m-b-0 text-muted">{{ App\User::find($user->id)->hasRole('Knitter') ? 'Knitter' : 'Designer' }}</p>
		</div>
		<p>
			<!--<div class="row justify-content-center">
				<div class="col-lg-12 text-center"> <i class="ti-location-pin"></i>
					<label class="custom-label">Michigan</label>
				</div>
			</div> -->
		</p>
		</div>
	</div>
</div>

@endforeach
@else

<div class="col-lg-12 col-xl-12 col-md-12 " id="noproducts">
    <div class="card custom-card skew-card">
            <div class="user-content card-bg m-l-40 m-r-40 m-b-40">
                <h3 class="m-t-40 text-muted">Connect with more crafters</h3>
                <h4 class="text-muted m-t-10 m-b-30">Filter by skills to find connections with similar interests to friend and follow!</h4>
            </div>
    </div>
	</div>

@endif
