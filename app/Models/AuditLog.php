<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'action',
        'target_type',
        'target_id',
        'keterangan',
    ];

    // Hubungan ke Admin
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
