<?php

namespace App\Policies;

use App\Models\Item;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use App\Models\Order;
class ItemPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        return $user !== null;

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Order $order, Item $item): bool
    {
        //
        return $order->id === $item->order_id && $user->id === $order->user_id;

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return $user !== null;


    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Item $item): bool
    {
        //
        return $user->id === $item->user_id;

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Item $item): bool
    {
        //
        return $user->id === $item->user_id;

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Item $item): bool
    {
        //
        return $user->id === $item->user_id;

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Item $item): bool
    {
        //
        return $user->id === $item->user_id;

    }
}
