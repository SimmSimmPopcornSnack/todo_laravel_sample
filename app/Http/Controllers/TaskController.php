<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\Task;
use App\Http\Requests\CreateTask;
use App\Http\Requests\EditTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{
    public function create(Folder $folder, CreateTask $request) {
        $task = new Task(); // new task instance
        $task->title = $request->title;
        $task->due_date = $request->due_date;

        $folder->tasks()->save($task);

        return redirect()->route("tasks.index", [
            'folder' => $folder->id,
        ]);
    }
    public function showCreateForm(folder $folder) {
        return view("tasks/create", [
            "folder_id" => $folder->id,
        ]);
    }

    private function checkRelation(Folder $folder, Task $task) {
        if($folder->id !== $task->folder) {
            abort(404);
        }
    }
    /**
     * GET /folders/{id}/tasks/{task_id}/edit
     */
    public function showEditForm(Folder $folder, Task $task) {
        $this->checkRelation($folder, $task);
        return view("tasks/edit", [
            "task" => $task,
        ]);
    }

    public function edit (Folder $folder, Task $task, EditTask $request) {
        $this->checkRelation($folder, $task);
        // 2
        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();
        // 3
        return redirect()->route("tasks.index", [
            "id" => $task->folder_id,
        ]);
    }

    public function index(Folder $folder)
    {
        // get info of all folders
        $folders = Auth::user()->folders()->get();
        // $folders = Folder::all();

        // get tasks attached to the folder
        $tasks = $folder->tasks()->get();

        return view("tasks/index", [
            'folders' => $folders,
            'current_folder_id' => $folder->id,
            'tasks' => $tasks,
        ]);
    }
}
