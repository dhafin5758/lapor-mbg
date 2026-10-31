<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportReview extends Model
{
    protected $fillable = [
        'report_id',
        'reviewer_id',
        'catatan',
        'perlu_tindak_lanjut',
    ];

    protected function casts(): array
    {
        return [
            'perlu_tindak_lanjut' => 'boolean',
        ];
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}