<?php

$images = DB::table("product_images")->where('product_id',$product->id)->where('main_photo',1)->get();
$filimages = DB::table("product_images")->where('product_id',$product->id)->get();
if(count($images) > 0){
        foreach($images as $im);

        if($im->image_small == ""){
            $image = 'http://placehold.it/246x368/ffffff&text=Image Coming Soon';
        }else{
            $image = $im->image_small;
        }

        if($im->image_medium == ""){
            $image1 = 'http://placehold.it/246x368/ffffff&text=Image Coming Soon';
        }else{
            $image1 = $im->image_medium;
        }

    }else{
        $image = 'http://placehold.it/246x368/ffffff&text=Image Coming Soon';
        $image1 = 'http://placehold.it/246x368/ffffff&text=Image Coming Soon';
    }
?>
<div class="col-lg-6 col-xs-12">
                        <div class="quick-view-img"><img src="{{$image}}" alt="" class="img-fluid blur-up lazyload"></div>
                    </div>
                    <div class="col-lg-6 rtl-text">
                        <div class="product-right">
                            <h2>{{ucwords($product->product_name)}}</h2>
                            @if(empty($product->sale_price))
                            @if($product->price == 0)
                            <h3>FREE</h3>
                            @else
                            <h3>$ {{$product->price}}</h3>
                            @endif
                        @else
                        @if($product->sale_price == 0)
                            <h3>FREE</h3>
                            @else
                            <h3>$ {{$product->sale_price}}</h3>
                            @endif
                        @endif
                            <!-- <ul class="color-variant">
                                <li class="bg-light0"></li>
                                <li class="bg-light1"></li>
                                <li class="bg-light2"></li>
                            </ul> -->
                            <div class="border-product">
                                <h6 class="product-title">product details</h6>
                                <p>{!! Str::limit($product->product_description,550) !!} &nbsp; <a href="{{url('product/'.$product->pid.'/'.$product->slug)}}">Read more</a></p>

                            </div>
                            <div class="product-description border-product">
                                <!-- <div class="size-box">
                                    <ul>
                                        <li class="active"><a href="#">s</a></li>
                                        <li><a href="#">m</a></li>
                                        <li><a href="#">l</a></li>
                                        <li><a href="#">xl</a></li>
                                    </ul>
                                </div> -->
                                <h6 class="product-title">quantity : 1</h6>
                                <input type="hidden" name="quantity" id="quantity" class="form-control input-number" value="1">
                              <!--  <div class="qty-box">
                                    <div class="input-group"><span class="input-group-prepend"><button type="button" class="btn quantity-left-minus" data-type="minus" data-field=""><i class="ti-angle-left"></i></button> </span>
                                        <input type="text" name="quantity" id="quantity" class="form-control input-number" value="1"> <span class="input-group-prepend"><button type="button" class="btn quantity-right-plus" data-type="plus" data-field=""><i class="ti-angle-right"></i></button></span></div>
                                </div> -->
                            </div>
                            <div class="product-buttons">
                                <!--<a href="javascript:;"  class="btn btn-solid addToCart" id="addToCart" data-id="{{$product->id}}">Add to cart</a> -->
                                <a href="{{url('product/'.$product->pid.'/'.$product->slug)}}" class="btn btn-solid">View detail</a>
                            </div>
                        </div>
                    </div>
