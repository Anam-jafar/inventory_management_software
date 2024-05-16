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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('category_id');
            $table->integer('price');
            $table->integer('quantity');
            $table->integer('restock_limit')->nullable(true);
            $table->string('description')->nullable(true);
            $table->string('image')->nullable(true);
            $table->string('slug');
            $table->boolean('status')->default(1);
            $table->boolean('deleted')->default(0);
            $table->timestamps();
            

            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
