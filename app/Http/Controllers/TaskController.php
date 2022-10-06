<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ImageController;
use App\Models\Image;
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
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $tasks = Task::with('image')->where('user_id', Auth::id())
            ->status()->description()
            ->get()
            ->sortByDesc('updated_at')->sortByDesc('completed');

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

        session()->flash('success', 'A new task has been added');

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
        $task->completed = 1;
        $task->completed_at = now();
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
        $task->completed = 2;
        $task->completed_at = null;
        $task->save();
        return redirect('task');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Application|Redirector|RedirectResponse
     */
    public function deleteTask(Task $task)
    {
        $taskImage = Image::where('task_id', $task->id)->first();

        if ($taskImage) {
            ImageController::deleteImage($taskImage);
        }

        $task->delete();
        session()->flash('success', 'Task has been deleted');
        return redirect('task');


    }

    public function editTask(Task $task)
    {
        $task->updated_at = now();
        $task->save();
        return redirect('task');

    }
}
