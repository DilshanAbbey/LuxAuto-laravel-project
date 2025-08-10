<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\User;

class CustomUserProvider implements UserProvider
{
    public function retrieveById($identifier)
    {
        return User::findById($identifier);
    }

    public function retrieveByToken($identifier, $token)
    {
        return null; // Not implementing remember tokens for simplicity
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        // Not implementing remember tokens for simplicity
    }

    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials['username']) && empty($credentials['email'])) {
            return null;
        }

        $username = $credentials['username'] ?? $credentials['email'];
        return User::findByCredentials($username, $credentials['password']);
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return password_verify($credentials['password'], $user->password);
    }

    public function rehashPasswordIfRequired(Authenticatable $user, array $credentials, bool $force = false)
    {
        // For this custom implementation, we'll skip rehashing since users are virtual
        // If you want to implement this, you'd need to update the original Customer/Employee records
        return;
    }
}
