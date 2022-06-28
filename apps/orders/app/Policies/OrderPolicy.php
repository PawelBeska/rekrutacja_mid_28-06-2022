<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User|null $user
     * @return bool
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Order $order
     * @return bool
     */
    public function view(?User $user, Order $order): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User|null $user
     * @return bool
     */
    public function create(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Order $order
     * @return bool
     */
    public function update(?User $user, Order $order): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User|null $user
     * @param \App\Models\Order $order
     * @return bool
     */
    public function delete(?User $user, Order $order): bool
    {
        return true;
    }

}
