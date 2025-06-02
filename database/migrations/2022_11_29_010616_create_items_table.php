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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('type_id');
            $table->string('code');
            $table->string('brand');
            $table->string('serial_no');
            $table->string('description');
            $table->string('remarks')->nullable();
            $table->string('invoice_no');
            $table->string('date_purchased');
            $table->string('status');

            $table->bigInteger('computer_id');
            $table->bigInteger('site_id');

            $table->string('added_by');
            $table->string('edited_by');

            $table->string('is_Defective',1)->default(0);
            $table->string('for_disposal',1)->default(0);
            $table->string('is_disposed',1)->default(0);

            $table->string('prev_user')->default('N/A');
            $table->string('prev_user_dept')->default('N/A');
            $table->string('return_remarks')->default('N/A');
            $table->string('date_returned')->default('N/A');

            $table->string('i_user')->nullable();
            $table->string('i_department')->nullable();
            $table->string('i_cost')->nullable();
            $table->string('i_color')->nullable();
            $table->string('i_status')->nullable();
            $table->string('i_remarks')->nullable();
            $table->string('i_date_issued')->nullable();

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
        Schema::dropIfExists('items');
    }
};
