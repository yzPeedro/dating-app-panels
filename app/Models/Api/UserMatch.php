<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Relations\HasOne;

class UserMatch extends ApiModel
{


    public function firstUser(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'first_user');
    }

    public function secondUser(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'second_user');
    }
}
