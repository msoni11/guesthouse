@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading panel-default">Update Room Allotment</div>
            <div class="panel-body">
                {!! Form::model($guestroomallotment,['method' => 'PATCH','files'=>true,'route'=>['guestroomallotment.update',$guestroomallotment->id]]) !!}
                <div class="form-group  form-inline">
                    <div class="row">
                        <div class="col-md-3">
                        {!! Form::label('Guest Name', 'Guest Name:') !!}
                        {!! Form::select('guest_info_id',$users, null,['class'=>'form-control']) !!}
                        </div>
                        <div class="col-md-3">
                        {!! Form::label('Room No', 'Room No:') !!}
                        {!! Form::select('room_id',$rooms, null,['class'=>'form-control']) !!}
                        </div>
                        <div class="col-md-4">                
                        {!! Form::label('Check In Date', 'Check In Date:') !!}
                        {!! Form::text('check_in_date',null,['class'=>'form-control', 'id'=>'check_in_date']) !!}
                       </div>                 
  
                    <div class="col-md-2">      
                    {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
                    </div>
                    </div>     
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <script language="JavaScript">
		jQuery(document).ready(function($){
                    $('#check_in_date').datetimepicker({
                         format: "YYYY/MM/DD hh:mm:ss",
                    });
                });
	</script>
    </div>
</div>    
@stop