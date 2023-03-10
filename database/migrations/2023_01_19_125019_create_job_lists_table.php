<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_lists', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('company_id')->nullable();
            $table->integer('user_id');
            $table->string('tags');
            $table->string('job_location');
            $table->string('job_url');
            $table->string('employment_type_id');
            $table->integer('salary')->nullable();
            $table->boolean('available')->default('1');
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
        Schema::dropIfExists('job_lists');
    }
};
