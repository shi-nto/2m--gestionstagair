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

            #encadrantChart {
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
                            <h1 class="h1">Stagiaire par encadrant pour </h1>
                            <p id="input" class = "h1 ml-1"></p>
                        </div> 
                        <div id="encadrantChart"></div>
                        <select id="encadrantSelect" class="form-control mb-3 no-print">
                            @foreach($encadrants as $encadrant)
                                <option value="{{ $encadrant->id }}">{{ $encadrant->nom ." ".$encadrant->prenom}}</option>
                            @endforeach
                        </select>
                        <select id="yearEncadrantSelect" class="form-control mb-3 no-print">
                            @foreach($availableYears as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                        <p id="input1" class="mt-1 ml-3 h5"></p>
                       
                        <!-- Wrap your buttons in a container -->
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
            var encadrantChart = echarts.init(document.getElementById('encadrantChart'));


          
            // Encadrant Chart Data
            var encadrantOptions = {
                title: { text: '', subtext: '', left: 'center' },
                tooltip: { trigger: 'axis' },
                xAxis: { type: 'category', data: [] },
                yAxis: { type: 'value' },
                series: [{ name: 'Interns', type: 'line', data: [] }]
            };
            encadrantChart.setOption(encadrantOptions);

            // Update encadrant chart on selection
            function updateEncadrantChart() {
                var selectedEncadrant = document.getElementById('encadrantSelect').value;
                var selectedYear = document.getElementById('yearEncadrantSelect').value;
                fetch(`/admin/encadrantData/${selectedEncadrant}/${selectedYear}`)
                    .then(response => response.json())
                    .then(data => {
                        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                        var encadrantData = months.map(month => data[month] || 0);
                        encadrantChart.setOption({
                            xAxis: { data: months },
                            series: [{ name: 'Interns', type: 'line', data: encadrantData }]
                        });
                    })
                    .catch(error => console.error('Fetch error:', error));


                        var annee = document.getElementById('yearEncadrantSelect');
                var inp = document.getElementById('input');
                var inp1 =  document.getElementById('input1');
                var enc = document.getElementById('encadrantSelect');

                inp.innerHTML = annee.value; 
                var encadrantText = enc.options[enc.selectedIndex].text;

                inp1.innerHTML = "Encadrant : " + encadrantText;
            }

            // Event listeners for encadrant and year selection
            document.getElementById('encadrantSelect').addEventListener('change', updateEncadrantChart);
            document.getElementById('yearEncadrantSelect').addEventListener('change', updateEncadrantChart);

            // Trigger change event on page load to display the current data
            document.getElementById('encadrantSelect').dispatchEvent(new Event('change'));
        });
    </script>
   
</body>
</html>
