<?php

namespace App\Models;

class Pengumuman extends Model
{
    protected function table(): string
    {
        return 'pengumuman';
    }

    public function paginate(int $desaId, int $page = 1, int $perPage = 10, array $filters = []): array
    {
        $perPage = max(1, $perPage);
        $page = max(1, $page);
        $offset = ($page - 1) * $perPage;

        $conditions = [];
        $params = [];

        $conditions[] = 'desa_id = :desa';
        $params['desa'] = $desaId;

        if (!empty($filters['q'])) {
            $conditions[] = '(judul LIKE :search OR isi LIKE :search)';
            $params['search'] = '%' . $filters['q'] . '%';
        }

        if (!empty($filters['status'])) {
            $conditions[] = 'status = :status';
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['prioritas'])) {
            $conditions[] = 'prioritas = :prioritas';
            $params['prioritas'] = $filters['prioritas'];
        }

        $where = $conditions ? 'WHERE ' . implode(' AND ', $conditions) : '';

        $sql = "SELECT * FROM {$this->table()} {$where} ORDER BY (dipublikasikan_pada IS NULL), dipublikasikan_pada DESC, dibuat_pada DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo()->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        $stmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetchAll();

        $countSql = "SELECT COUNT(*) AS aggregate FROM {$this->table()} {$where}";
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

    public function create(array $data): int
    {
        $data['slug'] = $this->uniqueSlug($data['judul']);
        return $this->insert($data);
    }

    public function updateWithSlug(int|string $id, array $data): int
    {
        if (isset($data['judul'])) {
            $data['slug'] = $this->uniqueSlug($data['judul'], 'slug', $id);
        }

        return $this->update($id, $data);
    }

    public function findForDesa(int|string $id, int $desaId): ?array
    {
        return $this->db->fetch(
            "SELECT * FROM {$this->table()} WHERE id = :id AND desa_id = :desa LIMIT 1",
            ['id' => $id, 'desa' => $desaId]
        );
    }
}
