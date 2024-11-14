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
        #inp {
    display: none; /* Hide on screen */
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

    #natureStageChart {
        height: 90vh;
        width: 100%;
    }

    #inp {
        display: block;
    }

    table {
        font-size: larger;
        width: 100%;
    }

    th, td {
        padding: 12px;
    }

    .chart-title, h1, h4, p {
        font-size: larger;
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
                            <img src="{{ asset('storage/images/2M_logo.png') }}" alt="2M Logo" class="w-30 h-16 ">
                        </div>
                        <div class="flex justify-center items-center mt-16 mb-3">
                            <h1 class="h1">Stagiaire par nature de stage pour</h1> 

                            <p id="input" class = "h1 ml-1"></p> 
                        </div>
                        <div id="natureStageChart" class="mt-16 " style="width: 100%; height: 400px;"></div> <!-- Set dimensions -->
                        <select id="natureStageYearSelect" class="form-control mt-3 mb-3 no-print ">
                            @foreach($availableYears as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                        <p id="input" class="mt-3 ml-3 h6"></p>

                        <table class="table table-striped mt-4">
                            <thead>
                                <tr>
                                    <th>Nature de Stage</th>
                                    <th>Nombre</th>
                                </tr>
                            </thead>
                            <tbody id="natureStageTableBody">
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

                
          
                <script src="{{asset('js/echarts.min.js')}}"></script>
    
    
       <script>
  document.addEventListener("DOMContentLoaded", function() {
    console.log('DOM fully loaded and parsed');
    
    var natureStageChart = echarts.init(document.getElementById('natureStageChart'));
    
    function getRandomColor() {
        return '#' + Math.floor(Math.random() * 16777215).toString(16);
    }

    function updateNatureStageChart() {
        var selectedYear = document.getElementById('natureStageYearSelect').value;
        console.log(`Fetching data for year: ${selectedYear}`);
        
        fetch(`/admin/internsByNatureStage/${selectedYear}`)
            .then(response => response.json())
            .then(data => {
                console.log('Data fetched:', data);
                
                var natureStageData = [
                    { value: data['Observation'] || 0, name: 'Stage Observation' },
                    { value: data['Application'] || 0, name: 'Stage d\'Application' },
                    { value: data['Fin d\'Étude'] || 0, name: 'Stage de Fin d\'Étude' }
                ];
                
                var colors = natureStageData.map(() => getRandomColor());

                // Update the chart
                var natureStageOptions = {
                    title: { text: '', subtext: '', left: 'center' },
                    tooltip: { trigger: 'item', formatter: '{a} <br/>{b}: {c} ({d}%)' },
                    legend: { orient: 'vertical', left: 'left', data: natureStageData.map(item => item.name) },
                    series: [{
                        name: 'Nature Stage',
                        type: 'pie',
                        radius: '50%',
                        data: natureStageData,
                        itemStyle: {
                            color: function(params) {
                                return colors[params.dataIndex];
                            }
                        },
                        label: {
                            show: true,
                            formatter: '{b}: {d}%'
                        }
                    }]
                };
                
                natureStageChart.setOption(natureStageOptions);

                // Update the table
                var tableBody = document.getElementById('natureStageTableBody');
                tableBody.innerHTML = ''; // Clear existing rows

                natureStageData.forEach(item => {
                    var row = `<tr>
                        <td>${item.name}</td>
                        <td>${item.value}</td>
                    </tr>`;
                    tableBody.innerHTML += row;
                });
            })
            .catch(error => {
                console.error('Fetch error:', error);
            });
            
            var annee = document.getElementById('natureStageYearSelect');
            var inp = document.getElementById('input');
            inp.innerHTML = annee.value;

    }

    document.getElementById('natureStageYearSelect').addEventListener('change', updateNatureStageChart);
    
    // Trigger initial load
    document.getElementById('natureStageYearSelect').dispatchEvent(new Event('change'));
});

</script>
</body>
</html>
