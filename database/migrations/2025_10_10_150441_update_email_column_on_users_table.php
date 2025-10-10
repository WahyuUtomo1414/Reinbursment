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
        Schema::table('users', function (Blueprint $table) {
            // hapus unique constraint dari email
            $table->dropUnique(['email']); // nama index-nya 'users_email_unique' biasanya
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // balikin lagi kalau di-rollback
            $table->unique('email');
        });
    }
};
