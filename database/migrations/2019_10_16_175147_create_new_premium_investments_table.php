<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewPremiumInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_premium_investments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');//->index();
            $table->float('investment_amount');
            $table->unsignedInteger('months');
            $table->enum('from_wallet', ['yes', 'no'])->default('no');
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
        Schema::dropIfExists('new_premium_investments');
    }
}
