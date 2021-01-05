<?php

use App\Url;
use Illuminate\Database\Seeder;

class UrlSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $domains = Url::getDomains();
        foreach ($domains as $domain) {
            Url::query()->insert(['domain' => $domain]);
        }
    }
}
