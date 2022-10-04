<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Faker\Core\File;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Storage;


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

        return back()->with('success', 'Image uploaded Successfully!');
    }


    public function viewImage()
    {
        $images = Storage::get('');
        return view('todolist', ['images', $images]);
    }

    public function deleteImage(Image $image)
    {
        $image->delete();
        Storage::delete("$image->image");
        return redirect('task');
    }


}
