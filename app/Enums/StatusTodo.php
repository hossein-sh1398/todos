<?php

namespace App\Enums;

class StatusTodo
{
    const Registered = 1;
    const Failed = 2;
    const Confirmed = 3;
    const Done = 4;

    /** Get title */
    public  static function getTitle($number)
    {
    	return match ($number) {
             self::Registered => 'ثبت شده',

            self::Failed => 'رد شده',

            self::Confirmed => 'تایید شده',

            self::Done => 'انجام شده',
    	};
    }

    public static function toArray()
    {
         return [
            [ 'id' => self::Registered, 'title' => 'ثبت شده' ],
            [ 'id' => self::Failed, 'title' => 'رد شده' ],
            [ 'id' => self::Confirmed, 'title' => 'تایید شده' ],
            [ 'id' => self::Done, 'title' => 'انجام شده' ],
         ];
    }
}