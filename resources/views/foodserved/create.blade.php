@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading panel-primary">Guest Food Served</div>
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
                 {!! Form::open(['url' => 'foodserved']) !!}   
                <div class="form-group  form-inline">
                    <div class="row">
                        <div class="col-md-3">
                        {!! Form::label('Guest Name', 'Guest Name:') !!} : {{$user->name}}
                        {!! Form::hidden('guest_info_id',$user->id) !!}
                        </div>
                        <div class="col-md-3">
                        {!! Form::label('Food Name', 'Food Name:') !!}
                        {!! Form::select('food_id',$foods, null,['class'=>'form-control']) !!}
                        </div>
                        <div class="col-md-4">                
                        {!! Form::label('Quantity', 'Quantity:') !!}
                        {!! Form::text('quantity',null,['class'=>'form-control']) !!}
                       </div> 
                         {!! Form::hidden('food_served',1, null,['class'=>'form-control']) !!}
                        <div class="col-md-2">      
                        {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
                        </div>
                    </div>     
                </div>
                {!! Form::close() !!}
                
                                    <table class="table table-hover table-striped table-bordered table-responsive">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Guest Name</th>
                            <th>Food Name</th>
                            <th>Quantity</th>
                            <th colspan="3">Actions</th>
                        </tr>
                 </thead>
                 <tbody>
                 <?php $index = 1 ?>    
                 @foreach ($foodserved as $food)
                     <tr>
                         <td>{{ $index ++ }}</td>
                         <td>{{ $food->guest_name }}</td>
                         <td>{{ $food->food_name }}</td>
                         <td>{{ $food->quantity }}</td>
                         <td>
                             <a href="{{route('foodserved.edit',$food->id)}}" class="btn btn-warning"><span aria-hidden="true" class="glyphicon glyphicon-pencil"></span></a>
                         </td>
                         <td>
                         {!! Form::open(['method' => 'DELETE', 'route'=>['foodserved.destroy', $food->id]]) !!}
                         {!! Form::hidden('guest_info_id',$user->id) !!}
                             <button class="btn btn-danger">
                             <span aria-hidden="true" class="glyphicon glyphicon-remove"></span>
                         </button>
                         {!! Form::close() !!}
                         </td>
                     </tr>
                 @endforeach

                 </tbody>
                    </table>
                    {!! $foodserved->links() !!}

            </div>
        </div>
    </div>
</div>    
@stop