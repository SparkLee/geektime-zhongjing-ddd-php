<?php

namespace App\Domain\Common;

enum EffectiveStatus: int
{
    case Effective = 1;
    case Ineffective = 2;

    public function descr(): string
    {
        return match ($this) {
            self::Effective => '有效',
            self::Ineffective => '无效',
        };
    }
}
