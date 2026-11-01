<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    public function reports(): HasMany
{
    return $this->hasMany(Report::class);
}

public function reviews(): HasMany
{
    return $this->hasMany(ReportReview::class, 'reviewer_id');
}

public function followUps(): HasMany
{
    return $this->hasMany(FollowUp::class, 'coordinator_id');
}
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $fillable = [
    'name',
    'email',
    'password',
    'role',
];

}
