@extends('layouts.knitterapp')
@section('title',$group->group_name)
@section('content')
<div class="pcoded-wrapper" id="dashboard">
<div class="pcoded-content">
<div class="pcoded-inner-content">
<div class="main-body">
<div class="page-wrapper">
    @section('title',$group->group_name)
    @section('designer-groups-menu')
        <li><a href="{{ url('knitter/my-groups') }}" class="waves-effect waves-light">Groups</a></li>
        <li><a href="{{ url('knitter/groups/'.$group->unique_id.'/members') }}" class="waves-effect waves-light ">Group members</a></li>
        <li><a href="{{ url('knitter/groups/'.$group->unique_id.'/community') }}" class="waves-effect waves-light">Community</a></li>
        <li><a href="{{ url('knitter/groups/'.$group->unique_id.'/faq') }}" class="waves-effect waves-light active">FAQ's</a></li>
    @endsection
    <div class="page-body">
        <div class="row">
            <div class="col-lg-6">
                <label class="theme-heading f-w-600 m-b-20">{{ $group->group_name }} : FAQ's</label>
            </div>
            <div class="col-lg-6">
                <div class="form-group pull-right" style="width: 100%;">
                    <input type="text" id="myInput" class="form-control" placeholder="Type something to search..." >
                    <div id="faqResults"></div>
                </div>

            </div>
        </div>

        <div class="row p-20">
            <div class="col-lg-9">
                <div class="card p-10">
                    <div class="accordion faq-row" id="accordionExample">
                        <div class="col-md-12">
                            <h5 class="text-center" id="loadingArea">Please wait. Loading data...</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                @if($categories->count() > 0)
                    @foreach($categories as $cat)
                        <?php
                        $faqs1 = App\Models\GroupFaq::where('faq_category_id',$cat->id)->take(5)->get();
                        ?>
                        @if($faqs1->count() > 0)
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-header-text"><i class="fa fa-info-circle m-r-10"></i>{{ $cat->category_name }}</h5>
                                </div>
                                <div class="card-block task-details">
                                    <ul style="list-style: circle;padding-left: 20px;padding-right: 10px;">
                                        @if($faqs1->count() > 0)
                                            @foreach($faqs1 as $fa)
                                                <li><p><a href="{{ url('knitter/groups/faq/'.$fa->faq_unique_id.'/show') }}">{{ $fa->faq_title }}</a></p></li>
                                            @endforeach
                                        @else
                                            <li><p class="text-center">No posts to show in this category</p></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>

</div>
</div>
</div>
</div>
</div>
@endsection

    @section('footerscript')
        <style>
            .fa-pencil{
                background-color: unset !important;
                color: #c38a9b !important;
                padding: 0px !important;
            }
            .underline{
                border-bottom: 2px dotted #c38a9b;
            }
            #gpages{
                display: none;
            }
            .nav-right li .active {
                border-bottom: 1px solid #0d665c;
                color: #0d665c;
                font-weight: 500;
            }
            .kf-pink{
                color: red;
            }
            .help-block{
                color: red;
            }
            .accordionBox{
                margin-bottom: 10px;
                box-shadow: none !important;
                border: 1px solid #eee;
            }
            .accordionBox .card-header{
                padding: 0px !important;
            }
            .upDownIcon{
                position: absolute;
                right: 15px;
                top: 13px;
            }
            .glyphicon-ok:before {
                content: "\2714";
            }
            .glyphicon-remove:before {
                content: "\292B";
            }
            .table td, .table th{
                padding: 10px;
            }
            .error{
                color: red;
            }
        </style>

<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js')}}"></script>
        <script type="text/javascript">
            getData(1);
            $(window).on('hashchange', function() {
                if (window.location.hash) {
                    var page = window.location.hash.replace('#', '');
                    if (page == Number.NaN || page <= 0) {
                        return false;
                    }else{
                        getData(page);
                    }
                }
            });

            $(document).ready(function()
            {
                $(document).on('click', '.pagination a',function(event)
                {
                    event.preventDefault();

                    $('li').removeClass('active');
                    $(this).parent('li').addClass('active');

                    var myurl = $(this).attr('href');
                    var page=$(this).attr('href').split('page=')[1];

                    getData(page);
                });

            });

            $(document).on('keyup','#myInput',function (){
                var value = $(this).val();
                var group_id = '{{ $group->unique_id }}';
                var Data = 'search='+value+'&group_id='+group_id;
                if(value == ''){
                    $("#faqResults").html('');
                    return false;
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.post('{{ url("knitter/groups/faq/search") }}',Data,function (res){
                    $("#faqResults").html(res);
                });
            });

            function getData(page){
                $("#loadingArea").html("Please wait. Loading data...")
                $.ajax(
                    {
                        url: '{{ url("knitter/groups/".$group->unique_id."/faq") }}?page='+page,
                        type: "get",
                        datatype: "html"
                    }).done(function(data){
                    $("#accordionExample").empty().html(data);
                    location.hash = page;
                }).fail(function(jqXHR, ajaxOptions, thrownError){
                    setTimeout(function (){
                        $("#loadingArea").html("Unable to get the FAQ's <a href='javascript:;' style='color: #c14d7d;' onclick='getData(1)'>Click Here</a> to load the data");
                    },1500);
                    //alert('No response from server');
                });
            }
        </script>
    @endsection