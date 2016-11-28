@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading panel-primary">Update Guest Info</div>
            <div class="panel-body">
                {!! Form::model($guest_info,['method' => 'PATCH','files'=>true,'route'=>['guest_info.update',$guest_info->id]]) !!}
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
    </div>
</div>    
@stop