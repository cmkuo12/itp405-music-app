<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Album;
use App\Models\Role;
use App\Models\User;

class AddUserIdToAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('albums', function (Blueprint $table) {
            //$table->string('user_id')->nullable();
            //$table->foreignId('user_id')->references('id')->on('users')->nullable();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained();
        });

        $albums = Album::get();
        $admin = User::where('email', '=', 'admin@usc.edu')->first();
        foreach ($albums as $album) {
            $album->user_id = $admin->id;
            $album->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('albums', ['user_id']);
    }
}
