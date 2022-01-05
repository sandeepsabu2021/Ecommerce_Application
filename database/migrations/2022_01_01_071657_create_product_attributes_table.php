<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('price');
            $table->bigInteger('quantity');
            $table->string('brand', 100)->nullable();
            $table->string('color', 20)->nullable();
            $table->string('size', 20)->nullable();
            $table->string('gender', 10);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_attributes');
    }
}
