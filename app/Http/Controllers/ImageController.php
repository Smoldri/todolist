<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Faker\Core\File;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Storage;
use App\Models\Task;


class ImageController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function addImage(Request $request)
    {

        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $image_path = $request->file('image')->storePublicly('/public/image');

        $data = Image::create([
            'image' => $image_path,
            'task_id' =>$request->task_id
        ]);

        $description = Task::where('id', $request->task_id)->pluck('description');

        session()->
        flash('success', 'Image has been added to' . ' task ' . $description );

        return back();
    }


    public function viewImage()
    {
        $images = Storage::get('');
        return view('todolist', ['images', $images]);
    }

    public static function deleteImage(Image $image)
    {
        $image->delete();
        Storage::delete("$image->image");
        return redirect('task');
    }


}
