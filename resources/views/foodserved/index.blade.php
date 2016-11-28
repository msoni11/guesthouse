@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel panel-primary">
                <div class="panel-heading"><h4>Food Served List</h4></div>   
                <div class="panel-body">
                    <a href="{{url('/foodserved/create')}}" class="btn btn-success">Add Food Served</a>
                    <br>
                    <br>
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
                             <a href="{{route('foodserved.edit',$food->id)}}" class="btn btn-warning">Edit</a>
                         </td>
                         <td>
                         {!! Form::open(['method' => 'DELETE', 'route'=>['foodserved.destroy', $food->id]]) !!}                         
                         <button class="btn btn-danger">
                             Delete
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
</div>

@endsection
