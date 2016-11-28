@extends('layouts.app')
@section('content')
<div style="display:none" id="site_url_path">{{ url('/')}}</div>
<div class="container">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading panel-primary">Add Guest Info</div>
            <div class="panel-body">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                   <div class="col-md-6">
                <div id="my_camera"></div>
                <form>
                    <input type=button value="Take Guest Photo Snapshot" onClick="take_snapshot()">
                </form>
                </div>
                 {!! Form::open(['url' => 'guest_info', 'files'=>true]) !!}   
                 <div class="col-md-6">
                    <div id="results">Your captured image will appear here...</div>
                </div>
                </div>    
                <hr>
                <div class="form-group  form-inline">
                    <div class="row">
                        <div class="col-md-4">
                        {!! Form::label('Name', 'Name:') !!}
                        {!! Form::text('name',null,['class'=>'form-control']) !!}
                        </div>
                        <div class="col-md-4">
                        {!! Form::label('Contact No', 'Contact No:') !!}
                        {!! Form::text('contact_no',null,['class'=>'form-control']) !!}
                        </div>
                        <div class="col-md-4">                
                        {!! Form::label('Email', 'Email:') !!}
                        {!! Form::text('email',null,['class'=>'form-control']) !!}
                        </div>
                    </div>  
                </div>
                <div class="form-group  form-inline">
                   <div class="row">
                    <div class="col-md-4"> 
                    {!! Form::label('Document Type', 'Document Type:') !!}
                    {!! Form::select('document_type',['Company Employee ID Card'=>'Company Employee ID Card','Voter Photo ID'=>'Voter Photo ID','Driving License'=>'Driving License','Passport'=>'Passport'], null,['class'=>'form-control']) !!}
                    </div>
                    <div class="col-md-4">                      
                    {!! Form::label('Attach Document', 'Attach Document:') !!}
                    <label class="file" class="form-control">
                                <input type="file" name="doc" id="doc">
                                <span class="file-custom"></span>
                        </label>
                    </div>
                    <div class="col-md-4">                      
                    {!! Form::label('Finger Print', 'Finger Print:') !!}
                    <label class="file" class="form-control">
                        <a name="finger_print" class="btn button" id="finger_print" onclick = "Initialize()">Take  Finger Print</a> 
                                <span class="file-custom"></span>
                        </label>
                    
                          <IMG id="img" style="display: none;" border="1" name="refresh" />
                           <SCRIPT language="JavaScript" type="text/javascript">
                           <!--
                           function Start() {
                           document.getElementById("img").src = "C:\\teste.bmp?ts" + encodeURIComponent( new Date().toString() );   
                           }
                           // -->
                           </SCRIPT> 

                       <br/>

                       <textarea name="log" id = "log" rows = "2" cols = "50" ></textarea>
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
            </div>
        </div>
        
        
        <script language="JavaScript">
		Webcam.set({
			width: 180,
			height: 140,
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
					'<img src="'+data_uri+'" name="guest_img"/><input type="hidden" value="'+data_uri+'" name="guest_photo"/><div class="text-center">Guest Photo</div>';

			} );
		}
	</script>
    </div>
</div>    
@stop