<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurant_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('');
            $table->string('phone')->default('');
            $table->string('logo')->default('');
            $table->string('email')->default('');
            $table->string('address')->default('');
            $table->string('lat')->default('');
            $table->string('lng')->default('');
            $table->string('delivery_time')->default('');
            $table->string('start_time')->default('');
            $table->string('end_time')->default('');
            $table->string('about')->default('');
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
        Schema::dropIfExists('restaurant_profiles');
    }
};
