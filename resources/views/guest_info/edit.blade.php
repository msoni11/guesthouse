@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading panel-primary">Update Guest Info</div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                    <div id="my_camera"></div>
                    <form>
                        <input type=button value="Take Guest Photo Snapshot" onClick="take_snapshot()">
                    </form>
                    </div>
                     {!! Form::model($guest_info,['method' => 'PATCH','files'=>true,'route'=>['guest_info.update',$guest_info->id]]) !!}
                     <div class="col-md-6">
                        <div id="results">
                            @if($guest_info->guest_photo)
                                <img src="{{ $guest_info->guest_photo }}" width='240px' height='180px'>
                            @else 
                                Your captured image will appear here..
                            @endif</div>
                         
                    </div>
                </div>
                 <hr>
                <div class="form-group form-inline">
                    <div class="row">
                        <div class="col-md-3">
                        {!! Form::label('Name', 'Name:') !!}
                        {!! Form::text('name',null,['class'=>'form-control']) !!}
                        </div>
                        <div class="col-md-3">
                        {!! Form::label('Contact No', 'Contact No:') !!}
                        {!! Form::text('contact_no',null,['class'=>'form-control']) !!}
                        </div>
                        <div class="col-md-3">
                        {!! Form::label('Email', 'Email:') !!}
                        {!! Form::text('email',null,['class'=>'form-control']) !!}
                        </div>
                        <div class="col-md-3">
                        {!! Form::label('Address', 'Address:') !!}
                        {!! Form::text('address',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group form-inline">
                   <div class="row">
                    <div class="col-md-4"> 
                    {!! Form::label('Document Type', 'Document Type:') !!}
                    
                    {!! Form::select('document_type',['Company Employee ID Card'=>'Company Employee ID Card','Voter Photo ID'=>'Voter Photo ID','Driving License'=>'Driving License','Passport'=>'Passport'], null,['class'=>'form-control']) !!}
                    </div>
                    <div class="col-md-4">
                      @if($guest_info->doc)
                    <a target='_blank' href="{{ url('uploads/'.$guest_info->doc) }}" >[View Attachment]</a>    
                      @endif
                    {!! Form::label('Attach Document', 'Attach Document:') !!}
                    <label class="file" class="form-control">
                                <input type="file" name="doc" id="doc">
                                <span class="file-custom"></span>
                        </label>
                    </div>
                    <div class="col-md-4"> 
                         @if($guest_info->finger_print)
                    <a target='_blank' href="{{ url('uploads/'.$guest_info->finger_print) }}" >[View Finger Print]</a>    
                      @endif 
                    {!! Form::label('Finger Print', 'Finger Print:') !!}
                    <label class="file" class="form-control">
                                <a name="finger_print" class="btn btn-primary form-control" id="finger_print" data-toggle="modal" data-target="#myModal" >Generate Finger Print ID</a> 
                                 <input type="hidden"  value="{{ $digits = 8}}
{{$rand = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT) }} ">
                                {!! Form::hidden('finger_print',$rand, ['class'=>'form-control', 'id'=>'finger_print_id']) !!}
                                 <span class="file-custom"></span>
                        </label>
                    </div>
                   </div> 
                </div>
                <div class="form-group form-inline">
                    <div class="row">
                    <div class="col-md-4"> 
                    {!! Form::label('Status', 'Status:') !!}
                    {!! Form::select('status',[1=>'Active', 0=>'In Active'],null,['class'=>'form-control']) !!}
                     </div>
                    <div class="col-md-4">      
                    {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
                    </div>
                    </div>     
                </div>
                {!! Form::close() !!}
                        <!-- Modal -->
                        <div id="myModal" class="modal fade" role="dialog">
                          <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Finger Print ID</h4>
                              </div>
                              <div class="modal-body">
                                  <p><h3>{{ $rand }}</h3></p>
                              </div>
                              <div class="modal-footer">
                                  Have you taken finger print?
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Yes</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal" id="no_btn">No</button>
                              </div>
                            </div>

                          </div>
                        </div>
            </div>
        </div>
                <script language="JavaScript">
               $('#no_btn').on('click', function(){
                    $('#finger_print_id').val('');
               });     
		Webcam.set({
			width: 240,
			height: 180,
			image_format: 'jpeg',
			jpeg_quality: 100,
                        upload_name: 'test',
		});
		Webcam.attach( '#my_camera' );
                function take_snapshot() {
			// take snapshot and get image data
			Webcam.snap( function(data_uri) {
				// display results in page
				document.getElementById('results').innerHTML = 
					'<img src="'+data_uri+'" name="guest_img"/><input type="hidden" value="'+data_uri+'" name="guest_photo"/>';

			} );
		}
	</script>
    </div>
</div>    
@stop