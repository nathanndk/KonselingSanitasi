<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHealthEventTable extends Migration
{
    public function up()
    {
        Schema::create('health_events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->dateTime('event_date');

            // Foreign keys
            $table->foreignId('health_center_id')->nullable()->constrained('address');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null'); // If user is deleted, set this to null
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null'); // If user is deleted, set this to null

            $table->timestamps(); // created_at and updated_at will be automatically managed
        });
    }

    public function down()
    {
        Schema::dropIfExists('health_events');
    }
}
