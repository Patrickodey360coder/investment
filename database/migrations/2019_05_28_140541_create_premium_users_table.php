<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePremiumUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('premium_users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');//->index();
            $table->float('investment_amount');
            $table->unsignedInteger('months');
            $table->timestamp('investment_date')->nullable();
            $table->timestamp('next_checkout_date')->nullable();
            $table->timestamp('expiration_date')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
            ->references('id')
            ->on('users')
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
        Schema::dropIfExists('premium_users');
    }
}
