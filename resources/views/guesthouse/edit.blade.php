@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading panel-primary">Update Guest House</div>
            <div class="panel-body">
                {!! Form::model($guesthouse,['method' => 'PATCH','route'=>['guesthouse.update',$guesthouse->id]]) !!}
                <div class="form-group">
                    {!! Form::label('Name', 'Name:') !!}
                    {!! Form::text('name',null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Description', 'Description:') !!}
                    {!! Form::text('description',null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Status', 'Status:') !!}
                    {!! Form::select('status',[1=>'Active', 0=>'In Active'],null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Owner', 'Owner:') !!}
                    {!! Form::select('user_id', $users, null, ['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>    
@stop