<?php

declare(strict_types=1);

namespace Donjo\Domain\ValueObjects;

use Donjo\Domain\Exceptions\ValidationException;

/**
 * NomorKK — Nomor Kartu Keluarga (16-digit family card number).
 *
 * Immutable value object. Validates that the KK number is exactly
 * 16 digits, following the same regional coding pattern as NIK.
 */
final class NomorKK
{
    private string $value;

    public function __construct(string $value)
    {
        $trimmed = trim($value);

        if ($trimmed === '') {
            throw new ValidationException('Nomor KK tidak boleh kosong.');
        }

        if (!preg_match('/^\d{16}$/', $trimmed)) {
            throw new ValidationException(
                sprintf('Nomor KK harus tepat 16 digit angka, diberikan: "%s".', $trimmed)
            );
        }

        $this->value = $trimmed;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Extract the province code (first 2 digits).
     */
    public function getKodeProvinsi(): string
    {
        return substr($this->value, 0, 2);
    }

    /**
     * Extract the district code (digits 3-4).
     */
    public function getKodeKabupaten(): string
    {
        return substr($this->value, 2, 2);
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }
}
