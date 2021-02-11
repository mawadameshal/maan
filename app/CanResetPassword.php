<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CanResetPassword extends Model
{
    //
    public function sendPasswordResetNotification($token) {
        // do your callback here
        $token->subject($this->getEmailSubject());
    }
}
