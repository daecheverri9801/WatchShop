<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->foreignId('fk_category_id')->constrained('categories', 'id')->onDelete('cascade');
                $table->string('product_name', 255);
                $table->string('product_ref', 100)->unique();
                $table->string('slug')->unique();
                $table->foreignId('fk_brand_id')->constrained('brands', 'id')->onDelete('set null');
                $table->enum('genre', ['Male', 'Female', 'Unisex'])->comment('Género');
                $table->foreignId('fk_color_id')->constrained('colors', 'id')->onDelete('set null');
                $table->foreignId('fk_material_id')->constrained('materials', 'id')->onDelete('set null');
                $table->boolean('uv_protection')->default(false)->comment('Protección UV')->nullable();
                $table->string('water_resistance', 50)->default(0)->nullable();
                $table->integer('size')->default(0)->comment('Tamaño del pulso en mm')->nullable();
                $table->decimal('price', 10, 2)->unsigned();
                $table->string('main_image')->nullable()->comment('Ruta de la imagen principal');
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
