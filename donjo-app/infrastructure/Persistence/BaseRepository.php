<?php
declare(strict_types=1);
namespace Donjo\Infrastructure\Persistence;
abstract class BaseRepository
{
    protected $db;
    protected string $table = "";
    public function __construct($db)
    {
        $this->db = $db;
    }
    protected function findOneBy(string $column, $value): ?array
    {
        return $this->db->where($column, $value)->get($this->table)->row_array();
    }
    protected function findAllBy(string $column, $value): array
    {
        return $this->db->where($column, $value)->get($this->table)->result_array();
    }
    protected function insert(array $data): int
    {
        $this->db->insert($this->table, $data);
        return (int) $this->db->insert_id();
    }
    protected function update(int $id, array $data): bool
    {
        return $this->db->where("id", $id)->update($this->table, $data) !== false;
    }
    protected function deleteById(int $id): bool
    {
        return $this->db->where("id", $id)->delete($this->table) !== false;
    }
}