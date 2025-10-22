<?php

use Carbon\Carbon;
use Hekmatinasser\Verta\Verta;

/**
 * تبدیل رشته به slug مناسب
 */
if (!function_exists('make_slug')) {
    function make_slug($string)
    {
        $slug = preg_replace('/\s+/', '-', trim($string));
        $slug = preg_replace('/[^آ-یa-zA-Z0-9۰-۹\-]/u', '', $slug);
        return mb_strtolower($slug, 'UTF-8');
    }
}

/**
 * تبدیل تاریخ میلادی به تاریخ شمسی (Jalali)
 *
 * @param string|Carbon $date
 * @param bool $withTime نمایش ساعت هم اضافه شود؟
 * @return string
 */
if (!function_exists('getJalaliDate')) {
    function getJalaliDate($date, $withTime = false)
    {
        if (is_null($date)) {
            return '';
        }

        if (!($date instanceof Carbon)) {
            $date = Carbon::parse($date);
        }

        $v = new Verta($date);

        return $withTime ? $v->format('Y/m/d H:i:s') : $v->format('Y/m/d');
    }
}

/**
 * تبدیل تاریخ شمسی به تاریخ میلادی برای ذخیره در دیتابیس
 *
 * @param string $jalaliDate مثال: 1404/07/30 15:30:00 یا 1404/07/30
 * @return string فرمت Y-m-d H:i:s
 */
if (!function_exists('jalaliToGregorian')) {
    function jalaliToGregorian($jalaliDate)
    {
        if (!$jalaliDate) {
            return null;
        }

        $v = Verta::parse($jalaliDate); // Verta خودش تاریخ شمسی رو می‌فهمه
        $carbon = Carbon::create($v->year, $v->month, $v->day, $v->hour, $v->minute, $v->second);

        return $carbon->format('Y-m-d H:i:s');
    }
}

/**
 * مثال کوتاه تبدیل به میلادی با ساعت جاری
 */
if (!function_exists('getMiladiDate')) {
    function getMiladiDate($date)
    {
        if (!$date) {
            return null;
        }

        if (!($date instanceof Carbon)) {
            $date = Carbon::parse($date);
        }

        return Verta::parse($date)->formatGregorian('Y-m-d H:i:s');
    }
}
