<?php

namespace App\Models\Api;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

#[Guarded([])]
class User extends ApiModel implements \Illuminate\Contracts\Auth\CanResetPassword
{
    use Notifiable;
    use CanResetPassword;

    public function details(): HasOne
    {
        return $this->hasOne(UserDetail::class, 'user_id', 'id');
    }

    public function interests(): HasOne
    {
        return $this->hasOne(UserInterest::class, 'user_id', 'id');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(UserPhoto::class, 'user_id', 'id');
    }

    public function verifications(): HasMany
    {
        return $this->hasMany(UserVerification::class, 'user_id', 'id');
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(UserSubscription::class, 'user_id', 'id');
    }

    public function boosts(): HasMany
    {
        return $this->hasMany(UserBoost::class, 'user_id', 'id');
    }

    public function reportsReceived(): HasMany
    {
        return $this->hasMany(UserReport::class, 'user_id', 'id');
    }

    public function reportsMade(): HasMany
    {
        return $this->hasMany(UserReport::class, 'reported_by', 'id');
    }


    public function getActiveSubscriptionAttribute(): ?Subscription
    {
        return $this
            ->subscriptions()
            ->with(['subscription' => function ($query) {
                $query->where('is_active', '=', true);
            }])
            ->where('expires_at', '>=', now())
            ->first()
            ?->subscription;
    }

    public function getActiveBoostAttribute(): ?Boost
    {
        return $this
            ->boosts()
            ->with(['boost' => function ($query) {
                $query->where('is_active', '=', true);
            }])
            ->where('expires_at', '>=', now())
            ->first()
            ?->boost;
    }
}
