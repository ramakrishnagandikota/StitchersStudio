@extends('layouts.admin')
@section('breadcrum')
<div class="col-md-12 col-12 align-self-center">
    <h3 class="text-themecolor">Users</h3>
    <ol class="breadcrumb" style="position: absolute;right: 0;top: 12px;">
        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
    </ol>
</div>

@endsection

@section('section1')
<div class="card col-12">
<div class="card-body">

<div class="clearfix"></div>
<div id="ress"></div>


<div class="table-responsive">
<table id="datatable" class="table table-striped table-bordered">
                     <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Plan</th>
                        <th>Subscription id</th>
                        <th>Order id</th>
                        <th>Cancelled</th>
                        <th>Expiry</th>
                        <th>Status</th>
                        <th>IP</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($subscription) > 0)
                        @foreach($subscription as $sub)
                            <tr>
                                <td>{{ $sub->id }}</td>
                                <td>{{ $sub->first_name.' '.$sub->last_name }}</td>
                                <td>{{ $sub->email }}</td>
                                <td> @if($sub->plan_id == 'P-664992417B445373VL4I6CFQ') Monthly @elseif($sub->plan_id == 'P-72C45040SG5797743L27JWOA') Yearly @else Free @endif</td>
                                <td><a href="javascript:;" data-id="{{ $sub->subscription_id }}" class="SubscriptionDetails" data-toggle="modal" data-target=".bd-example-modal-lg" style="font-size:14px;">{{ $sub->subscription_id }}</a></td>
                                <td>{{ $sub->tranx_id }}</td>
                                <td>{{ date('m/d/Y',strtotime($sub->expiry)) }}</td>
                                <td>{{ ($sub->is_cancelled == 1) ? 'Cancled' : '' }}</td>
                                <td>{{ $sub->status }}</td>
                                <td>{{ $sub->ipaddress }}</td>
                                <td>{{ date('m/d/Y',strtotime($sub->created_at)) }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center"><td colspan="6">No Records To Show</td></tr>
                    @endif
                    </tbody>
                      </table>
                      </div>
					  </div>
					  </div>
					 
					 
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="body">
	  
	  </div>
    </div>
  </div>
</div>
					  
@endsection
@section('section2')

@endsection
@section('footerscript')
   <script src="{{ asset('resources/assets/connect/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>

<script type="text/javascript">
$(function(){
$('#datatable').DataTable();

});

$(document).on('click','.SubscriptionDetails',function(){
		var id = $(this).attr('data-id');
		$("#body").html('');
		/*$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.post('{{url("admin/checkSubscription")}}',{'subscription_id': id},function(res){
			$("#body").html(res);
		});*/
		
		var token_type = localStorage.getItem("token_type");
		var access_token = localStorage.getItem("access_token");
		if(!token_type && !access_token){
			loginPaypal();
		}
		var settings = {
						  "url": "https://api.paypal.com/v1/billing/subscriptions/"+id,
						  "method": "GET",
						  "timeout": 0,
						  "headers": {
							"Content-Type": "application/json",
							"Authorization": token_type+' '+access_token,
							"Prefer": "return=minimal",
							"Cookie": "cookie_check=yes; enforce_policy=ccpa; ts=vreXpYrS%3D1690530287%26vteXpYrS%3D1595924087%26vr%3D69054b0e171ac120001ee8f3ffffd7cd%26vt%3D94618c611730a488df8a6ca4ff33748b%26vtyp%3Dreturn; ts_c=vr%3D69054b0e171ac120001ee8f3ffffd7cd%26vt%3D94618c611730a488df8a6ca4ff33748b"
						  },
						};

$.ajax(settings).done(function (response) {
	
	if(response.plan_id == 'P-72C45040SG5797743L27JWOA'){
		var plan = 'Knitter Yearly';
	}else if(response.plan_id == 'P-664992417B445373VL4I6CFQ'){
		var plan = 'Knitter Monthly';
	}else{
		var plan = 'Knitter Free';
	}
	
	//console.log('1',response.last_payment['time']);
	//console.log('1',response.last_payment);
	//console.log('1',response.last_payment.amount.value);
	

	
	
	var data = '<table class="table table-bordered"><tbody>';
	//for(var i=0;i<response.length;i++){
	data+='<tr><td>Id</td><td>'+response.id+'</td></tr>';
	data+='<tr><td>Status</td><td>'+response.status+'</td></tr>';
	data+='<tr><td>Plan</td><td>'+plan+'</td></tr>';
	data+='<tr><td>Next Billing Date</td><td>'+response.billing_info.next_billing_time+'</td></tr>';
	data+='<tr><td>Last Billing Date</td><td>'+response.billing_info.last_payment.time+'</td></tr>';	
	data+='<tr><td>Amount</td><td>'+response.billing_info.last_payment.amount.value+' USD</td></tr>';		
	data+='<tr><td>Subscription start date</td><td>'+response.start_time+'</td></tr>';
	data+='<tr><td>Cycles Completed</td><td>'+response.billing_info.cycle_executions[0].cycles_completed+'</td></tr>';
	data+='<tr><td>Faild payments</td><td>'+response.billing_info.failed_payments_count+'</td></tr>';
	//}
	data+='</tbody></table>';
	
	$("#body").html(data);
	console.log(response);
}).fail(function(res){
	loginPaypal();
});
	});

function func(value){
	if(value == 'active'){
		window.location.assign('{{url("admin/cususers-view/active")}}');
	}else if(value == 'inactive'){
		window.location.assign('{{url("admin/cususers-view/inactive")}}');
	}else{
		window.location.assign('{{url("admin/cususers-view")}}');
	}
}

function loginPaypal(){
	var settings = {
  "url": "https://api.paypal.com/v1/oauth2/token",
  "method": "POST",
  "timeout": 0,
  "headers": {
    "Content-Type": "application/x-www-form-urlencoded",
    "Authorization": "Basic QWFRanhpeEI1eEhlZ0FuQmlaT1U1QU1adFNDZzVTVndUbGliNDBqNXpFbUNlUzJ2WEM2TkI4WEo4b0JwdzZZeUMwSDZwMUNVVzdEREhWa2I6RURKMDFTRl9RUmpWYnFEbDUwTjdrVEUtQWtELWMxVWUxSGZrLVRKZDhrd2hmYUpzT1BUaFI5QjVONGppbTB3SGR4SzI5RGJjNFZoT01FeHg=",
    "Cookie": "cookie_check=yes; enforce_policy=ccpa; ts=vreXpYrS%3D1690530287%26vteXpYrS%3D1595924087%26vr%3D69054b0e171ac120001ee8f3ffffd7cd%26vt%3D94618c611730a488df8a6ca4ff33748b%26vtyp%3Dreturn; ts_c=vr%3D69054b0e171ac120001ee8f3ffffd7cd%26vt%3D94618c611730a488df8a6ca4ff33748b"
  },
  "data": {
    "grant_type": "client_credentials"
  }
};

$.ajax(settings).done(function (response) {
  //console.log(response);
  localStorage.setItem("token_type", response.token_type);
  localStorage.setItem("access_token", response.access_token);
  localStorage.setItem("expires_in", response.expires_in);
});
}
</script>
@endsection