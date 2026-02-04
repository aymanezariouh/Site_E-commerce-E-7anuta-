<div class="rounded-lg border-2 border-red-300 bg-red-50 shadow-md">
    <div class="flex items-center justify-between px-4 py-3 border-b-2 border-red-200 bg-red-100">
        <h5 class="font-bold text-red-800">Commandes</h5>
        <div class="text-sm text-red-600 bg-red-200 px-2 py-1 rounded-full">Module vendeur</div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-red-100 text-red-800">
                <tr>
                    <th class="text-left px-4 py-2 font-semibold">ID</th>
                    <th class="text-left px-4 py-2 font-semibold">Client</th>
                    <th class="text-left px-4 py-2 font-semibold">Total</th>
                    <th class="text-left px-4 py-2 font-semibold">Statut</th>
                    <th class="text-left px-4 py-2 font-semibold">Date</th>
                    <th class="text-left px-4 py-2 font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-t border-red-200">
                    <td class="px-4 py-3 text-red-600" colspan="6">Aucune commande.</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="px-4 py-3 flex flex-wrap gap-2">
        <button class="px-3 py-1.5 rounded-lg border-2 border-red-300 bg-red-100 text-red-800 text-sm hover:bg-red-200 transition-colors">Voir détails</button>
        <button class="px-3 py-1.5 rounded-lg border-2 border-orange-300 bg-orange-100 text-orange-800 text-sm hover:bg-orange-200 transition-colors">Mettre à jour statut</button>
        <button class="px-3 py-1.5 rounded-lg border-2 border-amber-300 bg-amber-100 text-amber-800 text-sm hover:bg-amber-200 transition-colors">Contacter client</button>
    </div>
</div>
