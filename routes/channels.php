<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\DirectMessage;
use Illuminate\Support\Facades\Storage;


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

Broadcast::channel('direct_message.{id}', function ($user, $directMessageId) {
    Storage::append('test.txt', $user->id);
    Storage::append('test.txt', DirectMessage::CheckDirectMessage($directMessageId, $user->id));

    if (DirectMessage::CheckDirectMessage($directMessageId, $user->id)) {
        Storage::append('test.txt', 'pass');
        return ['id' => $user->id, 'name' => $user->name];
    }
});
