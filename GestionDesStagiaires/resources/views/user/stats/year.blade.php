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

            #yearlyFlowChart {
                margin-top: 40%;
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
                            <h1 class="h1">Stagiaire par année</h1>
                        </div>
                        <div id="yearlyFlowChart" class="mt-3 mb-3"></div>
                        
                        <!-- Placeholder for the dynamic table -->
                        <div id="yearlyDataTable" class="mt-4"></div>
                        
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
            var yearlyFlowChart = echarts.init(document.getElementById('yearlyFlowChart'));     
            
            // Yearly Flow Chart Data
            var yearlyData = @json($yearlyData);
            var yearlyOptions = {
                title: { text: '', subtext: '', left: 'center' },
                tooltip: { trigger: 'axis' },
                xAxis: { type: 'category', data: yearlyData.map(item => item.year) },
                yAxis: { type: 'value' },
                series: [{ name: 'Interns', type: 'line', data: yearlyData.map(item => item.total) }]
            };
            yearlyFlowChart.setOption(yearlyOptions);

            // Create and populate the table dynamically
            var tableContainer = document.getElementById('yearlyDataTable');
            var table = document.createElement('table');
            table.className = 'table table-striped';
            
            var thead = document.createElement('thead');
            var headerRow = document.createElement('tr');
            var yearHeader = document.createElement('th');
            yearHeader.textContent = 'Year';
            var totalHeader = document.createElement('th');
            totalHeader.textContent = 'Total Interns';
            headerRow.appendChild(yearHeader);
            headerRow.appendChild(totalHeader);
            thead.appendChild(headerRow);
            table.appendChild(thead);
            
            var tbody = document.createElement('tbody');
            var totalInterns = 0; // Initialize total interns

            yearlyData.forEach(function(item) {
                var row = document.createElement('tr');
                var yearCell = document.createElement('td');
                yearCell.textContent = item.year;
                var totalCell = document.createElement('td');
                totalCell.textContent = item.total;
                row.appendChild(yearCell);
                row.appendChild(totalCell);
                tbody.appendChild(row);

                totalInterns += item.total; // Sum up the total interns
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
            tbody.appendChild(totalRow);

            table.appendChild(tbody);
            tableContainer.appendChild(table);
        });
    </script>
   
</body>
</html>
