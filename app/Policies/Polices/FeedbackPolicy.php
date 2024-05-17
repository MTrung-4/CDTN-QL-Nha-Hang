<?php

namespace App\Policies\Polices;

use App\Models\User;

class FeedbackPolicy
{
    public function view(User $user)
    {
        return $user->role === 'admin' || $user->role === 'staff'; 
    }
}
