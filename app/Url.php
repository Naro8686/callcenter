<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $fillable = ['domain'];

    protected static $domains = [
        'konsultatsiyapro.ru',              // ДЕПАРТАМЕНТ ЗАЩИТЫ ПРАВ ПОТРЕБИТЕЛЕЙ
        'yuristy-konsultacia.ru',           //Пенсионный фонд РФ
        'konsultatsiyapro.ru.com',          //Деятельность департамента городского имущества
        'konsultatsiyapro.icu',             //Защита прав граждан в полиции по Москве
        'urist-konsultacia.ru',             //Роструд: консультация инспектора
        'yur-konsultacia.ru',               //Автоюрист
        'advokat-help.su',                  //Горячая линия налоговой службы ФНС
        'yourist-help.su',                  //ЗАЩИТА СОЦИАЛЬНЫХ ПРАВ ГРАЖДАН
        'yuridicheskayakonsultacia.ru',     //Кадастровые инженеры в Москве и Московской области
        'yurkonsultatsia.ru',               //COMING SOON
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
