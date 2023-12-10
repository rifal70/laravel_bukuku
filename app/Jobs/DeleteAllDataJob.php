<?php

namespace App\Jobs;

use App\Repositories\RateRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteAllDataJob implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $rateRepository;

    public function __construct(RateRepository $rateRepository)
    {
        $this->rateRepository = $rateRepository;
    }

    public function handle()
    {
        $this->rateRepository->deleteAllData();
    }
}

?>