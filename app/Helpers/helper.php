<?php

use Hekmatinasser\Verta\Verta;
use Carbon\Carbon;

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

function getMiladiDate($date)
{
    return Verta::parse($date)->formatGregorian('Y-n-j H:i:s');
}

function getjalaliDate($date)
{
    if (is_null($date)) {
        return ''; // یا null، ولی برای فرم Blade بهتره ''
    }

    // ادامه تبدیل به تاریخ جلالی
    return Verta::parse($date)->format('Y/m/d'); // مثال
}
