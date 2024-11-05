<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\StatusEvent;

class CreateEventStatusTable extends Migration
{
    public function up()
    {
        Schema::create('event_status', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('health_events');
            $table->enum('status', array_column(StatusEvent::cases(), 'value'));
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_status');
    }
}
