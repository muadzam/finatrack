<x-layout>
    <form method="GET" action="{{ route('dashboard') }}" class="mb-4">
        <div class="filter-capsule form-row justify-content-end align-items-center"
        style="background-color: white">
            <div class="form-group mb-0 mr-3">
                <!-- Filter Options as Capsules -->
                <div class="d-flex">
                    <div
                        class="filter-capsule mr-2 {{ $filter === 'overall' ? 'active' : '' }}"
                        onclick="toggleFilter('overall')"
                        id="filterOverall"
                    >
                        <i class="fa-solid fa-chart-pie"></i> <!-- Icon for Overall -->
                    </div>
                    <div
                        class="filter-capsule {{ $filter === 'month' ? 'active' : '' }}"
                        onclick="toggleFilter('month')"
                        id="filterMonth"
                    >
                        <i class="fa-solid fa-calendar"></i> <!-- Icon for By Month -->
                    </div>
                </div>
            </div>

            <!-- Month Selector (shown only when 'By Month' is active) -->
            <div class="form-group m-2 ml-3" id="monthInput" style="{{ $filter === 'month' ? '' : 'display: none;' }}">
                <label for="month" class="sr-only">Month</label>
                <input
                    type="month"
                    class="form-control"
                    id="month"
                    name="month"
                    value="{{ request('month') }}"
                >
            </div>

            <!-- Apply Button -->
            <button type="submit" class="btn gradient-btn ml-3">Apply</button>
        </div>
    </form>

    <!-- Income Chart and Tables -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title"><i class="fa-solid fa-hand-holding-dollar"></i>&nbsp;Income</h5>
            <canvas id="incomeChart"></canvas>
        </div>
        <div class="card-body">
            <table class="table table-striped text-center">
                <thead>
                <tr>
                    <th>Source</th>
                    <th>Amount (RM)</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($incomeData as $income)
                    <tr>
                        <td>{{ $income->source_label }}</td>
                        <td>RM {{ $income->total_amount }}</td>
                        <td><button class="btn-info"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="btn-danger"><i class="fa-solid fa-trash-can text-white"></i></button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Expense Chart and Tables -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title"><i class="fa-regular fa-credit-card"></i>&nbsp;Expense</h5>
            <canvas id="expenseChart"></canvas>
        </div>
        <div class="card-body">
            <table class="table table-striped text-center">
                <thead>
                <tr>
                    <th>Source</th>
                    <th>Amount (RM)</th>
                    <th>Date</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($expenseData as $expense)
                    <tr>
                        <td>{{ $expense->source }}</td>
                        <td>RM {{ $expense->amount }}</td>
                        <td>{{ \Carbon\Carbon::parse($expense->date)->format('F Y') }}</td>
                        <td><button class="btn-info"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="btn-danger"><i class="fa-solid fa-trash-can text-white"></i></button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Saving Chart and Tables -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title"><i class="fa-solid fa-vault"></i>&nbsp;Saving</h5>
            <canvas id="savingChart"></canvas>
        </div>
        <div class="card-body">
            <table class="table table-striped text-center">
                <thead>
                <tr>
                    <th>Source</th>
                    <th>Amount (RM)</th>
                    <th>Date</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($savingData as $saving)
                    <tr>
                        <td>{{ $saving->source }}</td>
                        <td>RM {{ $saving->amount }}</td>
                        <td>{{ \Carbon\Carbon::parse($saving->date)->format('F Y') }}</td>
                        <td><button class="btn-info"><i class="fa-solid fa-pen-to-square"></i></button>
                            <button class="btn-danger"><i class="fa-solid fa-trash-can text-white"></i></button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Leftover Calculator Card -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title"><i class="fa-solid fa-calculator"></i>&nbsp;Leftover Calculator</h5>
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6>Total Income:</h6>
                    <p class="font-weight-bold text-success">+RM {{ number_format($totalIncome, 2) }}</p>
                </div>
                <div>
                    <h6>Total Expenses:</h6>
                    <p class="font-weight-bold text-danger">-RM {{ number_format($totalExpenses, 2) }}</p>
                </div>
                <div>
                    <h6>Total Savings:</h6>
                    <p class="font-weight-bold text-danger">-RM {{ number_format($totalSavings, 2) }}</p>
                </div>
            </div>
            <hr>
            <div class="d-flex justify-content-between align-items-center">
                <h6>Leftover:</h6>
                <p class="font-weight-bold text-success">RM {{ number_format($leftover, 2) }}</p>
            </div>
        </div>
    </div>

    <script>
        const incomeSources = @json($incomeData->pluck('source_label'));
        const incomeAmounts = @json($incomeData->pluck('total_amount'));

        const incomeChart = new Chart(document.getElementById('incomeChart'), {
            type: 'doughnut',
            data: {
                labels: incomeSources,
                datasets: [{
                    data: incomeAmounts,
                }]
            }
        });

        const expenseLabels = @json($expenseData->pluck('source'));
        const expenseAmounts = @json($expenseData->pluck('amount'));

        const expenseChart = new Chart(document.getElementById('expenseChart'), {
            type: 'line',
            data: {
                labels: expenseLabels,
                datasets: [{
                    data: expenseAmounts,
                    label: 'Expense',
                    borderColor: '#34ebcf',
                    backgroundColor: 'rgba(36, 237, 150, 0.5)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Source'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Amount'
                        },
                        beginAtZero: true
                    }
                }
            }
        });

        const savingLabels = @json($savingData->pluck('source'));
        const savingAmounts = @json($savingData->pluck('amount'));

        const savingChart = new Chart(document.getElementById('savingChart'), {
            type: 'pie',
            data: {
                labels: savingLabels,
                datasets: [{
                    data: savingAmounts,
                }]
            }
        });

        // Function to toggle filter selection
        function toggleFilter(filter) {
            // Clear active class from both filters
            document.getElementById('filterOverall').classList.remove('active');
            document.getElementById('filterMonth').classList.remove('active');

            // Add active class to the selected filter
            if (filter === 'overall') {
                document.getElementById('filterOverall').classList.add('active');
                document.getElementById('monthInput').style.display = 'none'; // Hide month input
            } else if (filter === 'month') {
                document.getElementById('filterMonth').classList.add('active');
                document.getElementById('monthInput').style.display = ''; // Show month input
            }

            // Update the URL with the new filter value
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('filter', filter);
            window.history.replaceState(null, '', '?' + urlParams.toString());
        }

        const updateChartData = (chart, labels, data) => {
            chart.data.labels = labels;
            chart.data.datasets[0].data = data;
            chart.update();
        };

        // Income
        updateChartData(incomeChart, @json($incomeData->pluck('source_label')), @json($incomeData->pluck('total_amount')));

        // Expenses
        updateChartData(expenseChart, @json($expenseData->pluck('source')), @json($expenseData->pluck('amount')));

        // Savings
        updateChartData(savingChart, @json($savingData->pluck('source')), @json($savingData->pluck('amount')));

        function toggleDateInput(show) {
            const monthInput = document.getElementById('monthInput');
            if (show) {
                monthInput.style.display = 'block';
            } else {
                monthInput.style.display = 'none';
            }
        }
    </script>
    <style>
        .filter-capsule {
            display: inline-flex;
            align-items: center;
            padding: 10px 20px;
            background-color: #f0f0f0;
            border-radius: 50px;
            cursor: pointer;
            transition: background-color 0.7s, color 0.7s;
        }

        .filter-capsule.active {
            background-color: #22c55e;
            color: white;
        }

        .filter-capsule i {
            margin-right: 5px;
        }
    </style>
</x-layout>
