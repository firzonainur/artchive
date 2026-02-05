<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Top Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Visits -->
                <div class="bg-gray-800 rounded-xl p-6 border-l-4 border-purple-500 shadow-lg relative overflow-hidden">
                    <div class="relative z-10">
                        <p class="text-gray-400 text-sm font-medium mb-1">Total Visits</p>
                        <h3 class="text-4xl font-bold text-white mb-2">{{ number_format($stats['total_visits']) }}</h3>
                        <p class="text-green-400 text-sm flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                            {{ number_format($stats['total_visits_today']) }} today
                        </p>
                    </div>
                    <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-purple-500/10 to-transparent"></div>
                </div>

                <!-- Unique Visitors -->
                <div class="bg-gray-800 rounded-xl p-6 border-l-4 border-teal-500 shadow-lg relative overflow-hidden">
                    <div class="relative z-10">
                        <p class="text-gray-400 text-sm font-medium mb-1">Unique Visitors (Today)</p>
                        <h3 class="text-4xl font-bold text-white mb-2">{{ number_format($stats['unique_visitors_today']) }}</h3>
                        <p class="text-teal-400 text-sm flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            distinct IPs
                        </p>
                    </div>
                </div>

                 <!-- Projects -->
                <div class="bg-gray-800 rounded-xl p-6 border-l-4 border-blue-500 shadow-lg relative overflow-hidden">
                    <div class="relative z-10">
                         <p class="text-gray-400 text-sm font-medium mb-1">Projects</p>
                        <h3 class="text-4xl font-bold text-white mb-2">{{ number_format($stats['projects']) }}</h3>
                        <a href="{{ route('admin.artworks') }}" class="text-blue-400 text-sm hover:text-blue-300 flex items-center transition-colors">
                            Manage
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>

                <!-- Articles -->
                <div class="bg-gray-800 rounded-xl p-6 border-l-4 border-green-500 shadow-lg relative overflow-hidden">
                    <div class="relative z-10">
                        <p class="text-gray-400 text-sm font-medium mb-1">Articles</p>
                        <h3 class="text-4xl font-bold text-white mb-2">{{ number_format($stats['articles']) }}</h3>
                         <a href="{{ route('admin.learning.index') }}" class="text-green-400 text-sm hover:text-green-300 flex items-center transition-colors">
                            Manage
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Visitor Traffic Chart -->
                <div class="bg-gray-800 rounded-xl border border-gray-700 shadow-lg p-6 lg:col-span-2">
                    <h3 class="text-lg font-bold text-white mb-6">Visitor Traffic (Last 7 Days)</h3>
                    <div class="relative h-80 w-full">
                         <canvas id="trafficChart"></canvas>
                    </div>
                </div>

                <!-- Top Visited Pages -->
                <div class="bg-gray-800 rounded-xl border border-gray-700 shadow-lg p-6">
                    <h3 class="text-lg font-bold text-white mb-6">Top Visited Pages</h3>
                    <div class="overflow-hidden">
                        <table class="w-full text-left">
                            <thead>
                                <tr>
                                    <th class="pb-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Page</th>
                                    <th class="pb-3 text-xs font-medium text-gray-400 uppercase tracking-wider text-right">Visits</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                @forelse($topPages as $page)
                                <tr class="group hover:bg-gray-700/50 transition-colors">
                                    <td class="py-3 text-sm text-gray-300 truncate max-w-[200px]" title="{{ $page->url }}">
                                        {{ $page->path }}
                                    </td>
                                    <td class="py-3 text-sm font-bold text-white text-right">
                                        {{ number_format($page->count) }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="py-4 text-center text-sm text-gray-500">No data available</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                     <!-- Progress bars visual -->
                    <div class="mt-6 space-y-4">
                        @foreach($topPages->take(3) as $page)
                        <div>
                             <div class="flex justify-between text-xs mb-1">
                                <span class="text-gray-400 truncate w-3/4">{{ $page->path }}</span>
                                <span class="text-gray-500">{{ round(($page->count / max($topPages->first()->count, 1)) * 100) }}%</span>
                            </div>
                            <div class="w-full bg-gray-700 rounded-full h-1.5">
                                <div class="bg-purple-500 h-1.5 rounded-full" style="width: {{ ($page->count / max($topPages->first()->count, 1)) * 100 }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('trafficChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(139, 92, 246, 0.5)'); // Purple
        gradient.addColorStop(1, 'rgba(139, 92, 246, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($trafficLabels),
                datasets: [{
                    label: 'Visitors',
                    data: @json($trafficCounts),
                    backgroundColor: gradient,
                    borderColor: '#8b5cf6',
                    borderWidth: 2,
                    pointBackgroundColor: '#8b5cf6',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: '#8b5cf6',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        titleColor: '#f3f4f6',
                        bodyColor: '#d1d5db',
                        borderColor: '#374151',
                        borderWidth: 1,
                        padding: 10,
                        displayColors: false,
                        callbacks: {
                             label: function(context) {
                                return context.parsed.y + ' Visitors';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#374151',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#9ca3af',
                            font: {
                                size: 11
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            color: '#9ca3af',
                            font: {
                                size: 11
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
            }
        });
    </script>
</x-admin-layout>
