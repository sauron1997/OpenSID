<?php

declare(strict_types=1);

namespace Donjo\Domain\ValueObjects;

/**
 * JenisKelamin — Gender classification following Indonesian civil registration.
 * Class-constant based enum (PHP 7.4 compatible).
 */
final class JenisKelamin
{
    public const LAKI_LAKI = 1;
    public const PEREMPUAN = 2;

    /**
     * @param int $value
     * @return bool
     */
    public static function isValid(int $value): bool
    {
        return in_array($value, [self::LAKI_LAKI, self::PEREMPUAN], true);
    }

    /**
     * @param int $value
     * @return string
     */
    public static function getLabel(int $value): string
    {
        switch ($value) {
            case self::LAKI_LAKI:
                return 'Laki-laki';
            case self::PEREMPUAN:
                return 'Perempuan';
            default:
                return 'Tidak Diketahui';
        }
    }

    /**
     * @param int|null $value
     * @return bool
     */
    public static function isLakiLaki(?int $value): bool
    {
        return $value === self::LAKI_LAKI;
    }

    /**
     * @param int|null $value
     * @return bool
     */
    public static function isPerempuan(?int $value): bool
    {
        return $value === self::PEREMPUAN;
    }
}
