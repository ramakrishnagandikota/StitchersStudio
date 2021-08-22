@if($workStatus->count() > 0)
    @foreach($workStatus as $ws)
      <?php  $status = App\Models\PatternWorkStatus::where('pattern_id',$id)->where('w_status',$ws->id)->first(); ?>

        <div class="col-md-12">
            <div class="vl-1"></div>
            <div class="card bg-default @if($status) {{ $ws->bg_colour }} @else halted @endif order-card "> <!-- halted -->
                <div class="card-block">
                    <h5 class="m-b-5">{{ $ws->name }}</h5>
                    <h6><i class="fa fa-calendar m-r-5"></i>
                        {{ date('m/d/Y') }}
                    </h6>
                    <i class="card-icon-custom {{ $ws->icon }}"></i>
                </div>
            </div>
        </div>
    @endforeach
@endif
