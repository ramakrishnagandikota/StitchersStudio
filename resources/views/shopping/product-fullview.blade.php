@extends('layouts.shopping')
@section('title',$product->product_name)
@section('content')

<!-- section start -->
<section>
<div class="collection-wrapper card p-15">
<div class="container">
<div class="row">
<div class="col-lg-4">
<div class="product-slick">

@if($product_images->count() > 0)
	@foreach($product_images as $pi)
<div><img src="{{ $pi->image_medium }}" alt="" class="img-fluid blur-up lazyload image_zoom_cls-0">
</div>
	@endforeach
@endif
<!-- 
<div><img src=" asset('resources/assets/KnitfitEcommerce/assets/images/pro3/2-1.jpg') }}" alt="" class="img-fluid blur-up lazyload image_zoom_cls-1">
</div> -->
<!-- <div><img src="../assets/images/pro3/1-2.jpg" alt="" class="img-fluid blur-up lazyload image_zoom_cls-2"></div>
<div><img src="../assets/images/pro3/1-3.jpg" alt="" class="img-fluid blur-up lazyload image_zoom_cls-3"></div> -->
</div>
<div class="row">
<div class="col-12 p-0">
<div class="slider-nav">
@if($product_images->count() > 0)
	@foreach($product_images as $pi)
<div><img src="{{ $pi->image_small }}" alt="" class="img-fluid blur-up lazyload">
</div>
	@endforeach
@endif

<!-- <div><img src="../assets/images/pro3/1-2.jpg" alt="" class="img-fluid blur-up lazyload"></div>
<div><img src="../assets/images/pro3/1-3.jpg" alt="" class="img-fluid blur-up lazyload"></div> -->
</div>
</div>
</div>
</div>
<div class="col-lg-5">
<div class="product-right product-description-box">
<h2 style="margin-bottom:5px;">{{ ucfirst($product->product_name) }}</h2>
@if($product->is_custom == 1)
<div class="kf-custom-tag product-icon">
<div><img src="{{ asset('resources/assets/files/assets/images/logoOld.png') }}"><span class="tag-text">Custom pattern</span></div>
</div>
@endif
<div class="rating three-star mb-2">
	@php 
$rating = DB::select(DB::raw("select SUM(rating) as rat from product_comments where product_id = '".$product->id."' "));
$totrate = DB::table('product_comments')->where('product_id',$product->id)->count();
@endphp

@if($totrate > 0)
				@foreach($rating as $rat) 
				<?php $starNumber = number_format($rat->rat / $totrate,1);

				 ?>
				<?php
						for($x=1;$x<=$starNumber;$x++) {
							echo '<i class="fa fa-star" aria-hidden="true"></i> &nbsp;';
						}
						
						while ($x<=5) {
							echo '<i class="fa fa-star-o" aria-hidden="true"></i> &nbsp;';
							$x++;
						}
					?>
					&nbsp; 
				@endforeach
				@else
			<?php for($x=1;$x<=5;$x++) {
        		echo '<i class="fa fa-star-o" aria-hidden="true"></i> &nbsp;';
    			} ?>
    		@endif	
</div>
<div class="product-icon mb-3">
<!--
<ul class="product-social">
<li><a href="#"><i
class="fa fa-facebook"></i></a>
</li>
<li><a href="#"><i
class="fa fa-twitter"></i></a>
</li>
</ul>
-->
<button class="wishlist-btn" data-id="{{$product->id}}" >
    @auth
    <i class="fa fa-heart @if($wishlist) @if($wishlist->user_id == Auth::user()->id) fill @endif @endif" style="border-left:none;"></i>
    @if($wishlist) 
    @if($wishlist->user_id == Auth::user()->id)
    <span class="title-font">Remove from wishlist</span>
    @endif
    @else
    <span class="title-font">Add to wishlist</span>
    @endif

    @else
    <i class="fa fa-heart-o"></i>
    <span class="title-font">Add to wishlist</span>
    @endauth
    
</button>
</div>
<div class="row product-accordion card p-b-10">
<div class="col-sm-12">
<div class="accordion theme-accordion" id="accordionExample">
<div class="">
<div class="card-header outline-row" id="headingOne" data-toggle="collapse" data-target="#collapseOne" style="margin-right:5px;margin-left: 5px;">
<h5 class="mb-0"><button
        class="btn btn-link"
        type="button"
        aria-expanded="true"
        aria-controls="collapseOne">Pattern Description</button>
