<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTvCoveragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tv_coverages', function (Blueprint $table) {
            $table->id();
            $table->string('coverage_title', 50);
            $table->dateTime('coverage_date_time');
            $table->string('coverage_location');
            $table->text('coverage_desc');
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
        Schema::dropIfExists('tv_coverages');
    }
}
