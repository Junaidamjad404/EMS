<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('user.{id}', function ($user, $id) {
        dd((int) $user->id === (int) $id);
    return (int) $user->id === (int) $id;
});