</h5>
<i class="fa fa-caret-down pull-right micro-icons m-t-15"></i>
</div>
<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
<div class="p-10" id="description">
{!! $product->product_description !!}
</div>
</div>
</div>

<div class="">
<div class="card-header outline-row" style="margin-right:5px;margin-left: 5px;" id="headingthree" data-toggle="collapse" data-target="#collapsethree">
<h5 class="mb-0"><button
        class="btn btn-link collapsed"
        type="button"
        aria-expanded="false"
        aria-controls="collapseTwo">Pattern Details</button>
</h5>
<i class="fa fa-caret-down pull-right micro-icons m-t-15"></i>
</div>

<div id="collapsethree" class="collapse" aria-labelledby="headingthree" data-parent="#accordionExample">
<div class="p-10">
{!! $product->short_description !!}
</div>
</div>
</div>

<div class="">
<div class="card-header outline-row" style="margin-right:5px;margin-left: 5px;" id="headingthree" data-toggle="collapse" data-target="#collapsethree3">
<h5 class="mb-0"><button
        class="btn btn-link collapsed"
        type="button"
        aria-expanded="false"
        aria-controls="collapseTwo">Materials</button>
</h5>
<i class="fa fa-caret-down pull-right micro-icons m-t-15"></i>
</div>

<div id="collapsethree3" class="collapse" aria-labelledby="headingthree" data-parent="#accordionExample">
<div class="p-10">
{!! $product->material_needed !!}
</div>
</div>
</div>


<div class="">
<div class="card-header outline-row" style="margin-right:5px;margin-left: 5px;" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo">
<h5 class="mb-0"><button
        class="btn btn-link collapsed"
        type="button"
        aria-expanded="false"
        aria-controls="collapseTwo">Gauge instruction</button>
</h5>
<i class="fa fa-caret-down pull-right micro-icons m-t-15"></i>
</div>

<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
<div class="p-10" >
{!! $product->gauge_description !!}
</div>
</div>
</div>





<div class="">
<div class="card-header outline-row" style="margin-right:5px;margin-left: 5px;" id="headingfive" data-toggle="collapse" data-target="#collapsefive">
<h5 class="mb-0"><button
        class="btn btn-link collapsed"
        type="button"
        aria-expanded="false"
        aria-controls="collapsefive">Write
        a review</button>
</h5>
<i class="fa fa-caret-down pull-right micro-icons m-t-15"></i>
</div>

<div id="collapsefive" class="collapse" aria-labelledby="headingfive" data-parent="#accordionExample">
<div class="p-10">
<form class="theme-form" id="comments-form">
<div class="form-row">
<div class="col-md-12">
<div class="media">
<label>Rating</label>
<div class="media-body ml-3">
<div class="three-star" id="demo">

</div>
<span class="red hide rating">Please add rating</span>
</div>
</div>
</div>
<input type="hidden" name="rating" id="rating" value="0">
<input type="hidden" name="id" value="{{base64_encode($product->id)}}">
<div class="col-md-6 m-t-10">
<label for="name">Name</label>
<input type="text" class="form-control" name="name" id="name" placeholder="Enter your name" required @auth value="{{Auth::user()->first_name}} {{Auth::user()->last_name}}"  readonly @endauth >
</div>
<div class="col-md-6 m-t-10">
<label for="email">Email</label>
<input type="text" class="form-control" name="email" id="email" placeholder="Email" required @auth value="{{Auth::user()->email}}" readonly @endauth>
</div>
<div class="col-md-12 m-b-10 m-t-15">
<label for="review">Review title
</label>
<input type="text" class="form-control" name="comment" id="comment" placeholder="Enter your review title" required >
<span class="red hide comment">Please add comment</span>
</div>

<div class="col-md-12 m-t-10">
<button class="btn btn-block theme-outline-btn waves-effect waves-light" type="submit">Submit your review
</button>
</div>
</div>
</form>
</div>
</div>
</div>
</div>

</div>
</div>
</div>




</div>

<div class="col-lg-3">
<div class="product-right product-form-box">

