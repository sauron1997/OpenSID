<?php

declare(strict_types=1);

namespace Donjo\Domain\Entities;

/**
 * Cluster — Wilayah (Territory) entity.
 *
 * Represents a single row from tweb_wil_clusterdesa. The table uses
 * a single-row pattern: Dusun, RW, and RT are all rows distinguished
 * by sentinel values:
 *   - Dusun: rt='0' AND rw='0'
 *   - RW:    rt='0' AND rw!='0'
 *   - RT:    rt!='0' AND rw!='0'
 *
 * This entity models all three levels uniformly with helper methods
 * to distinguish the level.
 */
final class Cluster
{
    public ?int $id = null;
    public string $rt = '0';
    public string $rw = '0';
    public string $dusun = '0';
    public ?int $idKepala = null;
    public ?string $lat = null;
    public ?string $lng = null;
    public ?int $zoom = null;
    public ?string $path = null;
    public ?string $mapTipe = null;

    /**
     * Hydrate entity from database row array.
     *
     * @param array<string, mixed> $data
     */
    public function __construct(array $data = [])
    {
        if (isset($data['id'])) {
            $this->id = (int) $data['id'];
        }
        $this->rt = isset($data['rt']) ? (string) $data['rt'] : '0';
        $this->rw = isset($data['rw']) ? (string) $data['rw'] : '0';
        $this->dusun = isset($data['dusun']) ? (string) $data['dusun'] : '0';
        $this->idKepala = isset($data['id_kepala']) ? (int) $data['id_kepala'] : null;
        $this->lat = $data['lat'] ?? null;
        $this->lng = $data['lng'] ?? null;
        $this->zoom = isset($data['zoom']) ? (int) $data['zoom'] : null;
        $this->path = $data['path'] ?? null;
        $this->mapTipe = $data['map_tipe'] ?? null;
    }

    /**
     * Is this a Dusun-level cluster?
     */
    public function isDusun(): bool
    {
        return $this->rt === '0' && $this->rw === '0';
    }

    /**
     * Is this an RW-level cluster?
     */
    public function isRw(): bool
    {
        return $this->rt === '0' && $this->rw !== '0';
    }

    /**
     * Is this an RT-level cluster?
     */
    public function isRt(): bool
    {
        return $this->rt !== '0' && $this->rw !== '0';
    }

    /**
     * Get a human-readable label.
     */
    public function getLabel(): string
    {
        if ($this->isDusun()) {
            return 'Dusun ' . $this->dusun;
        }
        if ($this->isRw()) {
            return 'RW ' . $this->rw . ' - Dusun ' . $this->dusun;
        }
        return 'RT ' . $this->rt . ' / RW ' . $this->rw . ' - Dusun ' . $this->dusun;
    }

    public function hasKepala(): bool
    {
        return $this->idKepala !== null;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id'        => $this->id,
            'rt'        => $this->rt,
            'rw'        => $this->rw,
            'dusun'     => $this->dusun,
            'id_kepala' => $this->idKepala,
            'lat'       => $this->lat,
            'lng'       => $this->lng,
            'zoom'      => $this->zoom,
            'path'      => $this->path,
            'map_tipe'  => $this->mapTipe,
        ];
    }
}
