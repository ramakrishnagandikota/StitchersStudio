@extends('layouts.adminnew')
@section('title','Feedback')
@section('section1')

<div class="page-body">
    <div class="row">
        <div class="col-lg-12"><h5 class="theme-heading p-10"></h5></div>
    </div>
    <div class="col-lg-12">
        <div class="row users-card">
            <div class="col-lg-3">
                <h5 class="m-b-20">By Date Range</h5>                       	 
                <input type="text" id="daterange" class="form-control" placeholder="Please add a date for search">                         
                <button class="btn theme-btn btn-sm m-t-20" id="searchFeedback"><i class="fa fa-search" style="color: #ffffff;"></i> Search </button>
                <button class="btn btn-danger btn-sm m-t-20" onclick="feedbacks();"> Clear </button>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="card bg-white p-relative">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-lg-12">
                                <h5 class="m-b-20">Feedback received</h5>
                                <hr>
				<div id="feedbacks">
					<img style="position: relative;height: 100px;left: 400px; z-index: 100000;" src="{{asset('resources/assets/login-gif-images-8.gif')}}" />
				</div>
                                
                                
                                </div>
                        </div>
                    </div>
                    <!-- New feedback --> 
                </div>

            </div>
        </div>
        </div>
</div>
@endsection
@section('footerscript')
<style type="text/css">
	.daterangepicker .input-mini{
		text-align: center !important; 
	}
</style>
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/daterange/daterangepicker.css') }}">
<script type="text/javascript" src="{{ asset('resources/assets/daterange/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/daterange/daterangepicker.js') }}"></script>


<script type="text/javascript">
	$(function(){
		$('#daterange').daterangepicker();
		feedbacks();


 $(document).on('click', '.pagination a', function(e) {
	e.preventDefault();

	var id = $(this).parent().parent().parent().parent().attr('id');
	$('#feedbacks').html('<img style="position: relative;height: 100px;left: 400px; z-index: 100000;" src="{{asset('resources/assets/login-gif-images-8.gif')}}" />');
        var url = $(this).attr('href');
        var cc = url.split('?');
        if(cc[0] == 'https://knitfitnew.test:4434/adminnew/search-feedback'){
            feedbacksearch(url);
        }else{
            feedbacks(url);
        }
    });

	$(document).on('click','#loadComments',function(){
		var id = $(this).parent().parent().parent().attr('id');
		$('#feedback').html('<img style="position: relative;height: 100px;left: 400px; z-index: 100000;" src="{{asset('resources/assets/login-gif-images-8.gif')}}" />');
	    feedbacks();   
	});

    $(document).on('click','#searchFeedback',function(){
        feedbacksearch();    
    });
});


	function feedbacks(url){

        var Data = '<img style="position: relative;height: 100px;left: 400px; z-index: 100000;" src="{{asset('resources/assets/login-gif-images-8.gif')}}" />';
            $("#feedbacks").html(Data);


		if(url){
			var URL = url;
		}else{
			var URL = '{{url("adminnew/show-feedback")}}';
		}

		$.ajax({
            url : URL
        }).done(function (data) {
            $("#feedbacks").html(data);
        }).fail(function () {
            var Data = '<div class="row"><div class="col-sm-12 text-center" style="margin:auto;">Unable to load the feedbacks`s. <a href="javascript:;" id="loadComments" >Click here</a> to load feedbacks.</div></div>';
            $("#feedbacks").html(Data);

        });
        $('#daterange').val('');
	}


    function feedbacksearch(url){

        if(url){
            var URL = url;
        }else{
            var URL = '{{route("feedback.search")}}';
        }

        var selectedDate = $("#daterange").val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var Data = '<img style="position: relative;height: 100px;left: 400px; z-index: 100000;" src="{{asset('resources/assets/login-gif-images-8.gif')}}" />';
            $("#feedbacks").html(Data);

        $.ajax({
            url: URL,
            type: 'POST',
            dataType: 'html',
            data: {date: selectedDate},
        })
        .done(function(res) {
            //console.log('success');
            $("#feedbacks").html(res);
        })
        .fail(function() {
            //console.log("error");
            var Data = '<div class="row"><div class="col-sm-12 text-center" style="margin:auto;">Unable to load the feedbacks`s. <a href="javascript:;" id="loadComments" >Click here</a> to load feedbacks.</div></div>';
            $("#feedbacks").html(Data);
        })
        .always(function() {
            //$(".loader-bg").hide();
            //console.log("complete");
        });
    }


</script>
@endsection