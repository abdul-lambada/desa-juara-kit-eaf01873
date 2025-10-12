<?php

namespace App\Models;

class Pengguna extends Model
{
    protected function table(): string
    {
        return 'pengguna';
    }

    public function paginate(int $page = 1, int $perPage = 10, array $filters = []): array
    {
        $perPage = max(1, $perPage);
        $page = max(1, $page);
        $offset = ($page - 1) * $perPage;
        $conditions = [];
        $params = [];

        if (!empty($filters['q'])) {
            $conditions[] = '(nama LIKE :search OR email LIKE :search)';
            $params['search'] = '%' . $filters['q'] . '%';
        }

        if (!empty($filters['status'])) {
            $conditions[] = 'status = :status';
            $params['status'] = $filters['status'];
        }

        $where = $conditions ? 'WHERE ' . implode(' AND ', $conditions) : '';

        $sql = "SELECT * FROM {$this->table()} {$where} ORDER BY dibuat_pada DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo()->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        $stmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetchAll();

        $countSql = "SELECT COUNT(*) as aggregate FROM {$this->table()} {$where}";
        $countStmt = $this->pdo()->prepare($countSql);

        foreach ($params as $key => $value) {
            $countStmt->bindValue(':' . $key, $value);
        }

        $countStmt->execute();
        $total = (int) $countStmt->fetchColumn();

        return [
            'data' => $data,
            'total' => $total,
            'perPage' => $perPage,
            'currentPage' => $page,
            'lastPage' => max(1, (int) ceil($total / $perPage)),
        ];
    }

    public function findByEmail(string $email, int|string|null $ignoreId = null): ?array
    {
        $query = "SELECT * FROM {$this->table()} WHERE email = :email";
        $params = ['email' => $email];

        if ($ignoreId !== null) {
            $query .= " AND id != :id";
            $params['id'] = $ignoreId;
        }

        return $this->db->fetch($query, $params);
    }
}
