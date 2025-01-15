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
            $table->string('name',50);
            $table->date('date_of_birth');
            $table->string('gender', 1);
            $table->string('phone_number')->nullable();
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
