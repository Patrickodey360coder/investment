<?php

use App\TrustwayInvestment;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrustwayInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trustway_investments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');//->index();
            $table->float('investment_amount');
            $table->float('checkout_amount');
            $table->enum('status', TrustwayInvestment::getStatusValues())->default('Pending');
            $table->enum('investment_type', TrustwayInvestment::getInvestmentTypes());
            $table->timestamp('investment_date')->nullable();
            $table->timestamp('checkout_date')->nullable();
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
        Schema::dropIfExists('trustway_investments');
    }
}
