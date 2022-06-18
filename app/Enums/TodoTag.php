<?php

namespace App\Enums;

class TodoTag
{
    const Blue = 1;
    const Red = 2;
    const Orange = 3;
    const White = 4;
    const Black = 5;
    const Banafsh = 6;

    /** Get title */
    public  static function getTitle($number)
    {
    	return match ($number) {
            self::Blue => ['title' => 'آبی', 'code' => '#0000FF'],
            self::Red => ['title' => 'قرمز', 'code' => '#FF0000'],
            self::Orange => ['title' => 'نارنجی', 'code' => '#FFA500'],
            self::White => ['title' => 'سفید', 'code' => '#111111'],
            self::Black => ['title' => 'سیاه', 'code' => '#000000'],
            self::Banafsh => ['title' => 'بنفش', 'code' => '#800080'],
    	};
    }

    public static function toArray()
    {
        return [
            ['id' => self::Blue, 'title' => 'آبی', 'code' => '#0000FF'],
            ['id' => self::Red, 'title' => 'قرمز', 'code' => '#FF0000'],
            ['id' => self::Orange, 'title' => 'نارنجی', 'code' => '#FFA500'],
            ['id' => self::White, 'title' => 'سفید', 'code' => '#111111'],
            ['id' => self::Black, 'title' => 'سیاه', 'code' => '#000000'],
            ['id' => self::Banafsh, 'title' => 'بنفش', 'code' => '#800080']
        ];
    }
}