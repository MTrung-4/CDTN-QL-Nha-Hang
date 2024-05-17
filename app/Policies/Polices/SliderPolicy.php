<?php

namespace App\Policies\Polices;

use App\Models\User;

class SliderPolicy
{
    public function view(User $user)
    {
        return $user->role === 'admin' || $user->role === 'staff'; 
    }

    public function create(User $user)
    {
        return $user->role === 'admin' || $user->role === 'staff'; 
    }
    
    public function update(User $user)
    {
        return $user->role === 'admin' || $user->role === 'staff';
    }
    
    public function delete(User $user)
    {
        return $user->role === 'admin'|| $user->role === 'staff'; 
    }
    
    public function edit(User $user)
    {
        return $user->role === 'admin' || $user->role === 'staff';
    }
}