<?php 
if($product->sale_price_start_date <= date('Y-m-d') && $product->sale_price_end_date >= date('Y-m-d')){
    if($product->sale_price){
        if($product->sale_price == 0 || $product->sale_price == '0.00'){
            echo '<h4>Free</h4>';
        }else{
            $perc = ($product->sale_price / $product->price) * 100;
            $percent = 100 - $perc;
            $price = number_format($product->sale_price,2);
            echo '<h4>';
            echo '<del>$'.number_format($product->price,2).'</del>';
            echo '<span>'. (int) $percent.'% off</span>';
            echo '</h4>';
        }
        
    }else{
        if($product->price == 0 || $product->price == '0.00'){
             echo '<h4>Free</h4>';
        }else{
            echo '<h4>$'.number_format($product->price,2).'</h4>';
        }
        
    }
}else{
        if($product->price == 0 || $product->price == '0.00'){
             echo '<h4>Free</h4>';
        }else{
            echo '<h4>$'.number_format($product->price,2).'</h4>';
        }
}
?>

<!-- <ul class="color-variant">
<li class="bg-light0"></li>
<li class="bg-light1"></li>
<li class="bg-light2"></li>
</ul> -->
<div class="product-description border-product">
<?php 
if($product->sale_price_start_date <= date('Y-m-d') && $product->sale_price_end_date >= date('Y-m-d')){
    if($product->sale_price){
        if($product->sale_price == 0 || $product->sale_price == '0.00'){
            $price = number_format($product->sale_price,2);
        }else{
            $price = number_format($product->sale_price,2);
        }
        
    }else{
        $price = number_format($product->price,2);
    }
}else{
        $price = number_format($product->price,2);
}
?>
</div>

<div class="product-buttons" style="display: inline-flex;">
    @auth
    @if($booking > 0)
        <p class="text-center btn theme-btn waves-effect waves-light">This product is already purchased.</p>
    @else
        <a href="#" data-toggle="modal" data-target="#addtocart" class="btn theme-outline-btn waves-effect waves-light addToCart hide" data-id="{{$product->id}}"  >Add to
cart</a> 
    @if($price == 0 || $price == '0.00')
        <a href="{{url('addToProjectLibrary/'.$product->pid)}}" class="btn theme-btn waves-effect waves-light">Add to project library</a>
    @else
        <a href="{{url('buynow/'.$product->pid)}}" class="btn theme-btn waves-effect waves-light">Buy now</a>
    @endif
    
    @endif

    @else
    <a href="#" data-toggle="modal" data-target="#addtocart" class="btn theme-outline-btn waves-effect waves-light addToCart" data-id="{{$product->id}}" >Add to
cart</a> 
    <a href="{{url('buynow/'.$product->pid)}}" class="btn theme-btn waves-effect waves-light">Buy now</a>
    @endauth
</div>


</div>
</div>
</div>
</div>
</div>


<div class="card">
<div class="card-header outline-row" style="margin-right:5px;margin-left: 5px;">
<h5 class="mb-0">Reviews</h5>
</div>

<div class="col-md-12" >
<div class="p-10 m-t-10" id="product-comments">

<img style="position: relative;height: 100px;left: 500px; z-index: 100000;" src="{{asset('resources/assets/login-gif-images-8.gif')}}" />
</div>
</div>
</div>
</section>
<!-- Section ends -->

