<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * VerifyMail Class
 * @category            Mailable
 * @DateOfCreation      19 March 2018
 * @ShortDescription    This class sends the verification mail after registeration
 */
class VerifyMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $user;
    /**
     * @DateOfCreation      18 September 2018
     * @ShortDescription   Create a new message instance.
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
    /**
     * @DateOfCreation      18 September 2018
     * @ShortDescription    Build the message.
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.verifyUser');
    }
}
