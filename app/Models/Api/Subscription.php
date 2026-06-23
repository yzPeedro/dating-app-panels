<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

#[Guarded([])]
class Subscription extends ApiModel
{

    public function userSubscriptions(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            UserSubscription::class,
            'subscription_id',
            'user_id'
        );
    }

    public function getUsersActiveAttribute(): Collection
    {
        return $this
            ->userSubscriptions()
            ->where('expires_at', '>=', now())
            ->get();
    }
}
