<?php

namespace App\Models;

use App\Traits\AuditedBySoftDelete;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReinbursementPayment extends Model
{
    use HasFactory, Notifiable, AuditedBySoftDelete, SoftDeletes;
    protected $table = 'reinbursement_payment';
    protected $guarded = ['id'];

    public function reinbursement_trx()
    {
        return $this->hasOne(ReinbursementTRX::class, 'id_reinbursement_trx');
    }
}
