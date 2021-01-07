<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\sendMerchandiseNewsletterJob;
use App\Shop\Entity\User;
use App\Shop\Entity\Merchandise;

class SendMerchandiseNewsletterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shop:sendMerchandiseNewsletter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '寄送商品電子報';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('寄送商品電子報 Start!');
        //撈取最新10筆商品資料
        $total_row = 10;
        $MerchandiseCollection = Merchandise::orderby('created_at', 'desc')
                                                ->where('status', 'S')    //可販售
                                                ->take($total_row)
                                                ->get();

        //批次寄送給會員
        $row_per_page = 10;
        $page = 1;
        while(true){

            $skip = ($page-1) * $row_per_page;

            $UserCollection = User::orderby('id', 'asc')
                                    ->skip($skip)               //略過筆數
                                    ->take($row_per_page)       //抓取筆數
                                    ->get();

            if(!$UserCollection->count()){
                $this->error('會員資料結束!');
                break;
            }

            foreach($UserCollection as $User){
                sendMerchandiseNewsletterJob::dispatch($User, $MerchandiseCollection)
                                            ->onQueue('MerchandiseNewsletter');
            }

            $page++;
        }
        $this->info('寄送商品電子報 End!');
    }
}
