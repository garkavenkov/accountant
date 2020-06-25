<?php

namespace Tests;

use App\Models\User;

class HttpHelper
{
    public static function baererToken(User $user)
    {
        return ['Authorization' => 'Bearer ' . $user->api_token];
    }

    public static function apiToken($url, User $user)
    {
        return "$url?api_token={$user->api_token}";
    }
}