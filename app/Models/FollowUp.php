<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FollowUp extends Model
{
    protected $fillable = [
        'report_id',
        'coordinator_id',
        'pihak_tujuan',
        'catatan',
        'tanggal_diteruskan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_diteruskan' => 'datetime',
        ];
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    public function coordinator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'coordinator_id');
    }
}