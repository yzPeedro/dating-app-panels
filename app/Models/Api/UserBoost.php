<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Guarded([])]
class UserBoost extends ApiModel
{

    public function boost(): BelongsTo
    {
        return $this->belongsTo(Boost::class, 'boost_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
