<?php

namespace App\Http\Controllers;

use App\Repositories\RateRepository;
use App\Services\ScrapeService;
use Illuminate\Http\Request;

class ScrapeController extends Controller
{
    protected $rateRepository;
    protected $scrapeService;

    public function __construct(RateRepository $rateRepository, ScrapeService $scrapeService)
    {
        $this->rateRepository = $rateRepository;
        $this->scrapeService = $scrapeService;
    }

    public function scrapeAndSave()
    {
        $data = $this->scrapeService->scrape();
        $this->rateRepository->saveData($data);

        return response()->json($data);
    }
}

?>