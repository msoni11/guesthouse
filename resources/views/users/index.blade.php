@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel panel-primary">
                <div class="panel-heading"><h4>Users Info</h4></div>   
                <div class="panel-body">
                    <a href="{{url('/user/create')}}" class="btn btn-success">Add User</a>
                    <br>
                    <br>
                    <table class="table table-hover table-striped table-bordered table-responsive">
                        <thead>
                 <tr >
                     <th>Id</th>
                     <th>Name</th>
                     <th>User Name</th>
                     <th>Contact No</th>
                     <th>Email</th>
                     <th>Address</th>                     
                     <th>Designation</th>
                     <th>Roles</th>
                     <th>Registration Date</th>
                     <th>Status</th>
                     <th colspan="3">Actions</th>
                 </tr>
                 </thead>
                 <tbody>
                 <?php $index = 1 ?>    
                 @foreach ($users as $user)
                 
                     <tr>
                         <td>{{ $index ++ }}</td>
                         <td>{{ $user->name }}</td>
                         <td>{{ $user->username }}</td>
                         <td>{{ $user->contact_no }}</td>
                         <td>{{ $user->email }}</td>
                         <td>{{ $user->address }}</td>
                         <td>{{ $user->designation }}</td>
                         <td>{{ $user->role }}</td>
                         <td>{{ $user->reg_date }}</td>                         
                         <td>{{ $user->status?'Active':'In Active' }}</td>
                         <td><a href="{{url('user',$user->id)}}" class="btn btn-primary"><span aria-hidden="true" class="glyphicon glyphicon-eye-open"></span></a></td>
                         <td><a href="{{route('user.edit',$user->id)}}" class="btn btn-warning"><span aria-hidden="true" class="glyphicon glyphicon-pencil"></span></a></td>
                         <td>
                         {!! Form::open(['method' => 'DELETE', 'route'=>['user.destroy', $user->id]]) !!}                         
                         <button class="btn btn-danger">
                             <span aria-hidden="true" class="glyphicon glyphicon-remove"></span>
                         </button>
                         {!! Form::close() !!}
                         </td>
                     </tr>
                 @endforeach

                 </tbody>
                    </table>
                    {!! $users->links() !!}
                </div>
            </div>
        </div>     
    </div> 
</div>

@endsection
