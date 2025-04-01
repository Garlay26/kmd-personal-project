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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('token');
            $table->string('email')->nullable();
            $table->string('password');
            $table->bigInteger('country_id');
            $table->bigInteger('state_id');
            $table->bigInteger('township_id');
            $table->string('address');
            $table->string('profile_image')->nullable();
            $table->date('register_date');
            $table->enum('status', ['active', 'ban'])->default('active');
            $table->string('fcm_token')->nullable();
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
        Schema::dropIfExists('customers');
    }
};
