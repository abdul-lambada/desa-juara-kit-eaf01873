<?php

namespace App\Models;

class GalleryPhoto extends Model
{
    protected function table(): string
    {
        return 'gallery_photos';
    }

    public function paginate(int $albumId, int $page = 1, int $perPage = 12, array $filters = []): array
    {
        $perPage = max(1, $perPage);
        $page = max(1, $page);
        $offset = ($page - 1) * $perPage;

        $conditions = ['album_id = :album'];
        $params = ['album' => $albumId];

        if (!empty($filters['q'])) {
            $conditions[] = '(title LIKE :search OR description LIKE :search)';
            $params['search'] = '%' . $filters['q'] . '%';
        }

        $where = 'WHERE ' . implode(' AND ', $conditions);

        $sql = "SELECT * FROM {$this->table()} {$where} ORDER BY display_order ASC, created_at DESC LIMIT :limit OFFSET :offset";
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

    public function findForAlbum(int|string $id, int $albumId): ?array
    {
        return $this->db->fetch(
            "SELECT * FROM {$this->table()} WHERE id = :id AND album_id = :album LIMIT 1",
            ['id' => $id, 'album' => $albumId]
        );
    }

    public function create(array $data): int
    {
        return $this->insert($data);
    }

    public function updatePhoto(int|string $id, array $data): int
    {
        return $this->update($id, $data);
    }
}
