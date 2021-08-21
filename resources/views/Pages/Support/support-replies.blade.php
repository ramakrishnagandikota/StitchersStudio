@if($reply->count() > 0)
    @foreach($reply as $rep)
        @php
        $user = App\User::where('id',$rep->user_id)->first();
        if($user->picture){
            $pic = $user->picture;
        }else{
            $pic = Avatar::create($user->first_name)->toBase64();
        }
        $commentImages = $rep->SupportCommentsAttachments()->where('attachment_type','!=','pdf')->get();
        $commentPdf = $rep->SupportCommentsAttachments()->where('attachment_type','=','pdf')->get();
        @endphp
        <div class="col-lg-12" >
            <div class="media">
                <div class="media-right friend-box">
                    <a href="#">
                        <img class="media-object img-radius" src="{{ $pic }}" alt="">
                    </a>
                </div>
                <div class="media-body">
                    <h6 class="m-t-10">
                        {{ $user->first_name }} {{ $user->last_name }}
                        @if($user->hasRole('Admin'))
                            <span class="chips">Support executive</span>
                        @else
                            <span class="chips">Designer</span>
                        @endif
                        <span style="font-size:12px;color:#b3b3b3;margin-left: 15px;"><i class="icofont icofont-wall-clock f-12"></i> {{ $rep->updated_at->diffForHumans() }}</span></h6>
                    <div class="msg-reply chat-box-receive m-t-5">{!! $rep->support_comment !!}</div>
                    @if($rep->SupportCommentsAttachments()->count() > 0)
                        @if($commentImages->count() > 0)
                            <div class="gg-container col-md-12 gg-1" >
                                <div class="gg-box dark square-2" id="square-2{{$rep->id}}">
                                    <?php $i=1; ?>
                                    @foreach($commentImages as $ci)
                                        <img data-id="{{$i}}" class=" self_posted all hide sectionContent" src="{{ $ci->attachment_url }}">
                                        <?php $i++; ?>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if($commentPdf->count() > 0)
                            <hr>
                            @foreach($commentPdf as $cpdf)
                                <div class="col-md-1 pdf">
                                    <a href="{{ $cpdf->attachment_url }}" target="_blank"><i class="fa fa-file-pdf-o fa-5x"></i></a>
                                </div>
                            @endforeach
                        @endif
                    @endif
                </div>
            </div>
        </div>
    @endforeach
        <br>
        <div class="text-center m-t-20">
            {{ $reply->links('vendor.pagination.bootstrap-4') }}
        </div>
@else
        <div class="col-md-12 text-center">No reply's to show for this ticket.</div>
@endif
