<?php
declare(strict_types=1);
namespace Donjo\Infrastructure\Auth;
use Donjo\Application\Ports\Inbound\AuthPortInterface;
final class Ci3SessionAuth implements AuthPortInterface
{
    private $db;
    public function __construct($db) { $this->db = $db; }
    public function checkPermission($userId, string $resource, string $action): bool
    {
        if (!$userId) return false;
        $user = $this->getUser($userId);
        if (!$user) return false;
        $group = $user['id_grup'] ?? null;
        if (!$group) return false;
        $access = $this->db->where('id_grup', $group)
            ->where('modul', $resource)
            ->get('tweb_user_akses')
            ->row_array();
        if (!$access) return false;
        $field = $action === 'read' ? 'b' : 'u';
        return isset($access[$field]) && $access[$field] == 1;
    }
    public function getUser($userId): ?array
    {
        return $this->db->where('id', $userId)->get('user')->row_array();
    }
}
