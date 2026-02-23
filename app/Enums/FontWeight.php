<?php

namespace App\Enums;

enum FontWeight: string
{
    case Light = 'light';
    case Normal = 'normal';
    case Medium = 'medium';
    case Semibold = 'semibold';
    case Bold = 'bold';
    case ExtraBold = 'extrabold';

    public function toTailwind(): string
    {
        return match($this) {
            self::Light => 'font-light',
            self::Normal => 'font-normal',
            self::Medium => 'font-medium',
            self::Semibold => 'font-semibold',
            self::Bold => 'font-bold',
            self::Extrabold => 'font-extrabold',
        };
    }
}