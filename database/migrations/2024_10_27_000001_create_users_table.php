<?php

// database/migrations/2024_10_27_072054_create_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\RoleUser;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('health_center_id')->nullable();
            // $table->foreign('health_center_id')->references('id')->on('health_center')->onDelete('cascade');
            $table->string('username')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('role', array_map(fn($role) => $role->value, RoleUser::cases()))->default(RoleUser::Kader->value);
            $table->string('nik')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('profile_pic')->nullable();
            $table->string('gender')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('users');
        Schema::enableForeignKeyConstraints();
    }
}
