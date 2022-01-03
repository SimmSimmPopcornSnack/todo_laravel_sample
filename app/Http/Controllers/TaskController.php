<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(int $id)
    {
        // get info of all folders
        $folders = Folder::all();

        // get a selected folder
        $current_folder = Folder::find($id);

        // get tasks attached to the folder
        $tasks = $current_folder->tasks()->get();

        return view("tasks/index", [
            'folders' => $folders,
            'current_folder_id' => $current_folder->id,
            'tasks' => $tasks,
        ]);
    }
}
