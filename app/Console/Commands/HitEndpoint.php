<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;

class HitEndpoint extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:hit-endpoint' ;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'hits endpoint and returns data';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client();
        $url = 'https://bored-api.appbrewery.com/random';
        try {
            $response = $client->request('GET', $url);
            $statusCode = $response->getStatusCode();
            $body = $response->getBody();
            print_r($body);
            $data = json_decode($body, true);
            echo "Status Code: " . $statusCode . "\n";
            echo "Response Body:\n";
            print_r($data);
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
