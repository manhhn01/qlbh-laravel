<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceivedNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('received_notes', function (Blueprint $table) {
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();

            $table->unsignedBigInteger('manager_id');
            $table->string('deliver_name', 50);
            $table->date('receive_at');
            $table->boolean('status'); //1: da nhan hang 0: da huy
            $table->string('note')->nullable();

            $table->timestamps();

            $table->foreign('manager_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('received_notes');
    }
}
