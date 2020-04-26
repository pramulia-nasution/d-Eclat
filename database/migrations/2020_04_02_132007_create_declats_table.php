<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeclatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('declats', function (Blueprint $table) {
            $table->id();
            $table->string('inisial');
            $table->text('tidList');
            $table->integer('supportCount');
            $table->integer('iterasi');
            $table->double('support');
            $table->string('helper');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('declats');
    }
}
