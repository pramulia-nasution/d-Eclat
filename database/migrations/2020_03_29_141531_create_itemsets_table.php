<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itemsets', function (Blueprint $table) {
            $table->id();
            $table->string('inisial');
            $table->string('item');
            $table->string('attribut');
            $table->text('tidList')->nullable();
            $table->integer('supportCount')->nullable();
            $table->double('support')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('itemsets');
    }
}
