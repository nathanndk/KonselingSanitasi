<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\Activity;

class CreateUsersActivityTable extends Migration
{
    public function up()
    {
        Schema::create('users_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->date('date');
            $table->timestamp('time');
            $table->enum('activity', array_map(fn($activity) => $activity->value, Activity::cases()));
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users_activities');
    }
}
