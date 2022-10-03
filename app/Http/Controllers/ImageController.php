<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class ImageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function addImage()
    {
        return view('todolist');

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function storeImage(Request $request)
    {
        $newImage = new Image();
        $file = $request->file('image');
        $filename = date('YmdHi') . $file->getClientOriginalName();
        $file->move(public_path('public/Image'), $filename);
        $newImage['image'] = $filename;
        $newImage->task_id = $request->integer('task_id');
        $newImage->save();
        return back()->with('success', 'Image uploaded Successfully!');
    }

    public function viewImage()
    {
        $images = Image::all();
        return view('todolist', ['images', $images]);
    }


}
