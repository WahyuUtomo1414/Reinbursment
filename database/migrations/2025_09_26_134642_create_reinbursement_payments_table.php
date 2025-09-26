<?php

use App\Traits\BaseModelSoftDelete;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use BaseModelSoftDelete;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reinbursement_payment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_reinbursement_trx')->constrained('reinbursement_trx');
            $table->string('image', 128);
            $table->text('note')->nullable();
            $this->base($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reinbursement_payment');
    }
};
