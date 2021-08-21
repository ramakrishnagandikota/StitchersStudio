@if($comments->count() > 0)
@foreach($comments as $pc)
<?php
$voteCount = DB::table('product_vote_unvote')->where('comment_id',$pc->id)->where('product_id',$pc->product_id)->where('vote',1)->count();
$unvoteCount = DB::table('product_vote_unvote')->where('comment_id',$pc->id)->where('product_id',$pc->product_id)->where('unvote',1)->count();
?>
<div class="row">
<div class="col-sm-1 img-padding">
	@php
		if($pc->picture){
			$picture = $pc->picture;
		}else{
			$picture = "resources/assets/user.png";
		}
	@endphp
<img class="img-fluid" src="{{asset($picture)}}" style="border-radius: 50%;height: 50px;width: 50px;" alt="Generic placeholder image">
</div>
<div class="col-sm-4">
    <h6>{{ucwords($pc->name)}} <span>( {{$pc->created_at->diffForHumans()}} )  </span>
&nbsp;&nbsp;&nbsp;&nbsp;
	<?php
		for($x=1;$x<=$pc->rating;$x++) {
			echo '<i class="fa fa-star" aria-hidden="true"></i> &nbsp;';
		}

		while ($x<=5) {
			echo '<i class="fa fa-star-o" aria-hidden="true"></i> &nbsp;';
			$x++;
		}
	?>

    </h6>

@auth
<?php
$vote = DB::table('product_vote_unvote')->where('user_id',Auth::user()->id)->where('comment_id',$pc->id)->where('product_id',$pc->product_id)->where('vote',1)->count();
$unvote = DB::table('product_vote_unvote')->where('user_id',Auth::user()->id)->where('comment_id',$pc->id)->where('product_id',$pc->product_id)->where('unvote',1)->count();
?>
<ul class="comnt-sec">
<li><a href="javascript:;" class="voteCheck" data-name="vote" data-id="{{$pc->id}}"><i class="fa @if($vote == 1) fa-thumbs-up @else fa-thumbs-o-up @endif"aria-hidden="true"></i></a>
	(<span id="vote{{$pc->id}}">{{$voteCount}}</span>)
</li>
<li>
<a href="javascript:;" class="unvoteCheck" data-name="unvote" data-id="{{$pc->id}}">
<i class="fa @if($unvote == 1) fa-thumbs-down @else fa-thumbs-o-down @endif" aria-hidden="true"></i></a>
(<span id="unvote{{$pc->id}}">{{$unvoteCount}}</span>)
</li>
</ul>
@else
<ul class="comnt-sec">
<li><a href="javascript:;"><i class="fa fa-thumbs-o-up"aria-hidden="true"></i></a>
	(<span>{{$voteCount}}</span>)
</li>
<li>
<a href="javascript:;" >
<i class="fa fa-thumbs-o-down" aria-hidden="true"></i>
</a>
(<span>{{$unvoteCount}}</span>)
</li>
</ul>
@endauth
</div>
<div class="col-lg-7 ">
@auth
@if(Auth::user()->id == $pc->user_id)
<ul class="comnt-sec pull-right">
<li>
<a href="javascript:;" class="delete-comment" data-id="{{$pc->id}}">
<i class="fa fa-trash" aria-hidden="true"></i>
</a>
</li>
</ul>
@endif
@endauth
</div>
<div class="col-lg-12 m-t-15">
<div class="media-body productComments">
<p style="margin-bottom: 0.5rem;">
	{{$pc->comment}}
</p>
</div>
</div>
<div class="col-lg-12">
<hr>
</div>
</div>

@endforeach
{{$comments->links()}}
@else
<div class="row">
	<div class="col-sm-12 text-center" style="margin:auto;">
		No review's to show for this product
	</div>
</div>
@endif

<style type="text/css">
	.fa-star{
		color: #0d665c;
	}
	.rm-link{
		color: #0d665c !important;
	}
</style>

<script type="text/javascript">
	$readMoreJS.init({
		target: '.productComments p',
		numOfWords: 28,
		toggle: true,
		moreLink: 'read more ...',
		lessLink: 'read less'
	});
</script>
