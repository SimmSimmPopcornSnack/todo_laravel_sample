<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;
use App\Http\Requests\CreateFolder;

class FolderController extends Controller
{
    public function showCreateForm() {
        return view("folders/create");
    }
    public function create(CreateFolder $request) {
        // new folder instance
        $folder = new Folder();
        $folder->title = $request->title;
        $folder->save();

        return redirect()->route("tasks.index", [
            "id" => $folder->id,
        ]);
    }
}
