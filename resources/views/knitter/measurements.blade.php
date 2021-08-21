@extends('layouts.knitterapp')
@section('title','Knitter Dashboard')
@section('content')



<div class="pcoded-wrapper">
               
                <div class="pcoded-content">
                  
                    <div class="pcoded-inner-content">
                        <div class="main-body">
                            <div class="page-wrapper card">
                                <!-- Page-body start -->
                                <div class="page-body">
                                    <div class="row">
                                    	@if(Session::has('message'))
<div class="alert alert-success">{{Session::get('message')}}</div>
@endif

                                        <div class="col-lg-4"><h5 class="theme-heading page-header-title">Measurement Sets</h5></div>
                                        <div class="col-lg-8 m-b-10">
                                                <button class="btn waves-effect pull-right waves-light btn-primary theme-outline-btn" data-toggle="modal" data-target="#myModal"><i class="icofont icofont-plus"></i>Add Measurement</button>
                                           </div>
                                        </div>
                                   <!-- round card start -->
                                   <div class="row users-card">

   	@if($meas->count() > 0)

   	@foreach($meas as $ms)
        
        <div class="col-lg-6 col-xl-3 col-md-6">
                <div class="card rounded-card user-card">
                    <div class="card-block">
                        <div class="img-hover">
                            <img class="img-fluid img-radius fixed-width-img" src="https://via.placeholder.com/200X250" alt="round-img">
                        </div>
                        <div class="user-content">
                            <h4 class="">{{$ms->m_title ?? 'No Name'}}</h4>
                            
                            <div class="editable-items">
                            <a href="{{url('knitter/measurements/edit/'.base64_encode($ms->id))}}" ><i class="fa fa-pencil" title="Edit"></i></a>
<a href="{{url('knitter/measurements/delete/'.base64_encode($ms->id))}}" onclick="return confirm('Are you sure want to delete ?') " ><i class="fa fa-trash" title="Delete"></i></a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
                                                
                                    <!-- Round card end -->
                                </div>
                                <!-- Page-body end -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Main-body end -->

                <!--Modal will load after pressing delete -->

        <div class="modal fade" id="child-Modal" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header">
                          <h5 class="modal-title">Confirmation</h5>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p></p>
                           <p class="text-center"> <img class="img-fluid" src="{{ asset('resources/assets/files/assets/images/delete.png') }}" alt="Theme-Logo" /></p>
                           <h6 class="text-center">Do You really want to Delete selected Profile ?</h6>
                           <p></p>
                    </div>
                    <div class="modal-footer">
                            <button class="btn waves-effect waves-light btn-primary theme-outline-btn" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger delete-card" data-dismiss="modal">Delete</button>
                    </div>
                  </div>
                </div>
              </div>

        <!--Child Modal Ends here-->

             <!-- Modal -->
             <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header">
                          <h5 class="modal-title">Measurement Details</h5>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input placeholder="Name" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control"
                                    placeholder="Description">
                                </div>
                            </div>
                            <!-- <div class="row">
                                    <label class="col-sm-12 col-form-label">For Whom</label>
                            </div> -->
                            <div class="form-group row">
                                <div class="col-lg-12">
                                     
<!-- Upload  -->
<label class="col-sm-12 col-form-label text-center">Upload an Image for this Measurement Set</label>
<form id="file-upload-form" class="uploader">
        <input id="file-upload" type="file" name="fileUpload" accept="image/*" />
        <label for="file-upload" id="file-drag">
          <!-- <img id="file-image" src="#" alt="Preview" class="hidden"> -->
          <div id="start">
            <i class="fa fa-download" aria-hidden="true"></i>
            <div>Select a file or drag here</div>
            <p></p>
            <span id="file-upload-btn" class="btn btn-primary">Select a file</span>
          </div>
          <div id="response" class="hidden">
            <div id="messages"></div>
            <progress class="progress" id="file-progress" value="0">
              <span>0</span>%
            </progress>
          </div>
        </label>
      </form>
                                
                            </div>
                            </form>
                    </div>
                    <div class="modal-footer">
                          <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                           <button type="submit" class="btn btn-success submit-btn" data-toggle="modal"><a class="custom-link" href="EditMeasurement.html">Next</a></button>
                    </div>
                  </div>
                </div>
              </div>
               
            </div>
        </div>
@endsection

@section('footerscript')

<script type="text/javascript">
	$(function(){
		//setTimeout(function(){ $('.alert-success').hide() },2000);
	});
</script>

@endsection