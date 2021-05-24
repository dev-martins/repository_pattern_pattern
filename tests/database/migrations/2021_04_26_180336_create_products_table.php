<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
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
            $table->unsignedBigInteger('category_id')->index('products_category_id_foreign');
            $table->string('name')->unique('products_name_unique');
            $table->double('price', 10, 2);
            $table->string('image')->unique('products_image_unique');
            $table->string('url')->unique('products_url_unique');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->foreign('category_id', 'products_category_id_foreign')->references('id')->on('categories')->onDelete('cascade');
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
}
