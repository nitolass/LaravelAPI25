<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // $table->foreign('category_id')->references('id')->on('categories');
            $table->foreignId('category_id')->constrained();
            $table->string('name');
            $table->text('description');
            $table->integer('price');


            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
