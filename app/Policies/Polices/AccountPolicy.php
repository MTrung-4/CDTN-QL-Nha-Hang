<?php

namespace App\Policies\Polices;

use App\Models\User;

class AccountPolicy
{
    public function view(User $user)
    {
        return $user->role === 'admin'; 
    }

    public function create(User $user)
    {
        return $user->role === 'admin'; 
    }
    
    public function update(User $user)
    {
        return $user->role === 'admin';
    }
    
    public function delete(User $user)
    {
        return $user->role === 'admin'; 
    }
    
    public function edit(User $user)
    {
        return $user->role === 'admin';
    }
}