@endsection
@section('footerscript')
<style type="text/css">
    .hide{
        display: none;
    }
    .red{
        color: #bc7c8f;
    font-weight: 500;
    }
    .fill{
        color: #bb7c8f !important;
    }
    .para{
            margin-bottom: 0;
    line-height: 1.5em;
    font-size: 14px;
    color: #777;
    }
    .disabled{
        background: #0d665c8c !important;
        border: 1px solid #0d665c8c !important;
        pointer-events: none;
        cursor: none;
    }
	.kf-custom-tag img {width: 46px;margin-left: 2px;margin-top: -3px;}
    .kf-custom-tag{
    font-size: 10px;
    margin-bottom: 5px;
    width: 100%;
    }
    .kf-custom-tag div{    border: .6px solid #dddddd;
    background: #fff;
    width: 144px;
    border-radius: 2px;
    padding: 3px;
    opacity: .9;
    box-shadow: 2px 2px 3px #dddddd;}
</style>
    <!--Slick slider css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/KnitfitEcommerce/assets/css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/KnitfitEcommerce/assets/css/slick-theme.css') }}">

    <!-- Zoom js-->
    <script src="{{ asset('resources/assets/KnitfitEcommerce/assets/js/jquery.elevatezoom.js') }}"></script>
<script type="text/javascript" src="{{asset('resources/assets/rating/stars.min.js')}}"></script>
<script type="text/javascript" src="{{asset('resources/assets/readmore/readMoreJS.min.js')}}"></script>

    <script type="text/javascript">
        $(function(){

        $("#description ul").addClass('ulli');
        //var len = $("#description ul li").length;
        //$("#description ul li").createElement('p');
        $("#description ul li").attr('type','circle').attr('class','para');
            var product_id = {{$product->id}};
            var URL = '{{url("get-comments")}}/'+product_id;
            getComments(URL);



           // getProductComments();

            $("#demo").stars({
            stars: 5,
            emptyIcon  : 'fa-star-o',
            filledIcon : 'fa-star',
            color      : '#0d665c',
            text : [],
            click: function(index) {
                $("#rating").val(index);
            }
            });

             $(document).on('click','.addToCart',function(){
        /* var is_login = $("#is_login").val();
        if(!is_login){
            addProductCartOrWishlist('fa-times','Error','Please login to add product to cart.')
            return false;
        } */
        var id = $(this).attr('data-id');
        var Data = 'product_id='+id;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

            $.ajax({
                url : '{{url("add-to-cart")}}',
                type : 'POST',
                data : Data,
                beforeSend: function(){
                
                },
                success : function(res){
                    if(res.error == 'fail'){
                       addProductCartOrWishlist('fa-times','Oops!','This product is already in cart.','danger'); 
                    }else{
                    addProductCartOrWishlist('fa-check','Success','Product Successfully added to cart','success');
                    }
                },
                complete : function(){
                    getCart();
                },
                error : function(jQxhr,textStatus){
                    if(jQxhr.statusText == 'Unauthorized'){
                        addProductCartOrWishlist('fa-times','Error','Please login to add product to cart.','danger');
                    }
                }
            }); 
    });



$(document).on('submit','#comments-form',function(e){
    e.preventDefault();
    var Data = $("#comments-form").serializeArray();
    var rating = $("#rating").val();
    var comment = $("#comment").val();
    var er = [];
    var cnt = 0;

    if(rating == 0){
        $(".rating").removeClass('hide');
        er+=cnt+1;
    }else{
        $(".rating").addClass('hide');
    }

    if(comment == 0){
        $(".comment").removeClass('hide');
        er+=cnt+1;
    }else{
        $(".comment").addClass('hide');
    }
    
    if(er != ""){
        return false;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url : '{{url("addComments")}}',
        type : 'POST',
        data : Data,
        beforeSend : function(){
            $(".loader-bg").show();
        },
        success : function(res){
            if(res.fail){
                addProductCartOrWishlist('fa-times','Oops!',res.fail,'danger'); 
            }else{
                getComments(URL);
                $("#comments-form")[0].reset();
                addProductCartOrWishlist('fa-check','success',res.success,'success'); 
            }
        },
        complete : function(){
            $(".loader-bg").hide();
        }
    })
});


 $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();

$('#product-comments').html('<img style="position: relative;height: 100px;left: 500px; z-index: 100000;" src="{{asset('resources/assets/login-gif-images-8.gif')}}" />');

        var url = $(this).attr('href');
        getComments(url);
        //window.history.pushState("", "", url);
    });

$(document).on('click','#loadComments',function(){
    $('#product-comments').html('<img style="position: relative;height: 100px;left: 500px; z-index: 100000;" src="{{asset('resources/assets/login-gif-images-8.gif')}}" />');
    getComments(URL);
});

