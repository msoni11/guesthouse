@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading panel-primary">Update Room</div>
            <div class="panel-body">
                {!! Form::model($rooms,['method' => 'PATCH','route'=>['room.update',$rooms->id]]) !!}
                <div class="form-group">
                    {!! Form::label('Room No', 'Room No:') !!}
                    {!! Form::text('room_no',null,['class'=>'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Room Type', 'Room No:') !!}
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
                    {!! Form::label('Guest House', 'Guest House:') !!}
                    {!! Form::select('guest_house_id', $guesthouse, null, ['class'=>'form-control']) !!}
                </div>                
                <div class="form-group">
                    {!! Form::label('Status', 'Status:') !!}
                    {!! Form::select('status',[1=>'Active', 0=>'In Active'],null,['class'=>'form-control']) !!}
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