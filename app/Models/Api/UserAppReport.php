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

    public function answer(string $answer, ?bool $solved = null): void
    {
        $this->user->notify(
            new UserAppReportAnsweredNotification($answer, $this->report_code)
        );

        if (!is_null($solved)) {
            $this->resolve($solved);
        }

        $this->update(['answered' => true]);
    }

    public function resolve(bool $solved): void
    {
        $this->update([
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
