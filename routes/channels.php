<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('medecin-chat', function () {
    return Auth::guard('patient')->check();
});

Broadcast::channel('patient-chat', function () {
    return Auth::guard('medecin')->check();
});

Broadcast::channel('new-traitement', function() {
    return Auth::guard('patient')->check();
});

Broadcast::channel('new-consultation', function() {
    return Auth::guard('medecin')->check();
});
