<?php

namespace App\Models;

use App\Traits\AuditedBySoftDelete;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReinbursementDetail extends Model
{
    use HasFactory, Notifiable, AuditedBySoftDelete, SoftDeletes;
    protected $table = 'reinbursement_detail';
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    public function reinbursement_trx()
    {
        return $this->belongsTo(ReinbursementTRX::class, 'id_reinbursement_trx');
    }
}
