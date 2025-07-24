<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <!-- Statistics Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6 rounded-lg text-white">
                            <h3 class="text-lg font-semibold">Total Projects</h3>
                            <p class="text-3xl font-bold">{{ $stats['total_projects'] ?? 0 }}</p>
                        </div>
                        <div class="bg-gradient-to-r from-green-500 to-green-600 p-6 rounded-lg text-white">
                            <h3 class="text-lg font-semibold">Active Tasks</h3>
                            <p class="text-3xl font-bold">{{ $stats['active_tasks'] ?? 0 }}</p>
                        </div>
                        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 p-6 rounded-lg text-white">
                            <h3 class="text-lg font-semibold">Pending Tasks</h3>
                            <p class="text-3xl font-bold">{{ $stats['pending_tasks'] ?? 0 }}</p>
                        </div>
                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6 rounded-lg text-white">
                            <h3 class="text-lg font-semibold">Completed Tasks</h3>
                            <p class="text-3xl font-bold">{{ $stats['completed_tasks'] ?? 0 }}</p>
                        </div>
                    </div>

                    <!-- Charts -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Tasks by Status Chart -->
                        <div class="bg-gray-700 p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold mb-4 text-gray-100">Tasks by Status</h3>
                            <div style="height: 300px;">
                                <canvas id="tasksStatusChart"></canvas>
                            </div>
                        </div>

                        <!-- Tasks Timeline Chart -->
                        <div class="bg-gray-700 p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold mb-4 text-gray-100">Tasks Created Over Time</h3>
                            <div style="height: 300px;">
                                <canvas id="tasksTimelineChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Chart.js Scripts -->
                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            // Tasks by Status - Doughnut Chart
                            const tasksStatusCtx = document.getElementById('tasksStatusChart').getContext('2d');
                            const tasksStatusChart = new Chart(tasksStatusCtx, {
                                type: 'doughnut',
                                data: {
                                    labels: ['To Do', 'In Progress', 'Done'],
                                    datasets: [{
                                        data: [
                                            {{ $chartData['tasks_by_status']['todo'] ?? 0 }},
                                            {{ $chartData['tasks_by_status']['in_progress'] ?? 0 }},
                                            {{ $chartData['tasks_by_status']['done'] ?? 0 }}
                                        ],
                                        backgroundColor: [
                                            '#EF4444', // Red for To Do
                                            '#F59E0B', // Yellow for In Progress
                                            '#10B981'  // Green for Done
                                        ],
                                        borderWidth: 2,
                                        borderColor: '#374151'
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            position: 'bottom',
                                            display: true,
                                            labels: {
                                                color: '#ffffff',
                                                font: {
                                                    size: 14
                                                },
                                                padding: 20,
                                                usePointStyle: true
                                            }
                                        },
                                        tooltip: {
                                            enabled: true,
                                            callbacks: {
                                                label: function(context) {
                                                    const label = context.label || '';
                                                    const value = context.parsed;
                                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                                    return `${label}: ${value} (${percentage}%)`;
                                                }
                                            }
                                        }
                                    }
                                }
                            });

                            // Tasks Timeline - Line Chart
                            const tasksTimelineCtx = document.getElementById('tasksTimelineChart').getContext('2d');
                            const tasksTimelineChart = new Chart(tasksTimelineCtx, {
                                type: 'line',
                                data: {
                                    labels: {!! json_encode($chartData['timeline_labels'] ?? []) !!},
                                    datasets: [{
                                        label: 'Tasks Created',
                                        data: {!! json_encode($chartData['timeline_data'] ?? []) !!},
                                        borderColor: 'rgba(16, 185, 129, 1)',
                                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                        borderWidth: 3,
                                        fill: true,
                                        tension: 0.4,
                                        pointBackgroundColor: 'rgba(16, 185, 129, 1)',
                                        pointBorderColor: '#ffffff',
                                        pointBorderWidth: 2,
                                        pointRadius: 5,
                                        pointHoverRadius: 7
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    interaction: {
                                        intersect: false,
                                        mode: 'index'
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            display: true,
                                            title: {
                                                display: true,
                                                text: 'Number of Tasks',
                                                color: '#ffffff',
                                                font: {
                                                    size: 12,
                                                    weight: 'bold'
                                                }
                                            },
                                            ticks: {
                                                color: '#ffffff',
                                                stepSize: 1
                                            },
                                            grid: {
                                                color:  '#ffffff'
                                            }
                                        },
                                        x: {
                                            display: true,
                                            title: {
                                                display: true,
                                                text: 'Date',
                                                color: '#ffffff',
                                                font: {
                                                    size: 12,
                                                    weight: 'bold'
                                                }
                                            },
                                            ticks: {
                                                color:  '#ffffff'
                                            },
                                            grid: {
                                                color:  '#ffffff'
                                            }
                                        }
                                    },
                                    plugins: {
                                        legend: {
                                            display: true,
                                            position: 'top',
                                            labels: {
                                                color: '#ffffff',
                                                font: {
                                                    size: 14
                                                },
                                                usePointStyle: true
                                            }
                                        },
                                        tooltip: {
                                            enabled: true,
                                            callbacks: {
                                                title: function(context) {
                                                    return 'Date: ' + context[0].label;
                                                },
                                                label: function(context) {
                                                    return context.dataset.label + ': ' + context.parsed.y + ' tasks';
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>