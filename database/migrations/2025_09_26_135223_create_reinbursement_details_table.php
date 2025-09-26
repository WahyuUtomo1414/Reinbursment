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
        Schema::create('reinbursement_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_reinbursement_trx')->constrained('reinbursement_trx');
            $table->foreignId('id_category')->constrained('category');
            $table->string('name', 255);
            $table->double('amount')->default(0);
            $table->string('image', 128)->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reinbursement_detail');
    }
};
