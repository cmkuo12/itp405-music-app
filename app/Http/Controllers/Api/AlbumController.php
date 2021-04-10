<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Album;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get collection of albums: /albums
        return Album::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //POST
    {
        //$request->validate
        $validation = Validator::make($request->all(), [
            'title' => 'required',
            'artist_id' => 'required',
        ]);

        if($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors(),
            ], 422);
        }

        // $album = new Album();
        // $album->title = $request->input('title');
        // $album->artist_id = $request->input('artist_id');
        // $album->save();
        return Album::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function show(Album $album)
    {
        //get single resource -- /albums/{id}
        return $album;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Album $album)
    {
        $validation = Validator::make($request->all(), [
            'title' => 'required',
            'artist_id' => 'required',
        ]);

        if($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors(),
            ], 422);
        }
        $album->update($request->all());
        return $album;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function destroy(Album $album)
    {
        $trackCount = DB::table('tracks')->where('album_id', '=', $album->id)->count();
        if($trackCount > 0) {
            return response()->json([
                'error' => 'Only albums without tracks can be deleted.',
            ], 400);
        }
        
        $album->delete();
        return response(null, 204); //204 = no content to send back
    }
}
