<?php

namespace App\Models;

use App\Traits\AuditedBySoftDelete;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReinbursementTRX extends Model
{
    use HasFactory, Notifiable, AuditedBySoftDelete, SoftDeletes;
    protected $table = 'reinbursement_trx';
    protected $guarded = ['id'];

    public function employe()
    {
        return $this->belongsTo(Employe::class, 'id_employe');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'id_account');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function detailReinbursement()
    {
        return $this->hasMany(ReinbursementDetail::class, 'id_reinbursement_trx');
    }
}
