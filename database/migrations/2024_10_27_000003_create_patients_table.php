<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('name');
            $table->date('date_of_birth');
            $table->string('gender');
            $table->string('phone_number')->nullable();
            $table->unsignedSmallInteger('rt')->nullable();
            $table->unsignedSmallInteger('rw')->nullable();

            // $table->foreignId('health_center_id')->nullable()->constrained('address');
            $table->foreignId('event_id')->nullable()->default(null)->constrained('health_events')->cascadeOnDelete();
            $table->foreignId('address_id')->nullable()->constrained('address');
            $table->foreignId('created_by')->nullable()->default(null)->constrained('users');
            $table->timestamps();
            $table->foreignId('updated_by')->nullable()->constrained('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('patients');
    }
}
