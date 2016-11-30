@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading panel-primary">Add User</div>
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

                 {!! Form::open(['url' => 'user']) !!}   

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
                            {!! Form::label('Address', 'Address:') !!}
                            {!! Form::text('address',null,['class'=>'form-control']) !!}
                        </div>
                        <div class="col-md-4"> 
                            {!! Form::label('User Name', 'User Name:') !!}
                            {!! Form::text('username',null,['class'=>'form-control']) !!}
                        </div>                        
                        <div class="col-md-4"> 
                            {!! Form::label('Password', 'Password:') !!}
                            {!! Form::password('password',['class'=>'form-control']) !!}
                        </div>
                    </div>  
                </div>           
                <div class="form-group form-inline">
                    <div class="row">
                        
                        <div class="col-md-4"> 
                            {!! Form::label('Designation', 'Designation:') !!}
                            {!! Form::text('designation',null,['class'=>'form-control']) !!}
                        </div>
                        <div class="col-md-4"> 
                            {!! Form::label('Roles', 'Roles:') !!}
                            {!! Form::select('role_id[]',$roles,null,['class'=>'form-control', 'multiple'=>true]) !!}
                        </div>
                        <div class="col-md-4"> 
                            {!! Form::label('Status', 'Status:') !!}
                            {!! Form::select('status',[1=>'Active', 0=>'In Active'],null,['class'=>'form-control']) !!}
                        </div>
                    
                    </div>     
                </div>
                 <div class="form-group form-inline">
                     <div class="row">
                         <div class="col-md-4">      
                            {!! Form::label('Location', 'Location:') !!}
                            {!! Form::text('location',null,['class'=>'form-control']) !!}
                        </div>
                     </div>
                 </div>
                 <div class="form-group form-inline">
                     <div class="row">
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