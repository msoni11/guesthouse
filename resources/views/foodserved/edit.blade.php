@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading panel-default">Update Food Served</div>
            <div class="panel-body">
                {!! Form::model($foodserved,['method' => 'PATCH','files'=>true,'route'=>['foodserved.update',$foodserved->id]]) !!}
                <div class="form-group  form-inline">
                    <div class="row">
                        <div class="col-md-3">
                        {!! Form::label('Guest Name', 'Guest Name:') !!}
                        {!! Form::select('guest_info_id',$users, null,['class'=>'form-control']) !!}
                        </div>
                        <div class="col-md-3">
                        {!! Form::label('Food Name', 'Room No:') !!}
                        {!! Form::select('food_id',$foods, null,['class'=>'form-control']) !!}
                        </div>
                        <div class="col-md-4">                
                        {!! Form::label('Quantity', 'Quantity:') !!}
                        {!! Form::text('quantity',null,['class'=>'form-control', 'id'=>'quantity']) !!}
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