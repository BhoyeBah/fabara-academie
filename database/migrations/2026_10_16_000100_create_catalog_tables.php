<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('color', 7)->default('#0b6e55');
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });

        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->string('code', 20)->unique();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('description', 500);
            $table->string('level', 30)->default('Débutant');
            $table->unsignedSmallInteger('hours')->default(0);
            $table->unsignedSmallInteger('lessons')->default(0);
            $table->unsignedInteger('price');
            $table->json('program')->nullable();
            $table->text('drive_url')->nullable(); // chiffré par le modèle
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // nullOnDelete : si un client supprime son compte, la commande reste pour la comptabilité mais sans donnée personnelle
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('reference', 20)->unique();
            $table->unsignedInteger('total');
            $table->string('status', 20)->default('pending'); // pending, paid, cancelled
            $table->string('payment_method', 30)->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->nullable()->constrained()->nullOnDelete();
            $table->string('course_code', 20);
            $table->string('course_title');
            $table->unsignedInteger('price');
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->text('value')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('categories');
    }
};
