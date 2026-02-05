<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-100 leading-tight">
            {{ __('Reports & Analytics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Charts Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                
                <!-- Main Activity (Line) -->
                <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-lg lg:col-span-2">
                    <h3 class="text-lg font-bold text-white mb-4">Platform Growth (6 Months)</h3>
                    <div class="relative h-80 w-full">
                        <canvas id="growthChart"></canvas>
                    </div>
                </div>

                <!-- Content Distribution (Bar) -->
                <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-lg">
                    <h3 class="text-lg font-bold text-white mb-4">Content Uploads</h3>
                    <div class="relative h-64 w-full">
                        <canvas id="contentChart"></canvas>
                    </div>
                </div>

                <!-- Category Distribution (Doughnut) -->
                <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-lg">
                    <h3 class="text-lg font-bold text-white mb-4">Artworks by Category</h3>
                    <div class="relative h-64 w-full flex justify-center">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const chartData = @json($chartData);

        // Common Options
        Chart.defaults.color = '#9ca3af';
        Chart.defaults.borderColor = '#374151';

        // 1. Growth Chart
        new Chart(document.getElementById('growthChart'), {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [
                    {
                        label: 'New Users',
                        data: chartData.users,
                        borderColor: '#a855f7', // Purple
                        backgroundColor: 'rgba(168, 85, 247, 0.2)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Visitors',
                        data: chartData.visits,
                        borderColor: '#22c55e', // Green
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Artworks',
                        data: chartData.artworks,
                        borderColor: '#06b6d4', // Cyan
                        backgroundColor: 'rgba(6, 182, 212, 0.2)',
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top' }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#374151' } },
                    x: { grid: { display: false } }
                }
            }
        });

        // 2. Content Chart
        new Chart(document.getElementById('contentChart'), {
            type: 'bar',
            data: {
                labels: chartData.labels,
                datasets: [
                    {
                        label: 'Artworks',
                        data: chartData.artworks,
                        backgroundColor: '#06b6d4',
                        borderRadius: 4
                    },
                    {
                        label: 'Research Papers',
                        data: chartData.publications,
                        backgroundColor: '#f472b6', // Pink
                        borderRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true },
                    x: { stacked: false, grid: { display: false } }
                }
            }
        });

        // 3. Category Chart
        new Chart(document.getElementById('categoryChart'), {
            type: 'doughnut',
            data: {
                labels: chartData.categories.labels,
                datasets: [{
                    data: chartData.categories.data,
                    backgroundColor: [
                        '#a855f7', '#06b6d4', '#f472b6', '#3b82f6', '#10b981', '#f59e0b'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'right' }
                }
            }
        });
    </script>
</x-admin-layout>
