<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $fillable = ['domain'];

    protected static $domains = [
        'konsultatsiyapro.ru',
        'yuristy-konsultacia.ru',
        'konsultatsiyapro.ru.com',
        'konsultatsiyapro.icu',
        'konsultatsiyapro.site',
        'konsultatsiyapro.xyz',
        'xn--80aqeejfehjfmk6b3e5b.ru.com',
        'xn--80aqeejfehjfmk6b3e5b.xn--p1acf',
        'xn--80aqeejfehjfmk6b3e5b.xyz',
        'xn--80aqeejfehjfmk6b3e5b.xn--p1ai'
    ];

    public $timestamps = false;


    public function seo()
    {
        return $this->hasOne(Seo::class);
    }

    /**
     * @return array
     */
    public static function getDomains()
    {
        return self::$domains;
    }

    /**
     * @param string $domain
     */
    public static function setDomains(string $domain){
        array_push(self::$domains, $domain);
    }
}
