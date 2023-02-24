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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('details')->nullable();;
            $table->string('email')->nullable();
            $table->string('logo')->nullable();
            $table->string('website')->nullable();
            $table->string('location')->nullable();
            $table->string('region')->default('Europe');
            $table->integer('min_budget')->default(30000);
            $table->integer('max_budget')->default(60000);
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
        Schema::dropIfExists('companies');
    }
};
