<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Track;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->query('q');
        return Artist::where('name', 'LIKE', '%'.$name.'%')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$request->validate
        $validation = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors(),
            ], 422);
        }

        return Artist::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function show(Artist $artist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Artist $artist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Artist  $artist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Artist $artist)
    {
        $trackCount = 0;
        $albums = Album::where('artist_id', '=', $artist->id)->get();
        foreach ($albums as $album) {
            $trackCount = $trackCount + DB::table('tracks')->where('album_id', '=', $album->id)->count();
        }
        if($trackCount > 0) {
            return response()->json([
                'error' => 'You cannot delete an artist that has tracks.',
            ], 400);
        }
        
        $artist->delete();
        return response(null, 204); //204 = no content to send back
    }
}
