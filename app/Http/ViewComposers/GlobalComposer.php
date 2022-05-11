<?php

namespace App\Http\ViewComposers;

use App\Groups;
use App\User;
use App\UserGroup;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class GlobalComposer
{

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $group = Auth::user()->group;
        $permission = unserialize($group['permission']);

        $view->with('user_permission', $permission);
    }
}
