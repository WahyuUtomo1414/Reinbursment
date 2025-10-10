<?php

namespace App\Models;

use App\Traits\AuditedBySoftDelete;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employe extends Model
{
    use HasFactory, Notifiable, AuditedBySoftDelete, SoftDeletes;
    protected $table = 'employe';
    protected $guarded = ['id'];

    public function position()
    {
        return $this->belongsTo(Position::class, 'id_position');
    }

    public function divisi()
    {
        return $this->belongsTo(Division::class, 'id_division');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id_employe');
    }
}
