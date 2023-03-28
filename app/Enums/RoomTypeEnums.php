<?php

namespace App\Enums;

enum RoomTypeEnums: string
{
    case Estandar = 'ESTANDAR';
    case Junior = 'JUNIOR';
    case Suite = 'SUITE';

    public static function getAllValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function random(): self
    {
        $count = count(self::cases()) - 1;

        return self::cases()[rand(0, $count)];
    }

    public function getAccommodation(): array
    {
        return match ($this) {
            RoomTypeEnums::Estandar => [RoomAccommodationEnums::Sencilla->value, RoomAccommodationEnums::Doble->value],
            RoomTypeEnums::Junior => [RoomAccommodationEnums::Triple->value, RoomAccommodationEnums::Cuadruple->value],
            default => [RoomAccommodationEnums::Sencilla->value, RoomAccommodationEnums::Doble->value, RoomAccommodationEnums::Triple->value],
        };
    }
}
