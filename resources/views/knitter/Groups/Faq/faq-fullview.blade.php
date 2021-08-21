@extends('layouts.knitterapp')
@section('title',$faq->faq_title)
@section('content')
<div class="pcoded-wrapper" id="dashboard">
<div class="pcoded-content">
<div class="pcoded-inner-content">
<div class="main-body">
<div class="page-wrapper">
    
    @section('designer-groups-menu')
        <li><a href="{{ url('knitter/my-groups') }}" class="waves-effect waves-light">Groups</a></li>
        <li><a href="{{ url('knitter/groups/'.$group->unique_id.'/members') }}" class="waves-effect waves-light ">Group members</a></li>
        <li><a href="{{ url('knitter/groups/'.$group->unique_id.'/community') }}" class="waves-effect waves-light">Community</a></li>
        <li><a href="{{ url('knitter/groups/'.$group->unique_id.'/faq') }}" class="waves-effect waves-light active">FAQ's</a></li>
    @endsection
    <div class="page-body">
        <div class="row">
            <div class="col-lg-6">
                <label class="theme-heading f-w-600 m-b-20">{{ $group->group_name }}
                </label>
            </div>
            <div class="col-lg-6">
                <a href="{{ url('knitter/groups/'.$group->unique_id.'/faq') }}" class="btn theme-btn waves-effect waves-light pull-right" style="padding: 6px 12px; " >
                    <i class="fa fa-backward m-r-10"></i>Back to FAQ Page</a>
            </div>
        </div>

        <div class="row p-20">
            <div class="col-lg-9">
                <div class="card p-10">
                    <div class="accordion faq-row" id="accordionExample">
                        <div class="col-md-12">
                            <div class="card-header">
                                <h5 class="card-header-text">{{ $faq->faq_title }}</h5>
                            </div>
                            <div class="card-body" style="text-align: justify;">
                                {!! $faq->faq_description !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                @if($categories->count() > 0)
                    @foreach($categories as $cat)
                        <?php
                        $faqs = App\Models\GroupFaq::where('faq_category_id',$cat->id)->take(5)->get();
                        ?>
                        @if($faqs->count() > 0)
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-header-text"><i class="fa fa-info-circle m-r-10"></i>{{ $cat->category_name }}</h5>
                                </div>
                                <div class="card-block task-details">
                                    <ul style="list-style: circle;padding-left: 20px;padding-right: 10px;">
                                        @if($faqs->count() > 0)
                                            @foreach($faqs as $fa)
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
    @endsection
