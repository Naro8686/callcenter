<?php

use Illuminate\Database\Seeder;

class YurkonsultatsiaUrlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $slugs =[
            'kontakty',
            'ugolovnyy-yurist',
            'avtoyurist',
            'yurist-po-vzyskaniyu-dolgov',
            'zhilishchnyy-yurist',
            'yurist-po-zashchite-prav-potrebiteley',
            'zemelnyy-yurist',
            'meditsinskiy-yurist',
            'yurist-po-nasledstvennym-delam',
            'pensionnyy-yurist',
            'semeynyy-yurist',
            'strakhovoy-yurist',
            'yurist-po-trudovomu-pravu',
            'yurist-po-nedvizhimosti',
            'klienti-i-partneri',
            'novosti',
            'information/privacy-policy',
            'novosti/medvedev-poobeshchal-uzhestochit-otvetstvennost-za-narushenie-pdd',
            'novosti/natsionalnaya-medpalata-vstala-na-zashchitu-vracha',
            'novosti/verkhovnyy-sud-razyasnil-pravila-razdela-imushchestva-esli-u-odnogo-iz-suprugov-na-rukakh-ispolnitel',
        ];
        $url =\App\Url::query()->where('domain','yurkonsultatsia.ru')->first();
        foreach ($slugs as $slug){
            \App\Seo::query()->create([
                'title'=>'Консультант - бесплатная консультация специалиста',
                'slug'=>$slug,
                'url_id'=>$url->id,
            ]);
        }
    }
}
