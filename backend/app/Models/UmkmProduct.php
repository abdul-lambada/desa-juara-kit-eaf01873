<?php

namespace App\Models;

class UmkmProduct extends Model
{
    protected function table(): string
    {
        return 'umkm_products';
    }

    public function paginate(int $desaId, int $page = 1, int $perPage = 10, array $filters = []): array
    {
        $perPage = max(1, $perPage);
        $page = max(1, $page);
        $offset = ($page - 1) * $perPage;

        $conditions = ['desa_id = :desa'];
        $params = ['desa' => $desaId];

        if (!empty($filters['q'])) {
            $conditions[] = '(name LIKE :search OR description LIKE :search OR seller_name LIKE :search)';
            $params['search'] = '%' . $filters['q'] . '%';
        }

        if (!empty($filters['kategori_id'])) {
            $conditions[] = 'category_id = :kategori';
            $params['kategori'] = $filters['kategori_id'];
        }

        if (isset($filters['aktif']) && $filters['aktif'] !== '') {
            $conditions[] = 'is_active = :aktif';
            $params['aktif'] = (int) (bool) $filters['aktif'];
        }

        if (isset($filters['unggulan']) && $filters['unggulan'] !== '') {
            $conditions[] = 'featured = :unggulan';
            $params['unggulan'] = (int) (bool) $filters['unggulan'];
        }

        $where = 'WHERE ' . implode(' AND ', $conditions);

        $sql = "SELECT * FROM {$this->table()} {$where} ORDER BY featured DESC, created_at DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo()->prepare($sql);

        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }

        $stmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetchAll();

        $countStmt = $this->pdo()->prepare("SELECT COUNT(*) AS aggregate FROM {$this->table()} {$where}");
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
        $data['slug'] = $this->uniqueSlug($data['name']);
        return $this->insert($data);
    }

    public function updateWithSlug(int|string $id, array $data): int
    {
        if (isset($data['name'])) {
            $data['slug'] = $this->uniqueSlug($data['name'], 'slug', $id);
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
