<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePdamParameterCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('pdam_parameter_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->foreignId('pdam_condition_id')->nullable()->constrained('pdam_conditions');
            $table->foreignId('updated_by')->nullable()->constrained('users');
        });
    }

    public function down()
    {
        Schema::table('pdam_parameter_categories', function (Blueprint $table) {
            if (Schema::hasColumn('pdam_parameter_categories', 'created_by')) {
                $table->dropForeign(['created_by']);
            }
            if (Schema::hasColumn('pdam_parameter_categories', 'updated_by')) {
                $table->dropForeign(['updated_by']);
            }
        });

        Schema::dropIfExists('pdam_parameter_categories');
    }
}
