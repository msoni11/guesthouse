@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading panel-primary">Update Food Details</div>
            <div class="panel-body">
                     {!! Form::model($foods,['method' => 'PATCH','route'=>['food.update',$foods->id]]) !!}
                <div class="form-group form-inline">
                    <div class="row">
                        <div class="col-md-4">
                        {!! Form::label('Name', 'Name:') !!}
                        {!! Form::text('name',null,['class'=>'form-control']) !!}
                        </div>
                        <div class="col-md-4">
                        {!! Form::label('Description', 'Description:') !!}
                        {!! Form::text('description',null,['class'=>'form-control']) !!}
                        </div>
                        <div class="col-md-4">                
                        {!! Form::label('Price', 'Price:') !!}
                        {!! Form::text('price',null,['class'=>'form-control']) !!}
                        </div>
                    </div> 
                </div>
                <div class="form-group  form-inline">
                   <div class="row">
                        <div class="col-md-3"> 
                        {!! Form::label('Status', 'Status:') !!}
                        {!! Form::select('active',[1=>'Active', 0=>'In Active'],null,['class'=>'form-control']) !!}
                         </div>
                        <div class="col-md-2">      
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