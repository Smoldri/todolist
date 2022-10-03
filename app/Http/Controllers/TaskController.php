<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->get()->sortByDesc('created_at')->sortBy('completed');
        return view('todolist', ['tasks' => $tasks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required'
        ]);
        $data = request()->all();

        $newTask = new Task();
        $newTask->description = $data['description'];
        $newTask->user_id = Auth::id();
        $newTask->save();

        return redirect('/task');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Application|Redirector|RedirectResponse
     */
    public function markAsCompleted(Task $task)
    {
        $task->completed = true;
        $task->save();

        return redirect('task');

    }


    /**
     * Update the specified resource in storage.
     *
     * @param Task $task
     * @return Application|Redirector|RedirectResponse
     */
    public function markAsToDo(Task $task)
    {
        $task->completed = false;
        $task->save();
        return redirect('task');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Application|Redirector|RedirectResponse
     */
    public function delete(Task $task)
    {
        $task->delete();

        return redirect('task');
    }
}
