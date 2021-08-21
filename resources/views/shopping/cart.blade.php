<div class="dropdown-toggle" data-toggle="dropdown">
<i class="typcn typcn-shopping-cart"></i>
@if($data)
<span class="badge bg-c-red">{{ $data ? count($data) : 0 }}</span>
@endif
</div>
<ul class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
<li>
<h5>Your cart</h5>
<ul class="header-dropdown">
<li  class="onhover-div mobile-cart">
    <ul class="show-div shopping-cart" >
@if(Session::has('cart'))

@foreach($data as $da)
<?php

$images = DB::table("product_images")->where('product_id',$da['item']['id'])->where('main_photo',1)->get();
$filimages = DB::table("product_images")->where('product_id',$da['item']['id'])->get();
if(count($images) > 0){
        foreach($images as $im);

        if($im->image_small == ""){
            $image = 'http://placehold.it/246x368/ffffff&text=Image Coming Soon';
        }else{
            $image = $im->image_small;
        }

        if($im->image_small == ""){
            $image1 = 'http://placehold.it/246x368/ffffff&text=Image Coming Soon';
        }else{
            $image1 = $im->image_small;
        }

    }else{
        $image = 'http://placehold.it/246x368/ffffff&text=Image Coming Soon';
        $image1 = 'http://placehold.it/246x368/ffffff&text=Image Coming Soon';
    }
?>
<li>
    <div class="media">
        <a href="#"><img class="mr-3" src="{{ $image }}" alt="Generic placeholder image"></a>
        <div class="media-body">
            <a href="{{url('product/'.$da['item']['pid'].'/'.$da['item']['slug'])}}"><h6>{{$da['item']['product_name']}}</h6></a>
            <h6 class="m-l-10">{{$da['qty']}} x @if($da['item']['sale_price'])
                                ${{number_format($da['item']['sale_price'],2)}}
                            @else
                                @if($da['item']['price'] == 0) FREE @else
                                ${{number_format($da['item']['price'],2)}}
                                @endif
                            @endif</h6>
        </div><a href="javascript:;" class="remove-item" data-id="{{$da['item']['id']}}" ><i class="fa fa-trash" aria-hidden="true"></i></a>
    </div>
</li>
@endforeach

<li>
    <div class="buttons text-center">
        <a href="{{url('cart')}}" class="view-cart theme-outline-btn">View cart</a>
        <a href="{{url('checkout')}}" class="checkout theme-btn">Checkout</a>
    </div>
</li>
<li>
    <div class="total text-right">
        <h5 class="f-w-500 text-muted m-b-10" style="margin-right: -20px;">Subtotal : @if($totalPrice == 0) FREE @else ${{number_format($totalPrice,2)}} @endif</h5>
    </div>  <hr class="m-b-5 m-t-5">
</li>
@else
<li>
    <div class="total text-right">
        <h5 class="f-w-500 text-muted m-b-10" style="margin-right: -20px;text-align:center;">No items to show in cart</h5>
    </div>  <hr class="m-b-5 m-t-5">
</li>

@endif
    </ul>
</li>

</ul>
</li>
</ul>
