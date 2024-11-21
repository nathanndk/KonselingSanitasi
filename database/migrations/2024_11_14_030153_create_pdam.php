<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\TingkatResiko;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pdam', function (Blueprint $table) {
            $table->id();
            $table->date('sampling_date');
            $table->enum('risk_level', TingkatResiko::getValues());
            $table->float('remaining_chlorine')->nullable();
            $table->float('ph')->nullable();
            $table->float('tds_measurement')->nullable();
            $table->float('temperature_measurement')->nullable();
            $table->integer('total_coliform')->nullable();
            $table->integer('e_coli')->nullable();
            $table->float('tds_lab')->nullable();
            $table->float('turbidity')->nullable();
            $table->string('color')->nullable();
            $table->string('odor')->nullable();
            $table->float('temperature_lab')->nullable();
            $table->float('aluminium')->nullable();
            $table->float('arsenic')->nullable();
            $table->float('cadmium')->nullable();
            $table->float('remaining_chlorine_lab')->nullable();
            $table->float('chromium_val_6')->nullable();
            $table->float('fluoride')->nullable();
            $table->float('iron')->nullable();
            $table->float('lead')->nullable();
            $table->float('manganese')->nullable();
            $table->float('nitrite')->nullable();
            $table->float('nitrate')->nullable();
            $table->float('ph_lab')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('event_id')->nullable()->constrained('health_events')->cascadeOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pdam');
    }
};
