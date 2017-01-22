@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading panel-primary">Add Room</div>
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
                {!! Form::open(['url' => 'room']) !!}
                <div class="form-group">
                    {!! Form::label('Room No', 'Room No:') !!}
                    {!! Form::text('room_no',null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Room Type', 'Room Type:') !!}
                    {!! Form::text('room_type',null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Description', 'Description:') !!}
                    {!! Form::text('description',null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Capacity', 'Capacity:') !!}
                    {!! Form::text('capacity',null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Guest House Name', 'Guest House Name:') !!}
                    {!! Form::select('guest_house_id', $guesthouses, null, ['class'=>'form-control']) !!}
                </div>                
                <div class="form-group">
                    {!! Form::label('Status', 'Status:') !!}
                    {!! Form::select('status',[1=>'Active', 0=>'In Active'],null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Rent', 'Rent:') !!}
                    {!! Form::text('rent',0,['class'=>'form-control']) !!}
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