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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address')->nullable();
            $table->boolean("checked");
            $table->text('description')->nullable();
            $table->string('interest')->nullable();
            $table->date("date_of_birth");
            $table->string("email");
            $table->string("account");

            $table->unsignedBigInteger('credit_card_id');
            $table->foreign('credit_card_id')->references('id')->on('credit_cards');

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
        Schema::dropIfExists('clients');
    }
};
