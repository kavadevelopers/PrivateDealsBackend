<?php

namespace App\Jobs\aif;

use App\Helpers\DocumentHelper;
use App\Models\InvestorAifKycModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Onboard implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $kyc_id;
    public function __construct(string $kyc_id)
    {
        $this->kyc_id = $kyc_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $kyc = InvestorAifKycModel::where('id', $this->kyc_id)->first();
        if ($kyc) {
            DocumentHelper::aifPPMDocumentSend($kyc);
            DocumentHelper::aifCADocumentSend($kyc);
        }
    }
}
