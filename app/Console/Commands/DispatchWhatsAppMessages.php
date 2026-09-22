<?php

namespace App\Console\Commands;

use App\Models\ReportMessagesWhatsappModel;
use App\Traits\WhatsAppSendTrait;
use Illuminate\Console\Command;

class DispatchWhatsAppMessages extends Command
{
    use WhatsAppSendTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:dispatch-whats-app-messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To Send Pending And Failed WhatsApp Messages';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $listOfPendingMessages = ReportMessagesWhatsappModel::orderBy('id','asc')->where('trycount',0)->where('status','pending')->limit(25)->get();
        foreach ($listOfPendingMessages as $PendingMessage) 
        {
            $this->sendNowWhatsApp($PendingMessage);
        }
    }
}
