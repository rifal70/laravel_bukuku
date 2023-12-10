<?php
namespace App\Services;
use Goutte\Client;

class ScrapeService
{
    public function scrape()
    {
        $client = new Client();
        $crawler = $client->request('GET', 'https://kursdollar.org/');

        // Mengambil informasi tanggal dan jam dari halaman web
        $dateInfo = $crawler->filter('.scrape-info')->text();
        preg_match('/(\d{2}-\d{2}-\d{4}) (\d{2}:\d{2})/', $dateInfo, $matches);
        $date = $matches[1];
        $time = $matches[2];

        // Mengambil data kurs mata uang
        $rates = [];
        $crawler->filter('.table-kurs tbody tr')->each(function ($row) use (&$rates) {
            $currency = $row->filter('td:nth-child(1)')->text();
            $buy = (float) str_replace(',', '', $row->filter('td:nth-child(2)')->text());
            $sell = (float) str_replace(',', '', $row->filter('td:nth-child(3)')->text());
            $average = (float) str_replace(',', '', $row->filter('td:nth-child(4)')->text());
            $wordRate = (float) str_replace(',', '', $row->filter('td:nth-child(5)')->text());

            $rates[] = [
                'currency' => $currency,
                'buy' => $buy,
                'sell' => $sell,
                'average' => $average,
                'word_rate' => $wordRate,
            ];
        });

        // Format data sesuai kebutuhan
        $result = [
            'meta' => [
                'date' => $date,
                'time' => $time,
                // Tambahkan informasi tambahan seperti nama bank atau waktu scrap
            ],
            'rates' => $rates,
        ];

        return $result;
    }
}
?>