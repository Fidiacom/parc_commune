<?php

namespace App\Repositories;

use App\Models\ReformeStatusHistorique;

class ReformeStatusHistoriqueRepository
{
    /**
     * Create a new reforme status historique.
     */
    public function create(array $data): ReformeStatusHistorique
    {
        return ReformeStatusHistorique::create($data);
    }

    /**
     * Get all status historiques for a reforme.
     */
    public function getByReformeId(int $reformeId)
    {
        return ReformeStatusHistorique::where(ReformeStatusHistorique::REFORME_ID_COLUMN, $reformeId)
            ->with('attachments')
            ->latest()
            ->get();
    }

    /**
     * Find status historique by ID.
     */
    public function findById(int $id): ?ReformeStatusHistorique
    {
        return ReformeStatusHistorique::find($id);
    }
}




