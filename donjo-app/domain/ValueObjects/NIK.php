<?php

declare(strict_types=1);

namespace Donjo\Domain\ValueObjects;

use Donjo\Domain\Exceptions\ValidationException;

/**
 * NIK (Nomor Induk Kependudukan) — 16-digit Indonesian national ID number.
 * Immutable value object.
 */
final class NIK
{
    private string $value;

    /**
     * @throws ValidationException if $nik is not exactly 16 numeric digits.
     */
    public function __construct(string $nik)
    {
        $nik = trim($nik);

        if (!preg_match('/^\d{16}$/', $nik)) {
            throw new ValidationException(
                'NIK must be exactly 16 numeric digits',
                ['nik' => "Invalid NIK: got '" . substr($nik, 0, 20) . "'"]
            );
        }

        $this->value = $nik;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
