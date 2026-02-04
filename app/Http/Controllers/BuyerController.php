<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Commande;
use Illuminate\Support\Facades\Auth;

class BuyerController extends Controller
{
    // Afficher tous les produits
    public function index()
    {
        $produits = Produit::all();
        return view('buyer.index', compact('produits'));
    }

    // Ajouter produit au panier (ici simple Commande temporaire)
    public function addToCart(Request $request, $id)
    {
        $produit = Produit::findOrFail($id);

        // Exemple simple: créer commande avec status 'En attente'
        Commande::create([
            'user_id' => Auth::id(),
            'produit_id' => $produit->id,
            'quantite' => $request->quantite ?? 1,
            'status' => 'En attente'
        ]);

        return redirect()->back()->with('success', 'Produit ajouté au panier.');
    }

    // Voir les commandes de l'utilisateur
    public function orders()
    {
        $commandes = Commande::where('user_id', Auth::id())->with('produit')->get();
        return view('buyer.orders', compact('commandes'));
    }

    // Détails produit
    public function show($id)
    {
        $produit = Produit::findOrFail($id);
        return view('buyer.show', compact('produit'));
    }
}
