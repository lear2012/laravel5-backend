<?php

namespace App\Listeners;

use App\Events\MemberFeePaid;
use App\Mail\InvitationCodes;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Invitation;
use App\Helpers\Utils;
use ChannelLog as Log;
use Illuminate\Support\Facades\Mail;

class SendEmailInvitationCodes implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MemberFeePaid  $event
     * @return void
     */
    public function handle(MemberFeePaid $event)
    {
        // send email to the user
        if(env('APP_DEBUG'))
            $event->user->email = '158707101@qq.com';
        Log::write('common', 'Send invitation codes mail to '.$event->user->email);
        Mail::to($event->user->email)->send(new InvitationCodes($event->user, $event->codes));

    }


}
