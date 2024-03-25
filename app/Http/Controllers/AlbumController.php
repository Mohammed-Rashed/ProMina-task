<?php

namespace App\Http\Controllers;

use App\Models\Album;
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
        $album=Album::findOrFail($id);
        return view('albums.edit',compact('album'));
    }
    public function store(Request $request)
    {
    }
    public function update(Request $request,$id)
    {
    }
    public function destroy($id)
    {
    }
}
