<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Role;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug'); //string key to represent role
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            // $table->foreign('role_id')->references('id')->on('roles');
            // foreign key set to role_id for users table
            $table->foreignId('role_id')->constrained();
        });

        $roles = [
            'user' => 'User',
            'admin' => 'Admin',
        ];

        foreach ($roles as $slug => $name) {
            // $role = new Role();
            // $role->slug = $slug;
            // $role->name = $name;
            // $role->save();

            Role::create([
                'slug' => $slug,
                'name' => $name,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('users', ['role_id']); //drop role_id column from users table
        Schema::dropIfExists('roles');
    }
}
