<?php
    if(Auth::user()->picture){
    $photo = Auth::user()->picture;
    }else{
    $photo = 'https://via.placeholder.com/150?text='.Auth::user()->first_name;
    }
?>
<form  id="updatePost">
<div class="modal-header">
            <h6 class="modal-title">Edit post</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">

            <div class="row">
                <div class="col-lg-12">
            <div class="bg-white">
                <div class="post-new-contain row card-block">
                    <div class="col-md-1 col-xs-1 p-0 m-l-20">
                        <img src="{{ $photo }}" class="img-fluid img-radius"
                            alt="">
                    </div >
                    <input type="hidden" name="id" id="timelineid" value="{{$timeline->id}}">
                        @csrf
                        <div class="col-md-10 col-xs-10">
                            <textarea id="post_content" class="form-control post-input m-b-10" name="post_content" style="border: 1px solid #ccc;"
                                rows="3" cols="10" required=""
                                placeholder="Write something...">{{$timeline->post_content}}</textarea>
                        </div>


@if($timeline->tag_friends)
<div class="col-md-10 col-xs-10 " style="margin-left: 87px;">With
@php
$exp = explode(',', $timeline->tag_friends);
@endphp
@for($i=0; $i < count($exp); $i++)
 <?php  $frie = App\User::where('id',$exp[$i])->first(); ?>
    @if($i == 0)
     <b>{{ucfirst($frie->first_name)}} {{ucfirst($frie->last_name)}}</b>
    @elseif($i == (count($exp) - 1))
    and <b>{{ucfirst($frie->first_name)}} {{ucfirst($frie->last_name)}}</b>
    @else
    <b>{{ucfirst($frie->first_name)}} {{ucfirst($frie->last_name)}}</b>
    @endif
@endfor
</div>
@endif

@if($timeline->location)
<div class="col-md-10 col-xs-10 " style="margin-left: 87px;">
at {{$timeline->location}}
</div>
@endif

                </div>
          <div class="post-new-footer b-t-muted p-15">
                    <div class="col-sm-11 col-lg-11 m-l-30 hide" id="with">
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <label class="input-group-text"><i class="icofont icofont-ui-user text-muted m-0"
                                    title="Tag"></i></label>
                            </span>
                            <?php $exp1 = explode(',', $timeline->tag_friends); ?>

                             <select class="form-control" id="mySelect2" name="tag_friends[]" multiple >

                                @if($friends->count() > 0)
                                    @foreach($friends as $fri)
                                    <option value="{{$fri->id}}" @for($j=0;$j<count($exp1);$j++) @if($fri->id == $exp1[$j]) selected @endif @endfor >{{$fri->first_name}} {{$fri->last_name}}</option>
                                    @endforeach
                                @endif
                            </select>


                        </div>
                    </div>
                    <div class="col-sm-11 col-lg-11 m-l-30 hide" id="locate">
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <label class="input-group-text"> <i class="icofont icofont-location-pin text-muted m-0"
                                    title="Share location"></i></label>
                            </span>
                            <input type="text" id="share_location" class="form-control" name="location" placeholder="Share location" value="{{$timeline->location}}">
                        </div>
                    </div>

                            <span class="image-upload m-r-15"
                                title="Upload image">
                                <input type="file" name="files[]" id="filer_input1" multiple="multiple">
                            </span>

@if($timeline_images)

<div class="jFiler-items jFiler-row">
    <ul class="jFiler-items-list jFiler-items-grid">
    @foreach($timeline_images as $tim)
        <li class="jFiler-item" data-jfiler-index="0" id="image{{$tim->id}}" style="">
            <div class="jFiler-item-container">
                <div class="jFiler-item-inner">
                    <div class="jFiler-item-thumb">
                        <div class="jFiler-item-thumb-image"><img src="{{$tim->image_path}}" draggable="false">
                        </div>
                    </div>
                    <div class="jFiler-item-assets jFiler-row">
                        <ul class="list-inline pull-right">
                            <li>
                                <a data-id="{{$tim->id}}" href="javascript:;" class="icon-jfi-trash jFiler-item-trash-action deleteImage"></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </li>
    @endforeach
    </ul>
</div>
@endif
                </div>

            </div>
            </div>
      </div>
        </div>
        <div class="modal-footer">
            <div class="custom-select">
                {{ $group->group_name }}
            </div>

            <button type="button" class="btn theme-outline-btn float-right" onclick="closePopup({{$timeline->id}})" data-dismiss="modal">Cancel</button>
            <span><button type="button" id="post-update"
                class="btn theme-btn waves-effect waves-light float-right"
                >Update</button></span>
          </div>
</form>

<!-- jquery file upload js -->
<script src="{{ asset('resources/assets/files/assets/pages/jquery.filer/js/jquery.filer.min.js') }}"></script>

<script src="{{ asset('resources/assets/files/assets/pages/filer-modified/jquery.fileuploads.init.js') }}" type="text/javascript"></script>

<style type="text/css">
    .select2-search__field{
        width: 200px !important;
        padding: 3px;
    }
    .select2{
        width: 90% !important;
    }
    .select2-container .select2-selection--multiple{
        min-height: 37px !important;
    }
</style>
