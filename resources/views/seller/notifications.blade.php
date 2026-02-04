<x-app-layout>
    <div class="py-10 dashboard-bg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <section class="dash-card px-6 py-6 sm:px-8">
                <h2 class="dash-title text-2xl text-slate-800">Notifications</h2>
                <p class="text-sm text-slate-600 mt-1">Toutes vos alertes vendeurs.</p>
            </section>

            <x-seller.notifications />
        </div>
    </div>
</x-app-layout>
