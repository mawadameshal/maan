<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Validator;

class AuthRestController extends Controller
{
    use ResetsPasswords;

    public function __construct(Guard $auth, PasswordBroker $passwords)
    {
        $this->auth = $auth;
        $this->passwords = $passwords;

        // With this, when logged says: "You're logged!" and not send the email token
        //$this->middleware('guest');
    }
    public function sendResetLinkEmail(Request $request)
    {
        $validator = \Validator::make(
            ['email' => $request->get('email')],
            ['email' => 'required|email|min:6|max:255']
        );

        if($validator->passes()) {
            //$response = $this->passwords->sendResetLink($request->only('email'));
            $response = $this->passwords->sendResetLink($request->only('email'), function ($m) {
                $m->subject($this->getEmailSubject());
            });

            switch ($response) {
                case PasswordBroker::RESET_LINK_SENT:
                    return \Response::json(['success' => 'true']);
                //return redirect()->back()->with('status', trans($response));

                case PasswordBroker::INVALID_USER:
                    return \Response::json(['success' => 'true', 'status' => trans($response)]);
                //return redirect()->back()->withErrors(['email' => trans($response)]);
            }
        } else {
            return \Response::json(['error' => [
                'messages' => $validator->getMessageBag(),
                'rules' => $validator->getRules()
            ]]);
        }
    }
}