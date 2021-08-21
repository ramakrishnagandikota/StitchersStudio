@extends('layouts.admin')
@section('breadcrum')
<div class="col-md-12 col-12 align-self-center">
    <h3 class="text-themecolor">User Role</h3>
    <ol class="breadcrumb" style="position: absolute;right: 0;top: 12px;">
        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
    </ol>
</div>

@endsection

@section('section1')
<div class="card col-12">
<div class="card-body">
<a class="btn waves-effect waves-light btn-success pull-right" href="{{url('admin/cususers-add')}}">Add New User</a>
<div class="clearfix"></div>
<div id="ress"></div>
<div class="table-responsive">
<table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Name</th>
                          <th>E-Mail</</th>
						  <th>Admin</th> 
						  <th>Knitter</th>
                          <!--<th>Wholesaler</th>-->
						  <th>Designer</th>
						  <!--<th>Advertaiser</th>
						  <th>Retailer</th>-->
						  <th></th>
                        </tr>
                      </thead>
						<tbody>
						 @foreach($users as $user)
						 <tr>
                <form action="{{ route('admin.assign') }}" method="post">
                <td>{{ $user->id }}</td>
                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                    <td>{{ $user->email }} <input type="hidden" name="email" value="{{ $user->email }}"></td>
                    <td><input type="checkbox" class="js-switch" data-color="#26c6da" data-size="small" {{ $user->hasRole('Admin') ? 'checked' : '' }} name="role_admin"    ></td>
                    <td><input type="checkbox" class="js-switch" data-color="#26c6da" data-size="small" {{ $user->hasRole('Knitter') ? 'checked' : '' }} name="role_knitter"></td>
                    <!--<td><input type="checkbox" class="js-switch" data-color="#26c6da" data-size="small" {{ $user->hasRole('Wholesaler') ? 'checked' : '' }} name="role_wholesaler"></td>-->
                     <td><input type="checkbox" class="js-switch" data-color="#26c6da" data-size="small" {{ $user->hasRole('Designer') ? 'checked' : '' }} name="role_designer"></td>
                   <!-- <td><input type="checkbox" class="js-switch" data-color="#26c6da" data-size="small" {{ $user->hasRole('Advertaiser') ? 'checked' : '' }} name="role_advertaiser"></td>
                    <td><input type="checkbox" class="js-switch" data-color="#26c6da" data-size="small" {{ $user->hasRole('Retailer') ? 'checked' : '' }} name="role_retailer"></td>-->
                    {{ csrf_field() }}
                    <td><button type="submit" class="btb btn-sm btn-primary">Assign</button></td>
                </form>
            </tr>
                      
						@endforeach
						
						</tbody>
                      </table>
					  </div>
					  </div>
					  </div>
					 
					  
@endsection
@section('section2')

@endsection
@section('footerscript')
<style>
[type="checkbox"]:not(:checked), [type="checkbox"]:checked {
    position: unset !important;
    left: 0px !important;
    opacity: 1 !important;
}
</style>
<script src="{{ asset('resources/assets/connect/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<!--<link href="{{ asset('resources/assets/connect/assets/plugins/switchery/dist/switchery.min.css') }}" rel="stylesheet" />
<script src="{{ asset('resources/assets/connect/assets/plugins/styleswitcher/jQuery.style.switcher.js') }}"></script>
 <script src="{{ asset('resources/assets/connect/assets/plugins/switchery/dist/switchery.min.js') }}"></script>
 -->
 <script>
 $(function(){
	 $('#datatable').DataTable();
	/* var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
       $('.js-switch').each(function() {
           new Switchery($(this)[0], $(this).data());
       });*/
 });
 </script>
@endsection