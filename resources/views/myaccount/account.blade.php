@extends('layouts.shopping')
@section('title','My account')
@section('content')
<!-- section start -->
<section class="section-b-space">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="account-sidebar"><a class="popup-btn">Newsletter info</a></div>
                <div class="dashboard-left">
                    <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> back</span></div>
                    <div class="block-content card">
					<h4 class="card-header m-b-10">Account</h4>
                    @include('layouts.myaccount-menu')
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="dashboard-right">
                    <div class="dashboard card">
                        <div class="page-title">
                          
<div class="box-account box-info">
                            <div class="box-head">
                                <h2>Newsletter info</h2></div>
                            <div class="row">
                                <!-- <div class="col-sm-6">
                                    <div class="box b_n">
                                        <div class="box-title">
                                            <h3>Contact information</h3><a href="#">Edit</a></div>
                                        <div class="box-content">
                                            <h6>MARK JECNO</h6>
                                            <h6>MARk-JECNO@gmail.com</h6>
                                            <h6>&nbsp;</h6></div>
                                    </div>
                                </div> -->
                                <div class="col-sm-12">
                                    <div class="box b_n">
                                        <div class="box-title">
                                            <h3>Newsletters</h3><a href="#" class="editvalue">Edit</a><a href="#" class="savevalue">Save</a></div>
                                        <div class="box-content">
                                            @if($newsletters)
                                            <p id="novalue">You are currently subscribed to newsletters for <b>{{$newsletters->email}}</b>. <a href="{{url('newsletter/unsubscribe/'.$newsletters->token)}}">Click here</a> to unsubscribe</p> 
                                            <input type="text" class="form-control" name="email" id="edit-newsletter" placeholder="Enter your email" required="required" value="{{$newsletters->email}}">
                                            @else
                                            <p id="novalue">You are currently not subscribed to any newsletter.</p> 
                                            <input type="text" class="form-control" name="email" id="edit-newsletter" placeholder="Enter your email" required="required">
                                            @endif
                                            <span class="red hide email">Email field is required.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- section end -->
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
	.myaccount{
        display: none;
    }
</style>
<script>
$(".savevalue").hide();
$("#edit-newsletter").hide();
$("#novalue").show()    
$(".editvalue").click(function()
{
$(".savevalue").show();
$(".editvalue").hide();
$("#edit-newsletter").toggle();
$("#novalue").toggle()
}
)
$(".savevalue").click(function(){

var email = $("#edit-newsletter").val();

if(!email){
    $(".email").removeClass('hide');
    return false;
}else{
    $(".email").addClass('hide');
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(".loader-bg").show();

$.post('{{url("subscribe-newsletters")}}',{email : email},function(res){
    if(res.success){
        $(".loader-bg").hide();
        addProductCartOrWishlist('fa-check','success',res.success);
        location.reload();
    }else{
        addProductCartOrWishlist('fa-times','Oops!',res.fail);
    }
});

    
});


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