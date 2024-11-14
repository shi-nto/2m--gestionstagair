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

        #genderChart {
        position: relative;
        right:20%; /* Move the chart 400% of its container's width to the right */
        height: 90vh; /* Adjust the chart size to fit the page */
    }
    }
    .fixed-buttons {
        position: fixed;
        top: 0;
        right:1%;
    /* Adjust the margin as needed */
        margin-top : 100px;
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
                                <h1 class="h1">Stagiaire par sexe pour </h1>
                                <p id="input" class = "h1 ml-1"></p> 
                            </div>
                            <div id="genderChart" class="mt-16" style="width: 100%; height: 400px;"></div>
                            <select id="genderYearSelect" class="form-control  mt-3 mb-3 no-print">
                                @foreach($availableYears as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                                    </select>
                                    
                    
                                    <!-- Dynamic Table for Gender -->
                            <table class="table table-striped mt-4">
                                <thead>
                                    <tr>
                                        <th>Sexe</th>
                                        <th>Nombre</th>
                                        <th>Pourcentage</th>
                                    </tr>
                                </thead>
                                <tbody id="genderTableBody">
                                    <!-- Dynamic rows will be inserted here -->
                                </tbody>
                            </table>

                        <!-- Add the print button -->
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
                var genderChart = echarts.init(document.getElementById('genderChart'));
            
                function updateGenderChart() {
                    var selectedYear = document.getElementById('genderYearSelect').value;
                    fetch(`/admin/internsByGender/${selectedYear}`)
                        .then(response => response.json())
                        .then(data => {
                            var genders = Object.keys(data);
                            var counts = Object.values(data);
            
                            // Calculate the total number of interns
                            var total = counts.reduce((sum, count) => sum + count, 0);
            
                            // Calculate percentages
                            var percentages = counts.map(count => (count / total * 100).toFixed(2));
            
                            // Define the colors for each gender
                            var genderColors = {
                                'Male': 'blue',
                                'Female': 'pink'
                            };
            
                            // Update the chart
                            genderChart.setOption({
                                title: { text: '', subtext: '', left: 'center' },
                                tooltip: { trigger: 'axis' },
                                xAxis: { type: 'category', data: genders },
                                yAxis: { type: 'value' },
                                series: [{
                                    name: 'Interns',
                                    type: 'bar',
                                    data: counts,
                                    itemStyle: {
                                        color: function(params) {
                                            // Get the gender based on the data index
                                            var gender = genders[params.dataIndex];
                                            return genderColors[gender] || 'gray'; // Default to gray if the gender is not found
                                        }
                                    },
                                    label: {
                                        show: true,
                                        position: 'top',
                                        formatter: function(params) {
                                            return `${percentages[params.dataIndex]}%`;
                                        }
                                    }
                                }]
                            });
            
                            // Update the table
                            var tableBody = document.getElementById('genderTableBody');
                            tableBody.innerHTML = ''; // Clear existing rows
            
                            genders.forEach((gender, index) => {
                                var row = `<tr>
                                    <td>${gender}</td>
                                    <td>${counts[index]}</td>
                                    <td>${percentages[index]}%</td>
                                </tr>`;
                                tableBody.innerHTML += row;
                            });
            
                            // Add a total row to the table
                            var totalRow = `<tr>
                                <td><strong>Total</strong></td>
                                <td colspan="2" class="text-center"><strong>${total}</strong></td>

                            </tr>`;
                            tableBody.innerHTML += totalRow;
                        })
                        .catch(error => console.error('Fetch error:', error));
            
                    var annee = document.getElementById('genderYearSelect');
                    var inp = document.getElementById('input');
                    inp.innerHTML = annee.value;
                }
            
                document.getElementById('genderYearSelect').addEventListener('change', updateGenderChart);
                document.getElementById('genderYearSelect').dispatchEvent(new Event('change'));
            });
            </script>
            

    </body>
    </html>
