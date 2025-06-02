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
        Schema::create('item_requests', function (Blueprint $table) {
            $table->id();
            $table->string('pr_no')->nullable();
            $table->string('type_id');
            $table->string('brand')->nullable();
            $table->string('description')->nullable();
            $table->string('remarks')->nullable();
            $table->string('quantity')->nullable();
            $table->string('quantity_delivered')->nullable();
            $table->string('requested_by');
            $table->string('requested_by_department');
            $table->string('requested_for');
            $table->string('site');
            $table->string('status');
            $table->string('date_requested');
            $table->string('done_date')->nullable();
            $table->string('attachment');
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
        Schema::dropIfExists('item_requests');
    }
};
