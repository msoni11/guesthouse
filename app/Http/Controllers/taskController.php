<?php

namespace GuestHouse\Http\Controllers;

use Illuminate\Http\Request;

use GuestHouse\Task;
use GuestHouse\User;

use GuestHouse\Http\Requests;
use GuestHouse\Http\Controllers\Controller;
use GuestHouse\Http\Controllers\Validator;

class taskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::orderBy('created_at', 'asc')->paginate(2);
        
        return view('tasks', [
            'tasks' => $tasks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {        
        /*$validator = Validator::make($request->all(), [
            'name' => 'required|min:5',
        ]);

        if ($validator->fails()) {
            return redirect('/')
            ->withInput()
            ->withErrors($validator);
        }*/

        $task = new Task;
        $task->name = $request->name;
        $task->save();

        return redirect('/task');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Task::where('id', $id)
          ->update(['name' => 'sssss']);
         return redirect('/task');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::where('id', $id);
        $task->delete();

        return redirect('/task');
    }
}
