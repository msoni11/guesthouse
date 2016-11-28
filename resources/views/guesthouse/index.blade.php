@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel panel-primary">
                <div class="panel-heading"><h4>Guest House</h4></div>   
                <div class="panel-body">
                    <a href="{{url('/guesthouse/create')}}" class="btn btn-success">Create Guest House</a>
                    <br>
                    <br>
                    <table class="table table-striped table-bordered table-responsive">
                        <thead>
                 <tr >
                     <th>Id</th>
                     <th>Name</th>
                     <th>Description</th>
                     <th>Owner</th>
                     <th>Status</th>
                     <th colspan="3">Actions</th>
                 </tr>
                 </thead>
                 <tbody>
                 <?php $index = 1 ?>    
                 @foreach ($guesthouse as $house)
                     <tr>
                         <td>{{ $index ++ }}</td>
                         <td>{{ $house->name }}</td>
                         <td>{{ $house->description }}</td>
                         <td>{{ $house->user_name }}</td>
                         <td>{{ $house->status?'Active':'In Active' }}</td>
                         <td><a href="{{url('guesthouse',$house->id)}}" class="btn btn-primary"><span aria-hidden="true" class="glyphicon glyphicon-eye-open"></span></a></td>
                         <td><a href="{{route('guesthouse.edit',$house->id)}}" class="btn btn-warning"><span aria-hidden="true" class="glyphicon glyphicon-pencil"></span></a></td>
                         <td>
                         {!! Form::open(['method' => 'DELETE', 'route'=>['guesthouse.destroy', $house->id]]) !!}
                         <button class="btn btn-danger">
                             <span aria-hidden="true" class="glyphicon glyphicon-remove"></span>
                         </button>
                         {!! Form::close() !!}
                         </td>
                     </tr>
                 @endforeach

                 </tbody>
                    </table>
                    {!! $guesthouse->links() !!}
                </div>
            </div>
        </div>     
    </div> 
</div>

@endsection
