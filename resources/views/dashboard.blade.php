<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-6">
                    <div>
                        <h3 class="text-lg font-semibold">Welcome</h3>
                        <p class="text-sm text-gray-600">
                            Your dashboard adapts to your role. Buyer is the base, Seller adds product tools,
                            and Moderator adds moderation tools.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="rounded-lg border p-4">
                            <h4 class="font-semibold">Buyer</h4>
                            <ul class="mt-2 text-sm text-gray-700 list-disc list-inside space-y-1">
                                <li>Browse products</li>
                                <li>Track orders</li>
                                <li>Update profile</li>
                            </ul>
                        </div>

                        @role('seller')
                            <div class="rounded-lg border p-4">
                                <h4 class="font-semibold">Seller</h4>
                                <ul class="mt-2 text-sm text-gray-700 list-disc list-inside space-y-1">
                                    <li>Manage products</li>
                                    <li>Update stock</li>
                                    <li>View seller orders</li>
                                </ul>
                            </div>
                        @endrole

                        @role('moderator')
                            <div class="rounded-lg border p-4">
                                <h4 class="font-semibold">Moderator</h4>
                                <ul class="mt-2 text-sm text-gray-700 list-disc list-inside space-y-1">
                                    <li>Moderate reviews</li>
                                    <li>Handle reports</li>
                                    <li>Suspend content</li>
                                </ul>
                            </div>
                        @endrole
                    </div>

                    <div class="text-sm text-gray-600">
                        Want to show/hide blocks by permission instead of role?
                        Use <code>@can('permission-name')</code> in this view.
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
