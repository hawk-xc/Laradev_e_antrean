<?php

// app/Helpers/RoleHelper.php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class RoleHelper
{
    // cara penggunaanya gini
    // @if (\App\Helpers\RoleHelper::isAdmin())
    //     <span>kode disini</span>
    // @endif

    public static function isAdmin()
    {
        $user = Auth::user();
        return $user && $user->role_id == 1; // Sesuaikan dengan role_id admin Anda
    }

    public static function isHelpdesk()
    {
        $user = Auth::user();
        return $user && $user->role_id == 2; // Sesuaikan dengan role_id admin Anda
    }

    public static function isTechnician()
    {
        $user = Auth::user();
        return $user && $user->role_id == 3; // Sesuaikan dengan role_id helpdesk Anda
    }

    public static function isUser()
    {
        $user = Auth::user();
        return $user && $user->role_id == 4; // Sesuaikan dengan role_id user Anda
    }
}
