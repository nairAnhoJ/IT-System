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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_no');
            $table->string('sap_id')->nullable();
            $table->bigInteger('user_id');
            $table->string('department');
            $table->string('nature_of_problem');
            $table->string('assigned_to');
            $table->string('subject');
            $table->string('description');
            $table->string('resolution')->nullable();
            $table->string('attachment')->nullable();
            $table->string('status')->default('PENDING');
            $table->dateTime('start_date_time')->nullable();
            $table->dateTime('end_date_time')->nullable();
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
        Schema::dropIfExists('tickets');
    }
};
