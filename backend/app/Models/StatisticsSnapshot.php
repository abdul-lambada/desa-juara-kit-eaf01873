<?php

namespace App\Models;

class StatisticsSnapshot extends Model
{
    protected function table(): string
    {
        return 'snapshot_statistik';
    }

    public function paginate(int $desaId, int $page = 1, int $perPage = 10, array $filters = []): array
    {
        $perPage = max(1, $perPage);
        $page = max(1, $page);
        $offset = ($page - 1) * $perPage;

        $conditions = ['desa_id = :desa'];
        $params = ['desa' => $desaId];

        if (!empty($filters['periode'])) {
            $conditions[] = 'periode ILIKE :periode';
            $params['periode'] = '%' . $filters['periode'] . '%';
        }

        if (!empty($filters['tahun'])) {
            $conditions[] = 'tahun = :tahun';
            $params['tahun'] = (int) $filters['tahun'];
        }

        $where = 'WHERE ' . implode(' AND ', $conditions);

        $sql = "SELECT * FROM {$this->table()} {$where} ORDER BY (tahun IS NULL), tahun DESC, periode DESC LIMIT :limit OFFSET :offset";
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

    public function create(array $data): int
    {
        return $this->insert($data);
    }

    public function updateSnapshot(int|string $id, array $data): int
    {
        return $this->update($id, $data);
    }

    public function periodeExists(int $desaId, string $periode, int|string|null $ignoreId = null): bool
    {
        $sql = "SELECT COUNT(*) AS aggregate FROM {$this->table()} WHERE desa_id = :desa AND periode = :periode";
        $params = ['desa' => $desaId, 'periode' => $periode];

        if ($ignoreId !== null) {
            $sql .= " AND id != :id";
            $params['id'] = $ignoreId;
        }

        $result = $this->db->fetch($sql, $params);

        return (int) ($result['aggregate'] ?? 0) > 0;
    }
}