$(document).on('click','.wishlist-btn',function(){
    var dd = $(this).find('i').hasClass('fill');
    var id = $(this).attr('data-id');

    if(dd){
        var wishlist = 'remove';
    }else{
        var wishlist = 'add';
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.post('{{url("wishlist")}}',{ product_id: id,wishlist: wishlist },function(res){
        if(res.success){

    if(dd){
        $(this).find('i').removeClass('fill');
        $(this).find('span').html('Add to wishlist');
    }else{
        $(this).find('i').addClass('fill');
        $(this).find('span').html('Remove from wishlist');
    }

            addProductCartOrWishlist('fa-check','success',res.success,'success');
        }else{
            addProductCartOrWishlist('fa-times','Oops!',res.fail,'danger');
        }
    });
    
});


$(document).on('click','.delete-comment',function(){
    var id = $(this).attr('data-id');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    if(confirm('Are you sure want to delete this comment ?')){
        $.post('{{url("delete-comment")}}',{ product_id: id },function(res){
        if(res.success){
            getComments(URL);
            addProductCartOrWishlist('fa-check','success',res.success,'success');
        }else{
            addProductCartOrWishlist('fa-times','Oops!',res.fail,'danger');
        }
    });
    }
});


$(document).on('click','.voteCheck',function(){
    var name = $(this).attr('data-name');
    var comment_id = $(this).attr('data-id');
    var voteCount = $('#vote'+comment_id).html();
    var unvoteCount = $('#unvote'+comment_id).html();
    var alreadyVoted = $(this).find('i').hasClass('fa-thumbs-up');
    var vcount;

if(alreadyVoted == true){
    $(this).find('i').removeClass('fa-thumbs-up').addClass('fa-thumbs-o-up');
    vcount=parseInt(voteCount)-1;
    $('#vote'+comment_id).html(vcount);
    var vote = 0;
}else{
    $(this).find('i').removeClass('fa-thumbs-o-up').addClass('fa-thumbs-up');
    vcount=parseInt(voteCount)+1;
    $('#vote'+comment_id).html(vcount);
    var vote = 1;
}



    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var Data = 'vote='+vote+'&comment_id='+comment_id+'&product_id='+product_id;

    $.ajax({
        url : '{{url("voteCheck")}}',
        type : 'POST',
        data : Data,
        beforeSend : function(){

        },
        success : function(res){
            if(res){
                addProductCartOrWishlist('fa-check','success',res.success,'success');
            }else{
                addProductCartOrWishlist('fa-times','error',res.fail,'danger');
            }
        },
        complete : function(){

        }
    });
});



$(document).on('click','.unvoteCheck',function(){
    var name = $(this).attr('data-name');
    var comment_id = $(this).attr('data-id');
    var unvoteCount = $('#unvote'+comment_id).html();
    var alreadyunVoted = $(this).find('i').hasClass('fa-thumbs-down');
    var vcount;

if(alreadyunVoted == true){
    $(this).find('i').removeClass('fa-thumbs-down').addClass('fa-thumbs-o-down');
    vcount=parseInt(unvoteCount)-1;
    $('#unvote'+comment_id).html(vcount);
    var unvote = 0;
}else{
    $(this).find('i').removeClass('fa-thumbs-o-down').addClass('fa-thumbs-down');
    vcount=parseInt(unvoteCount)+1;
    $('#unvote'+comment_id).html(vcount);
    var unvote = 1;
}



    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var Data = 'unvote='+unvote+'&comment_id='+comment_id+'&product_id='+product_id;

    $.ajax({
        url : '{{url("unvoteCheck")}}',
        type : 'POST',
        data : Data,
        beforeSend : function(){

        },
        success : function(res){
            if(res){
                addProductCartOrWishlist('fa-check','success',res.success,'success');
            }else{
                addProductCartOrWishlist('fa-times','error',res.fail,'danger');
            }
        },
        complete : function(){

        }
    });
});

        });

function addProductCartOrWishlist(icon,status,msg,info){
        $.notify({
            icon: 'fa '+icon,
            title: status+'!',
            message: msg
        },{
            element: 'body',
            position: null,
            type: info,
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


    function getComments(url) {
        $.ajax({
            url : url
        }).done(function (data) {
            $("#product-comments").html(data);
        }).fail(function () {
            var Data = '<div class="row"><div class="col-sm-12 text-center" style="margin:auto;">Unable to load the review`s. <a href="javascript:;" id="loadComments" >Click here</a> to load reviews.</div></div>';
            $("#product-comments").html(Data);

        });
    }


    </script>
@endsection