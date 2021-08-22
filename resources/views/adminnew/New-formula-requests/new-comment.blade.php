@foreach($fcomments as $comment)
    <?php
    if(Auth::user()->picture){
        $pic = Auth::user()->picture;
    }else{
        $pic = Avatar::create($comment->first_name)->toBase64();
    }
    $user = App\User::find($comment->user_id);
    ?>
    <div class="col-lg-12 comments">
        <div class="media">
            <div class="media-right friend-box">
                <a href="#">
                    <img class="media-object img-radius" src="{{ $pic }}" alt="">
                </a>
            </div>
            <div class="media-body">
                <h6 class="m-t-10">{{ $comment->first_name }} {{ $comment->last_name }} <span style="font-size:12px;color:#b3b3b3;margin-left: 15px;"><i class="icofont icofont-wall-clock f-12"></i> {{ $comment->created_at->diffForHumans() }}</span>
                    @if($user->hasRole('Admin')) <span class="chips">Admin</span> @endif
                </h6>
                <div class="msg-reply @if($comment->user_id == Auth::user()->id) chat-box-receive @else chat-box-posted @endif p-10 f-14 m-t-15">{!! $comment->comments !!}</div>
            </div>
        </div>
    </div>
@endforeach
