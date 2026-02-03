<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-4">
                    <div>
                        <h3 class="text-lg font-semibold">Admin Tools</h3>
                        <p class="text-sm text-gray-600">User management, global moderation, and system metrics.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="rounded-lg border p-4">
                            <h4 class="font-semibold">Users</h4>
                            <ul class="mt-2 text-sm text-gray-700 list-disc list-inside space-y-1">
                                <li>Assign roles</li>
                                <li>Manage users</li>
                            </ul>
                        </div>
                        <div class="rounded-lg border p-4">
                            <h4 class="font-semibold">Moderation</h4>
                            <ul class="mt-2 text-sm text-gray-700 list-disc list-inside space-y-1">
                                <li>Review reports</li>
                                <li>Audit activity</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
