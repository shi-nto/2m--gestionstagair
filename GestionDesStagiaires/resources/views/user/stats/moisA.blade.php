<!DOCTYPE html>
<html lang="en">
<head>
    @include('assets.headerAdmin')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2M</title>
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <style>
        #natureStageChart, #genderChart, #yearlyFlowChart, #monthlyFlowChart, #departmentChart, #encadrantChart {
            width: 100%;
            height: 400px;
            background-color: #fff;
            padding: 10px;
        }
        .chart-container {
            margin-bottom: 30px;
        }
        .chart-title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 10px;
        }
        @media (max-width: 767.98px) {
            #natureStageChart, #genderChart, #yearlyFlowChart, #monthlyFlowChart, #departmentChart, #encadrantChart {
                height: 300px;      
            }
        }
        @media print {
            .no-print {
                display: none;
            }

            #monthlyFlowChart {
                right: 20%;
                height: 25vh; /* Adjust the chart size to fit the page */
            }
        }

        .fixed-buttons {
            position: fixed;
            top: 0;
            right: 1%;
            margin-top: 100px;
            z-index: 1000; /* Ensure it stays on top of other elements */
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    @include('assets.navbarAdmin')
    @include('assets.sidebarAdmin')

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 font-playwrite text-shadow">Statistiques</h1>
                    </div>
                </div>
            </div>
        </div>
        
        @include('assets.success')
        <section class="content py-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 chart-container">
                        <div class="flex justify-center items-center mt-16">
                            <h1 class="h4">Soread 2M</h1> 
                        </div>
                        <div class="flex justify-center items-center mb-3">
                            <img src="{{ asset('storage/images/2M_logo.png') }}" alt="2M Logo" class="w-30 h-16">
                        </div>
                        <div class="flex justify-center items-center mt-16 mb-3">
                            <h1 class="h1">Stagiaire par mois pour</h1>
                            <p id="input" class="h1 ml-1"></p> 
                        </div>
                        <div id="monthlyFlowChart"></div>
                        <select id="yearSelect" class="form-control mb-3 no-print">
                            @foreach($availableYears as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                        
                        <!-- Placeholder for the dynamic table -->
                        <div id="monthlyDataTable" class="mt-4"></div>
                        
                        <div class="fixed-buttons no-print">
                            <button class="btn btn-primary" onClick="window.print()">Print</button>
                            <a href="/statistics"><button class="btn btn-secondary">Return</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="{{asset('js/echarts.min.js')}}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var monthlyFlowChart = echarts.init(document.getElementById('monthlyFlowChart'));

            // Monthly Flow Chart Data
            var monthlyOptions = {
                title: { text: '', subtext: '', left: 'center' },
                tooltip: { trigger: 'axis' },
                xAxis: { type: 'category', data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] },
                yAxis: { type: 'value' },
                series: [{ name: 'Interns', type: 'line', data: Array(12).fill(0) }]
            };
            monthlyFlowChart.setOption(monthlyOptions);

            // Update monthly flow chart and table on year selection
            document.getElementById('yearSelect').addEventListener('change', function() {
                var selectedYear = this.value;
                fetch(`/admin/monthlyData/${selectedYear}`)
                    .then(response => response.json())
                    .then(data => {
                        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                        var monthlyData = months.map(month => data[month] || 0);
                        monthlyFlowChart.setOption({
                            xAxis: { data: months },
                            series: [{ name: 'Interns', type: 'line', data: monthlyData }]
                        });

                        // Create and populate the table dynamically
                        var tableContainer = document.getElementById('monthlyDataTable');
                        var table = document.createElement('table');
                        table.className = 'table table-striped';
                        
                        var thead = document.createElement('thead');
                        var headerRow = document.createElement('tr');
                        var monthHeader = document.createElement('th');
                        monthHeader.textContent = 'Month';
                        var totalHeader = document.createElement('th');
                        totalHeader.textContent = 'Total Interns';
                        headerRow.appendChild(monthHeader);
                        headerRow.appendChild(totalHeader);
                        thead.appendChild(headerRow);
                        table.appendChild(thead);
                        
                        var tbody = document.createElement('tbody');
                        var totalInterns = 0; // Initialize total interns

                        months.forEach(function(month) {
                            var row = document.createElement('tr');
                            var monthCell = document.createElement('td');
                            monthCell.textContent = month;
                            var totalCell = document.createElement('td');
                            totalCell.textContent = data[month] || 0;
                            row.appendChild(monthCell);
                            row.appendChild(totalCell);
                            tbody.appendChild(row);

                            totalInterns += data[month] || 0; // Sum up the total interns
                        });

                        // Add Total Row
                        var totalRow = document.createElement('tr');
                        var totalLabelCell = document.createElement('td');
                        totalLabelCell.textContent = 'Total';
                        totalLabelCell.style.fontWeight = 'bold'; // Highlight the total row
                        var totalValueCell = document.createElement('td');
                        totalValueCell.textContent = totalInterns;
                        totalValueCell.style.fontWeight = 'bold'; // Highlight the total row
                        totalRow.appendChild(totalLabelCell);
                        totalRow.appendChild(totalValueCell);
                       

                        table.appendChild(tbody);
                        tableContainer.innerHTML = ''; // Clear existing table if any
                        tableContainer.appendChild(table);

                        // Update year label
                        var annee = document.getElementById('yearSelect');
                        var inp = document.getElementById('input');
                        inp.innerHTML = annee.value;
                    })
                    .catch(error => console.error('Fetch error:', error));
            });

            // Trigger change event on page load to display the current year's data
            document.getElementById('yearSelect').dispatchEvent(new Event('change'));
        });
    </script>
   
</body>
</html>
