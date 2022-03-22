<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMealTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meal_tags', function (Blueprint $table) {
            $table->unsignedBigInteger('meal_id');
            $table->unsignedBigInteger('tag_id');
            $table->timestamps();
            $table->foreign('meal_id')
                ->references('id')
                ->on('meals')
                ->onDelete('cascade');
            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meal_tags');
    }
}
