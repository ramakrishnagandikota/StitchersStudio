<div class="col-md-12" >
    <div class="vl-1"></div>
    <div class="card bg-twitter order-card">
        <div class="card-block">
            <h5 class="m-b-5">Requested</h5>
            <h6><i class="fa fa-calendar m-r-5"></i>{{ date('m/d/Y',strtotime($formula->created_at)) }}</h6>

            <i class="card-icon-custom fa fa-tasks"></i>
        </div>
    </div>
</div>

<div class="col-md-12 accept-card">
    <div class="vl-3" style="right: 78%;"></div><div class="vl-3" style="right: 23%;"></div>
    <div class="card bg-twitter @if($formula->f_status == 'In Review' || $formula->f_status == 'Rejected' || $formula->f_status == 'Completed')  bg-c-green @else halted @endif  order-card">
        <div class="card-block">
            <h5 class="m-b-5">In Review</h5>
            <h6><i class="fa fa-calendar m-r-5"></i>
                @if($formula->review_at)
                    {{ date('m/d/Y',strtotime($formula->review_at)) }}
                @endif
            </h6>

            <i class="card-icon-custom fa fa-check"></i>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-6 cancelled-card">
        <div class="card bg-twitter @if($formula->f_status == 'Rejected') bg-c-red @else halted @endif  order-card">
            <div class="card-block">
                <h5 class="m-b-5">Rejected</h5>
                <h6><i class="fa fa-calendar m-r-5"></i>
                    @if($formula->rejected_at)
                        {{ date('m/d/Y',strtotime($formula->rejected_at)) }}
                    @endif
                </h6>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-6">
        <div class="card  bg-twitter @if($formula->f_status == 'Completed') bg-c-blue @else halted @endif order-card">
            <div class="card-block">
                <h5 class="m-b-5">Completed</h5>
                <h6><i class="fa fa-calendar m-r-5"></i>
                    @if($formula->completed_at)
                        {{ date('m/d/Y',strtotime($formula->completed_at)) }}
                    @endif
                </h6>
            </div>
        </div>
    </div>
</div>
