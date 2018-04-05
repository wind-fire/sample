<?php

namespace App\Policies;

use App\Models\User;
Use App\Models\Status;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatusPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */

    public function destroy(User $user, Status $status)
    {
        return $user->id === $status->user_id;
    }

    public function __construct()
    {
        //
    }
}
