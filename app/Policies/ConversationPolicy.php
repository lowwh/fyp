<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Conversation;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConversationPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view(User $user, Conversation $conversation)
    {
        return $conversation->users->contains($user);
    }

    public function sendMessage(User $user, Conversation $conversation)
    {
        return $conversation->users->contains($user);
    }
}
