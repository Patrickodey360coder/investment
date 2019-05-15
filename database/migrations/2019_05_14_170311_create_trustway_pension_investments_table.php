<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrustwayPensionInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trustway_pension_investments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('trustway_investment_id');//->index();
            $table->enum('duration', [2,3,4,5])->default(2);
            $table->double('next_payout_amount')->nullable();
            $table->timestamp('next_payout_date')->nullable();
            $table->timestamps();

            $table->foreign('trustway_investment_id')
            ->references('id')
            ->on('trustway_investments')
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
        Schema::dropIfExists('trustway_pension_investments');
    }
}
