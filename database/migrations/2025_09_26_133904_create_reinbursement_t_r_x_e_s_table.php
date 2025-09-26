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
        Schema::create('reinbursement_trx', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_account')->constrained('account');
            $table->foreignId('id_employe')->constrained('employe');
            $table->double('total_amount')->default(0);
            $table->text('note')->nullable();
            $table->string('approve_by', 128)->nullable();
            $table->date('approve_at')->nullable();
            $this->base($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reinbursement_trx');
    }
};
