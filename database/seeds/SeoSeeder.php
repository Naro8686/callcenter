<?php

use App\Url;
use Illuminate\Database\Seeder;

class SeoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $urlID = Url::query()->pluck('id')->toArray();
        foreach ($urlID as $id){
            \App\Seo::query()->create([
                'title'=>'Консультант - бесплатная консультация специалиста',
                'keywords'=>'konsultant,consultant,консультант',
                'description'=>'Получить консультация можно абсолютно бесплатно и анонимно: по месту жительства, отправлением заказного письма или онлайн.',
                'text'=>'',
                'url_id'=>$id,
            ]);
        }
    }
}
