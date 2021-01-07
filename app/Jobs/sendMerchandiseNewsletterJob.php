<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Database\Eloquent\Collection;
use App\Shop\Entity\User;
use Mail;

class sendMerchandiseNewsletterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $User;
    protected $MerchandiseCollection;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, Collection $merchandiseCollection)
    {
        $this->User = $user;
        $this->MerchandiseCollection = $merchandiseCollection;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mail_binding = [
            'User' => $this->User,
            'MerchandiseCollection' => $this->MerchandiseCollection
        ];

        Mail::send('email.merchandiseNewsletter', $mail_binding, 
            function($mail) use($mail_binding){
                $mail->from('vincentpan2005@gmail.com');

                $mail->to($mail_binding['User']->email);

                $mail->subject('Shop Laravel 最新商品電子報!');
            }
        );
    }
}
