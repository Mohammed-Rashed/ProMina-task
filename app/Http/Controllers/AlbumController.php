<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Picture;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $albums=Album::all();
        return view('albums.index',compact('albums'));
    }
    public function create()
    {
        return view('albums.create');
    }
    public function edit($id)
    {
        $album=Album::whereId($id)
            ->with(['pictures'=>function($q){
                $q->select('*')
                    ->selectRaw('(CONCAT ("' . url('/') . '/uploads/pictures/", name)) as name');
            }])->first();
        if(!$album){
            return abort(404);
        }
        return view('albums.edit',compact('album'));
    }
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required',
        ]);
        $album=new Album();
        $album->name=$request->name;
        $album->save();
        if ($request->pictures) {
            foreach (explode(',', $request->pictures) as $file) {
                $getFile = Picture::where('id', intval($file))->where('album_id', null)->first();
                if ($getFile) {
                    $getFile->album_id = $album->id;
                    $getFile->save();
                }
            }
        }
        return redirect()->back()->with('success','Album created successfully');
    }
    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $album=Album::findOrFail($id);
        $album->name=$request->name;
        $album->save();
        if ($request->pictures) {
            foreach (explode(',', $request->pictures) as $file) {
                $getFile = Picture::where('id', $file)->where('album_id', null)->first();
                if ($getFile) {
                    $getFile->album_id = $album->id;
                    $getFile->save();
                }
            }
        }
        return redirect()->back()->with('success','Album updated successfully');
    }
    public function destroy($id)
    {
    }
    public function upload_picture(Request $request)
    {
        $file = $request->file('file');
        if ($request->hasFile('file')) {
            $fileName = 'picture-'.time().'-'.uniqid().'.'.$file->getClientOriginalExtension();
            $destinationPath = 'uploads/pictures';
            $request->file('file')->move($destinationPath, $fileName);

            $new_picture=new Picture();
            $new_picture->name=$fileName;
            $new_picture->save();
            return $new_picture->id;
        }else{
            return 0;
        }
    }
    public function delete_picture(Request $request)
    {
        $id =  $request->id;
        $fileMedia=Picture::where('id',intval($id))->first();
        if ($fileMedia) {
            $path = public_path() . '/uploads/pictures/' . $fileMedia->name;
            if (file_exists($path)) {
                unlink($path);
                $fileMedia->delete();
                return 1;
            }
        }
        return 0;
    }
}
