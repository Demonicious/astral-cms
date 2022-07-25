<?php

namespace App\Policies;

use App\Models\Page;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PagePolicy
{
    use HandlesAuthorization;

    public function update(User $user, Page $page) {
        return ($user->super_admin || $user->admin)
            ? Response::allow()
            : Response::deny();
    }

    public function delete(User $user, Page $page) {
        return ($user->super_admin || $user->admin)
            ? Response::allow()
            : Response::deny();
    }
}
