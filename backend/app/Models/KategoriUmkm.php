<?php

namespace App\Models;

class KategoriUmkm extends Model
{
    protected function table(): string
    {
        return 'kategori_umkm';
    }

    public function paginate(int $desaId, int $page = 1, int $perPage = 10, array $filters = []): array
    {
        $perPage = max(1, $perPage);
        $page = max(1, $page);
        $offset = ($page - 1) * $perPage;

        $conditions = ['desa_id = :desa'];
        $params = ['desa' => $desaId];

        if (!empty($filters['q'])) {
            $conditions[] = 'nama LIKE :search';
            $params['search'] = '%' . $filters['q'] . '%';
        }

        $where = 'WHERE ' . implode(' AND ', $conditions);

        $sql = "SELECT * FROM {$this->table()} {$where} ORDER BY nama ASC LIMIT :limit OFFSET :offset";
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

    public function findForDesa(int|string $id, int $desaId): ?array
    {
        return $this->db->fetch(
            "SELECT * FROM {$this->table()} WHERE id = :id AND desa_id = :desa LIMIT 1",
            ['id' => $id, 'desa' => $desaId]
        );
    }

    public function options(int $desaId): array
    {
        $rows = $this->db->fetchAll(
            "SELECT id, nama FROM {$this->table()} WHERE desa_id = :desa ORDER BY nama ASC",
            ['desa' => $desaId]
        );

        $options = [];
        foreach ($rows as $row) {
            $options[$row['id']] = $row['nama'];
        }

        return $options;
    }

    public function create(array $data): int
    {
        $data['slug'] = $this->uniqueSlug($data['nama']);

        return $this->insert($data);
    }

    public function updateWithSlug(int|string $id, array $data): int
    {
        if (isset($data['nama'])) {
            $data['slug'] = $this->uniqueSlug($data['nama'], 'slug', $id);
        }

        return $this->update($id, $data);
    }
}
