<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Remede;
use App\Models\Maladie;

class AdminController extends Controller
{
    /**
     * Lister tous les remèdes en attente
     */
    public function listRemedes()
    {
        $remedes = Remede::with('maladie', 'user', 'etapes')
            ->where('status', 'attente')
            ->orWhere('status', 'rejete')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'remedes' => $remedes,
        ], 200);
    }

    /**
     * Approuver un remède
     */
    public function approve($id)
    {
        $remede = Remede::find($id);

        if (!$remede) {
            return response()->json(['message' => 'Remède introuvable'], 404);
        }

        $remede->status = 'approuve';
        $remede->save();

        return response()->json([
            'message' => 'Remède approuvé avec succès',
            'remede' => $remede
        ], 200);
    }

    /**
     * Rejeter un remède
     */
    public function reject($id)
    {
        $remede = Remede::find($id);

        if (!$remede) {
            return response()->json(['message' => 'Remède introuvable'], 404);
        }

        $remede->status = 'rejete';
        $remede->save();

        return response()->json([
            'message' => 'Remède rejeté avec succès',
            'remede' => $remede
        ], 200);
    }

    /**
     * Supprimer un remède
     */
    public function destroy($id)
    {
        $remede = Remede::find($id);

        if (!$remede) {
            return response()->json(['message' => 'Remède introuvable'], 404);
        }

        $remede->delete();

        return response()->json([
            'message' => 'Remède supprimé avec succès'
        ], 200);
    }

    /**
     * Ajouter une nouvelle maladie
     */
    public function addMaladie(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|unique:maladies,nom',
        ]);

        $maladie = Maladie::create([
            'nom' => $request->nom,
        ]);

        return response()->json([
            'message' => 'Maladie ajoutée avec succès',
            'maladie' => $maladie,
        ], 201);
    }

    /**
     * Lister toutes les maladies (utile pour un dropdown)
     */
    public function listMaladies()
    {
        $maladies = Maladie::orderBy('nom')->get();

        return response()->json([
            'maladies' => $maladies,
        ], 200);
    }
}
