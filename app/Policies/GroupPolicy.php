<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Group $group)
    {
        $responsable = $group->responsable()->first();

        $registration = $responsable->registrations();

        $registration = $responsable->registrations()->where('start_date', '<=', $group->created_at)
            ->where('end_date', '>', $group->created_at)
            ->first();

        if ($registration && $registration->institute_id == $user->institute()->first()->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Group $group)
    {
        $responsable = $group->responsable()->first();

        $registration = $responsable->registrations();

        $registration = $responsable->registrations()->where('start_date', '<=', $group->created_at)
            ->where('end_date', '>', $group->created_at)
            ->first();

        if ($registration && $registration->institute_id == $user->institute()->first()->id) {
            return true;
        }

        return false;
    }
}
