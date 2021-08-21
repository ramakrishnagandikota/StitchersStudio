<div class="col-md-12  @if($status1) agree-card @else halted @endif">
    <div class="vl-3" style="right: 78%;"></div><div class="vl-3" style="right: 23%;"></div>
    <div class="card bg-twitter order-card">
        <div class="card-block">
            <h5 class="m-b-5">Pattern submitted for acceptance</h5>
            <h6><i class="fa fa-calendar m-r-5"></i>{{ date('m/d/Y',strtotime($status1->w_date)) }}</h6>
            <i class="card-icon-custom fa fa-check"></i>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-6 @if($status2) agree-card @else halted @endif">
        <div class="vl-3" style="border-color: #a5a5a5;"></div>
        <div class="card Designaccepted order-card">
            <div class="card-block">
                <h5 class="m-b-5">Design accepted</h5>
                <h6><i class="fa fa-calendar m-r-5"></i> @if($status2) {{ date('m/d/Y',strtotime($status2->w_date)) }} @else - @endif</h6>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-6 @if($status3) disagree-card @else halted @endif">
        <div class="card bg-c-red order-card">
            <div class="card-block">
                <h5 class="m-b-5">Design rejected</h5>
                <h6><i class="fa fa-calendar m-r-5"></i> @if($status3) {{ date('m/d/Y',strtotime($status3->w_date)) }} @else - @endif </h6>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 @if($status4) accept-card @else halted @endif" >
    <div class="vl-1"></div>
    <div class="card Designersubmits order-card">
        <div class="card-block">
            <h5 class="m-b-5">Description and files Submitted</h5>
            <!-- Designer submits description and files-->
            <h6><i class="fa fa-calendar m-r-5"></i> @if($status4) {{ date('m/d/Y',strtotime($status4->w_date)) }} @else - @endif </h6>
            <i class="card-icon-custom fa fa-check"></i>
        </div>
    </div>
</div>
<div class="col-md-12 @if($status5) finish-card @else halted @endif">
    <div class="vl-4"></div>
    <div class="card Patternreleasedtodesigner order-card completed">
        <div class="card-block">
            <h5 class="m-b-5">Pattern released for review</h5>
            <!-- Pattern released to designer for review -->
            <h6><i class="fa fa-calendar m-r-5"></i> @if($status5) {{ date('m/d/Y',strtotime($status5->w_date)) }} @else - @endif </h6>
            <i class="card-icon-custom fa fa-check"></i>
        </div>
    </div>
    <div class="vl-1"></div>
</div>
<div class="col-md-12 @if($status6) approval-card @else halted @endif">
    <div class="card Patternreleasedforsale order-card completed">
        <div class="card-block">
            <h5 class="m-b-5">Pattern released for sale</h5>
            <h6><i class="fa fa-calendar m-r-5"></i> @if($status6) {{ date('m/d/Y',strtotime($status6->w_date)) }} @else - @endif </h6>
            <i class="card-icon-custom fa fa-check"></i>
        </div>
    </div>
</div>
