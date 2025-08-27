<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk');
            $table->foreignId('category_id')->constrained()->cascadeOnDelete(); // relasi ke categories
            $table->boolean('is_featured')->default(false); // featured / not featured
            $table->decimal('harga', 12, 2);
            $table->text('mini_deskripsi')->nullable();
            $table->longText('deskripsi')->nullable();
            $table->json('spesifikasi')->nullable(); // pakai repeatable field
            $table->string('main_image')->nullable();
            $table->json('thumbnails')->nullable(); // multiple image
            $table->integer('stock')->default(0);
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
