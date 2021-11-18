<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceivedNoteProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('received_note_product', function (Blueprint $table) {
            $table->unsignedBigInteger('received_note_id');
            $table->unsignedBigInteger('product_id');
            $table->smallInteger('quantity');
            $table->integer('price');

            $table->timestamps();

            $table->primary(['received_note_id', 'product_id']);
            $table->foreign('received_note_id')->references('id')->on('received_notes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('received_note_product');
    }
}
