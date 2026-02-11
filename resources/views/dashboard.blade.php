<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- total -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase">
                        Total Customers
                    </h3>
                    <p class="mt-3 text-3xl font-bold text-indigo-600">
                        {{ $totalCustomers }}
                    </p>
                </div>

                <!-- pending -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase">
                        Pending Follow-ups
                    </h3>
                    <p class="mt-3 text-3xl font-bold text-rose-600">
                        {{ $pendingFollowUps }}
                    </p>
                </div>

                <!-- active -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase">
                        Active Tickets
                    </h3>
                    <p class="mt-3 text-3xl font-bold text-emerald-600">
                        {{ $ticketStatusCounts->sum() }}
                    </p>
                </div>

            </div>

            <!-- chart -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold mb-4">
                    Ticket Status Overview
                </h3>

                <div class="flex justify-center">
                    <div class="w-full md:w-1/2 lg:w-1/3">
                        <canvas id="ticketChart" class="h-64"></canvas>
                    </div>
                </div>
            </div>

            <!-- recent -->
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold mb-4">
                    Recent Interactions
                </h3>

                <div class="divide-y divide-gray-100">
                    @forelse($recentInteractions as $interaction)
                        <div class="py-3 flex justify-between">
                            <div>
                                <p class="font-semibold text-gray-800">
                                    {{ $interaction->customer->name }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ $interaction->type }}
                                </p>
                            </div>
                            <div class="text-sm text-gray-400">
                                {{ $interaction->created_at->diffForHumans() }}
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 italic">
                            No recent interactions.
                        </p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctx = document.getElementById('ticketChart').getContext('2d');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($ticketStatusCounts->keys()) !!},
                datasets: [{
                    data: {!! json_encode($ticketStatusCounts->values()) !!},
                    backgroundColor: [
                        '#ef4444',
                        '#facc15',
                        '#22c55e',
                        '#6b7280'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>

</x-app-layout>
