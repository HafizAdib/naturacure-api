<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreRemedeRequest;
use App\Http\Requests\UpdateRemedeRequest;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Remede;
use App\Models\Like;
use App\Models\Commentaire;
use App\Models\Maladie;
use App\Models\Etape;

class RemedeController extends Controller
{
    /**
     * Liste des remèdes validés pour l'accueil
     */
    public function index()
    {
        // On récupère les remèdes avec maladie, auteur et étapes
        $remedes = Remede::where('status', 'attente') // ou 'valide'
            ->with(['maladie', 'user', 'etapes'])
            ->get();

        return response()->json(['remedes' => $remedes]);
    }

    public function search(Request $request)
{
    $query = $request->query('q');

    $remedes = Remede::with(['maladie','etapes'])
        ->where('nom', 'like', "%$query%")
        ->orWhereHas('maladie', function ($q) use ($query) {
            $q->where('nom', 'like', "%$query%");
        })
        ->where('status', 'valide')
        ->get();

    return response()->json([
        'remedes' => $remedes
    ]);
}

    /**
     * Création d'un remède ET de ses étapes en une seule fois
     */
    public function store(Request $request)
{
    // 1️⃣ Vérifier si maladie_id existe
    if ($request->has('maladie_id')) {

        $maladie_id = $request->maladie_id;

    } else {

        // 2️⃣ Créer la maladie
        $maladie = Maladie::create([
            'nom' => $request->maladie
        ]);

        $maladie_id = $maladie->id;
    }

    // 3️⃣ Créer le remède
    $remede = Remede::create([
        'nom' => $request->nom,
        'description' => $request->description,
        'user_id' => auth()->id(),
        'maladie_id' => $maladie_id,
        'status' => 'attente'
    ]);

    // 4️⃣ Ajouter les étapes
    if ($request->has('etapes')) {
        foreach ($request->etapes as $etape) {

            $remede->etapes()->create([
                'ordre' => $etape['num_etape'],
                'description' => $etape['instructions']
            ]);

        }
    }

    return response()->json([
        'message' => 'Remède créé avec succès',
        'remede' => $remede->load('maladie','etapes')
    ], 201);
}


    /**
     * Détails complets d'un remède (avec étapes, médias et commentaires)
     */
    public function show($id)
{
    $remede = Remede::with(['etapes', 'media', 'commentaires.user', 'maladie', 'user'])
        ->findOrFail($id);

    // Compter les likes
    $remede->likes = $remede->likes()->count();

    // Vérifier si l'utilisateur actuel a liké
    $remede->liked = auth()->check() ? $remede->likes()->where('user_id', auth()->id())->exists() : false;

    return response()->json(['remede' => $remede]);
}

    /**
     * Mise à jour d'un remède
     */
    public function update(UpdateRemedeRequest $request, $id)
    {
        $data = $request->validated();
        $remede = Remede::findOrFail($id);

        if ($remede->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        $remede->update([
            "nom" => $data['nom'],
            "description" => $data['description'] ?? $remede->description,
            "maladie_id" => $data['maladie_id']
        ]);

        return response()->json(['message' => 'Remède mis à jour', 'remede' => $remede]);
    }

    /**
     * Suppression d'un remède
     */
    public function destroy($id)
    {
        $remede = Remede::findOrFail($id);

        if ($remede->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return response()->json(['error' => 'Non autorisé'], 403);
        }

        $remede->delete();
        return response()->json(['message' => "Remède supprimé"]);
    }

    /**
     * Gestion des Likes (Toggle)
     */
    public function like($id)
    {
        $user_id = auth()->id();
        $existingLike = Like::where('user_id', $user_id)->where('remede_id', $id)->first();

        if ($existingLike) {
            $existingLike->delete();
            return response()->json(['message' => 'Like retiré', 'liked' => false]);
        }

        Like::create([
            'user_id' => $user_id,
            'remede_id' => $id
        ]);

        return response()->json(['message' => 'Remède liké', 'liked' => true]);
    }

    /**
     * Ajouter un commentaire
     */
    public function comment(StoreCommentRequest $request, $id)
    {
        $data = $request->validated();

        $commentaire = Commentaire::create([
            'user_id'   => auth()->id(),
            'remede_id' => $id,
            'contenu'   => $data['contenu']
        ]);

        return response()->json([
            'message' => "Commentaire ajouté",
            'commentaire' => $commentaire->load('user')
        ], 201);
    }

    /**
     * Modifier un commentaire
     */
    public function edit_comment(UpdateCommentRequest $request, $id)
    {
        $commentaire = Commentaire::findOrFail($id);

        if ($commentaire->user_id !== auth()->id()) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $commentaire->update([
            'contenu' => $request->contenu
        ]);

        return response()->json(['message' => "Commentaire mis à jour", 'commentaire' => $commentaire]);
    }

    /**
     * Supprimer un commentaire
     */
    public function delete_comment($id)
    {
        $commentaire = Commentaire::findOrFail($id);

        if ($commentaire->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        $commentaire->delete();
        return response()->json(['message' => "Commentaire supprimé"]);
    }
}
