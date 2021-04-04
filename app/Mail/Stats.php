<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Track;
use App\Models\Playlist;
use App\Models\Artist;


class Stats extends Mailable
{
    use Queueable, SerializesModels;

    public $totalTracksLength;
    public $artistCount;
    public $playlistCount;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $tracks = Track::get();
        $this->totalTracksLength = $tracks->sum('milliseconds')/1000/60; //in minutes
        $artists = Artist::get();
        $this->artistCount = $artists->count();
        $playlists = Playlist::get();
        $this->playlistCount = $playlists->count();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject("Stats")
            ->view('email.stats');
    }
}
