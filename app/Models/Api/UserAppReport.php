<?php

namespace App\Models\Api;

use App\Notifications\UserAppReportAnsweredNotification;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Guarded([])]
class UserAppReport extends ApiModel
{

    protected $casts = [
        'answered' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function answer(string $answer, bool $solved = false): void
    {
        if ($this->isSolved()) {
            return;
        }

        $this->user->notify(
            new UserAppReportAnsweredNotification($answer)
        );

        $this->resolve($solved);
    }

    public function resolve(bool $solved = false): void
    {
        $this->update([
            'answered' => true,
            'validated_at' => now(),
            'status' => $solved ? 'solved' : 'pending',
        ]);
    }

    public function isNotPending(): bool
    {
        return $this->status !== 'pending';
    }

    public function isSolved(): bool
    {
        return $this->status === 'solved';
    }
}
