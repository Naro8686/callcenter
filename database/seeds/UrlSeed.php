<?php

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
        $domains = [
            'konsultatsiyapro.ru.com',
            'konsultatsiyapro.icu',
            'konsultatsiyapro.site',
            'konsultatsiyapro.xyz',
            'xn--80aqeejfehjfmk6b3e5b.ru.com',
            'xn--80aqeejfehjfmk6b3e5b.xn--p1acf',
            'xn--80aqeejfehjfmk6b3e5b.xyz',
            'xn--80aqeejfehjfmk6b3e5b.xn--p1ai'
        ];
        foreach ($domains as $domain){
            \App\Url::query()->insert(['domain'=>$domain]);
        }
    }
}
