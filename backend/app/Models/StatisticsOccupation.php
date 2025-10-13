<?php

namespace App\Models;

class StatisticsOccupation extends Model
{
    protected function table(): string
    {
        return 'statistik_pekerjaan';
    }

    public function listForSnapshot(int $snapshotId): array
    {
        return $this->db->fetchAll(
            "SELECT * FROM {$this->table()} WHERE snapshot_id = :snapshot ORDER BY urutan ASC",
            ['snapshot' => $snapshotId]
        );
    }

    public function findForSnapshot(int|string $id, int $snapshotId): ?array
    {
        return $this->db->fetch(
            "SELECT * FROM {$this->table()} WHERE id = :id AND snapshot_id = :snapshot LIMIT 1",
            ['id' => $id, 'snapshot' => $snapshotId]
        );
    }
}
