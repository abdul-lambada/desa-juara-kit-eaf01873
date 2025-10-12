<?php

namespace App\Models;

class KategoriBerita extends Model
{
    protected function table(): string
    {
        return 'kategori_berita';
    }

    public function options(int $desaId): array
    {
        $items = $this->db->fetchAll(
            "SELECT id, nama FROM {$this->table()} WHERE desa_id = :desa ORDER BY nama ASC",
            ['desa' => $desaId]
        );

        $options = [];
        foreach ($items as $item) {
            $options[$item['id']] = $item['nama'];
        }

        return $options;
    }

    public function findForDesa(int|string $id, int $desaId): ?array
    {
        return $this->db->fetch(
            "SELECT * FROM {$this->table()} WHERE id = :id AND desa_id = :desa LIMIT 1",
            ['id' => $id, 'desa' => $desaId]
        );
    }
}
