<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExchangeRateOldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchange_rate_olds', function (Blueprint $table) {
            $table->id();
            $table->string('unit');
            $table->string('base');
            $table->float('rate', 20, 10)->default(0);
            $table->text('rate_date')->nullable();
            $table->integer('number_rate')->default(0);
            $table->date('date_update')->nullable();
            $table->datetime('time_created')->nullable();
            $table->datetime('time_updated')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exchange_rate_olds');
    }
}
