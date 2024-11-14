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

            #departmentChart {
            position: relative;
        
            right:20%; /* Move the chart 400% of its container's width to the right */
            height: 25vh; /* Adjust the chart size to fit the page */
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
                            <h1 class="h1">Stagiaire par département pour </h1>
                            <p id="input" class = "h1 ml-1"></p> 
                        </div>
                        <div id="departmentChart" class="p-6"></div>
                        <select id="departmentYearSelect" class="form-control mt-6 mb-3 no-print">
                            @foreach($availableYears as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                        <p id="input" class="mt-3 ml-3 h6"></p>
                        <table class="table table-striped mt-4">
                            <thead>
                                <tr>
                                    <th>Département</th>
                                    <th>Nombre</th>
                                    <th>Pourcentage</th>
                                </tr>
                            </thead>
                            <tbody id="departmentTableBody">
                                <!-- Dynamic rows will be inserted here -->
                            </tbody>
                        </table>

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
    var departmentChart = echarts.init(document.getElementById('departmentChart'));

    function getRandomColor() {
        return '#' + Math.floor(Math.random() * 16777215).toString(16);
    }

    function updateDepartmentChart() {
        var tot =0 ; 
        var selectedYear = document.getElementById('departmentYearSelect').value;
        fetch(`/admin/internsByDepartment/${selectedYear}`)
            .then(response => response.json())
            .then(data => {
                var departments = Object.keys(data);
                var counts = Object.values(data);

                // Calculate the total number of interns
                var total = counts.reduce((sum, count) => sum + count, 0);
                tot = tot + total ;
                // Calculate percentages
                var percentages = counts.map(count => (count / total * 100).toFixed(2));

                // Filter out departments with 0% 
                var filteredDepartments = departments.filter((dept, index) => percentages[index] > 0);
                var filteredCounts = filteredDepartments.map(dept => data[dept]);
                var filteredPercentages = filteredDepartments.map(dept => (data[dept] / total * 100).toFixed(2));

                // Update the chart
                departmentChart.setOption({
                    title: { text: '', subtext: '', left: 'center' },
                    tooltip: { trigger: 'axis' },
                    xAxis: { 
                        type: 'category', 
                        data: filteredDepartments,
                        axisLabel: {
                            rotate: 45,
                            interval: 0
                        }
                    },
                    yAxis: { type: 'value' },
                    dataZoom: [
                        {
                            type: 'slider',
                            start: 0,
                            end: 100
                        }
                    ],
                    series: [{
                        name: 'Interns',
                        type: 'bar',
                        data: filteredCounts,
                        itemStyle: {
                            color: function(params) {
                                return getRandomColor();
                            }
                        },
                        label: {
                            show: true,
                            position: 'top',
                            formatter: function(params) {
                                return `${filteredPercentages[params.dataIndex]}%`;
                            }
                        }
                    }]
                });

                // Update the table
                var tableBody = document.getElementById('departmentTableBody');
                tableBody.innerHTML = ''; // Clear existing rows

                filteredDepartments.forEach((department, index) => {
                    var row = `<tr>
                        <td>${department}</td>
                        <td>${filteredCounts[index]}</td>
                        <td>${filteredPercentages[index]}%</td>
                    </tr>`;
                    tableBody.innerHTML += row;
                });
                var totalRow = `<tr> <td><strong>Total</strong></td> <td><strong>${tot}</strong></td> </tr>`
                tableBody.innerHTML += totalRow ;
            })
            .catch(error => console.error('Fetch error:', error));

            var annee = document.getElementById('departmentYearSelect');
            var inp = document.getElementById('input');
            inp.innerHTML =annee.value;
    }

    document.getElementById('departmentYearSelect').addEventListener('change', updateDepartmentChart);
    document.getElementById('departmentYearSelect').dispatchEvent(new Event('change'));
});



                    </script>

    


  
</body>
</html>
