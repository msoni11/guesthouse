@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel panel-primary">
                <div class="panel-heading"><h4>Food Details</h4></div>   
                <div class="panel-body">
                    <a href="{{url('/food/create')}}" class="btn btn-success">Add Food Details</a>
                    <br>
                    <br>
                    <table class="table table-hover table-striped table-bordered table-responsive">
                        <thead>
                 <tr >
                     <th>Id</th>
                     <th>Name</th>
                     <th>Description</th>
                     <th>Price(in Rs)</th>
                     <th>Status</th>
                     <th colspan="3">Actions</th>
                 </tr>
                 </thead>
                 <tbody>
                 <?php $index = 1 ?>    
                 @foreach ($foods as $food)
                     <tr>
                         <td>{{ $index ++ }}</td>
                         <td>{{ $food->name }}</td>
                         <td>{{ $food->description }}</td>
                         <td>{{ $food->price }}</td>
                         <td>{{ $food->active?'Active':'In Active' }}</td>
                         <td><a href="{{url('food',$food->id)}}" class="btn btn-primary">Details</a></td>
                         <td><a href="{{route('food.edit',$food->id)}}" class="btn btn-warning">Edit</a></td>
                         <td>
                         {!! Form::open(['method' => 'DELETE', 'route'=>['food.destroy', $food->id]]) !!}                         
                         <button class="btn btn-danger">
                             Delete
                         </button>
                         {!! Form::close() !!}
                         </td>
                     </tr>
                 @endforeach
                 </tbody>
                    </table>
                    {!! $foods->links() !!}
                </div>
            </div>
        </div>     
    </div> 
</div>

@endsection
