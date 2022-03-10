<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearningObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_objects', function (Blueprint $table) {
            $table->id();
            $table->string('object_name')->unique();
            $table->string('object_url')->nullable();
            $table->text('object_summery')->nullable();
            $table->string('object_type');
            $table->string('object_format');
            $table->string('object_license');
            $table->string('object_file')->nullable();
            $table->foreignId('topic_id');
            $table->foreignId('course_id');
            $table->integer('order')->default(1);
            $table->boolean('is_publish')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('learning_objects');
    }
}
