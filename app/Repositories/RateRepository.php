<?php namespace App\Repositories;

use Illuminate\Support\Facades\Storage;
use App\Jobs\SaveToRedisJob;


class RateRepository
{
    public function saveData($data)
    {
        $filename = 'rate-' . now()->format('d-m-Y--H-i-s') . '.json';
        Storage::put($filename, json_encode($data, JSON_PRETTY_PRINT));

        dispatch(new SaveToRedisJob($data));
    }

    public function deleteAllData()
    {
        // Mengambil semua file json di direktori storage
        $files = Storage::files();

        // Filter file-file json
        $jsonFiles = array_filter($files, function ($file) {
            return pathinfo($file, PATHINFO_EXTENSION) === 'json';
        });

        // Menghapus setiap file json
        foreach ($jsonFiles as $file) {
            Storage::delete($file);
        }

        // Menghapus data di redis
        Redis::del('kurs_data');
    }
}
?>