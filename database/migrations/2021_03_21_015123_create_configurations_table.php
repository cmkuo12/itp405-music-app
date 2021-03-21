<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Configuration;
use App\Models\User;
use App\Models\Role;

class CreateConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('value');
            $table->timestamps();
        });

        Configuration::create([
            'name' => 'maintenance-mode',
            'value' => false,
        ]);

        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@usc.edu';
        $user->password = Hash::make('laravel');
        $userRole = Role::getAdmin();
        $user->role()->associate($userRole); //associate user with particular role
        $user->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configurations');
    }
}
