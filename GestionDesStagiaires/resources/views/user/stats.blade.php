<!DOCTYPE html>
<html lang="en">
<head>
    @include('assets.headerAdmin')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2M</title>
    <link rel="stylesheet" href="{{asset('all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <style>
        #natureStageChart, #genderChart, #yearlyFlowChart, #monthlyFlowChart, #departmentChart, #encadrantChart {
            width: 100%;
            height: 400px;
            border: 1px solid #ddd;
            border-radius: 8px;
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
                        <div id="natureStageChart" style="width: 100%; height: 400px;"></div> <!-- Set dimensions -->
                        <select id="natureStageYearSelect" class="form-control mb-3">
                            @foreach($availableYears as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                        <!-- Add the print button -->
                        
                        <a href="{{route('nature')}}"><button class="btn btn-primary "  >Print Chart</button> </a>
                    </div>
                </div>
                
                
                <div class="row">
                    <div class="col-md-12 chart-container">
                      
                        <div id="genderChart"></div>
                        <select id="genderYearSelect" class="form-control mb-3">
                            @foreach($availableYears as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                        <a href="{{route('gender')}}"><button class="btn btn-primary "  >Print Chart</button> </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 chart-container">
                       
                        <div id="departmentChart"></div>
                        <select id="departmentYearSelect" class="form-control mb-3">
                            @foreach($availableYears as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                        <a href="{{route('depart')}}"><button class="btn btn-primary "  >Print Chart</button> </a>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12 chart-container">
                        <div id="yearlyFlowChart"></div>
                        <a href="{{route('year')}}"><button class="btn btn-primary  mt-3"  >Print Chart</button> </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 chart-container">
                        <div id="monthlyFlowChart"></div>
                        <select id="yearSelect" class="form-control mb-3">
                            @foreach($availableYears as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                        <a href="{{route('moisA')}}"><button class="btn btn-primary "  >Print Chart</button> </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 chart-container">  
                        <div id="encadrantChart"></div>
                        <select id="encadrantSelect" class="form-control mb-3">
                            @foreach($encadrants as $encadrant)
                                <option value="{{ $encadrant->id }}">{{ $encadrant->nom ." ".$encadrant->prenom}}</option>
                            @endforeach
                        </select>
                        <select id="yearEncadrantSelect" class="form-control mb-3">
                            @foreach($availableYears as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                        <a href="{{route('enc')}}"><button class="btn btn-primary "  >Print Chart</button> </a>

                    </div>
                </div>
            </div>
        </section>
    </div>



    <script src="{{asset('js/echarts.min.js')}}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var yearlyFlowChart = echarts.init(document.getElementById('yearlyFlowChart'));
            var monthlyFlowChart = echarts.init(document.getElementById('monthlyFlowChart'));
            var encadrantChart = echarts.init(document.getElementById('encadrantChart'));

         
                    // Yearly Flow Chart Data
            var yearlyData = @json($yearlyData);
            var yearlyOptions = {
                title: { text: 'Stagiaire par année', subtext: '', left: 'center' },
                tooltip: { trigger: 'axis' },
                xAxis: { type: 'category', data: yearlyData.map(item => item.year) },
                yAxis: { type: 'value' },
                series: [{ name: 'Interns', type: 'line', data: yearlyData.map(item => item.total) }]
            };
            yearlyFlowChart.setOption(yearlyOptions);


            // Monthly Flow Chart Data
            var monthlyOptions = {
                title: { text: 'Stagiaire par mois pour une année', subtext: '', left: 'center' },
                tooltip: { trigger: 'axis' },
                xAxis: { type: 'category', data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] },
                yAxis: { type: 'value' },
                series: [{ name: 'Interns', type: 'line', data: Array(12).fill(0) }]
            };
            monthlyFlowChart.setOption(monthlyOptions);

            // Update monthly flow chart on year selection
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
                    })
                    .catch(error => console.error('Fetch error:', error));
            });

            // Trigger change event on page load to display the current year's data
            document.getElementById('yearSelect').dispatchEvent(new Event('change'));

          
            // Encadrant Chart Data
            var encadrantOptions = {
                title: { text: 'Stagiaire par encadrant pour une année', subtext: '', left: 'center' },
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
            }

            // Event listeners for encadrant and year selection
            document.getElementById('encadrantSelect').addEventListener('change', updateEncadrantChart);
            document.getElementById('yearEncadrantSelect').addEventListener('change', updateEncadrantChart);

            // Trigger change event on page load to display the current data
            document.getElementById('encadrantSelect').dispatchEvent(new Event('change'));
        });
    </script>
    <script>
   document.addEventListener("DOMContentLoaded", function() {
    var departmentChart = echarts.init(document.getElementById('departmentChart'));

    function getRandomColor() {
        // Generate a random hex color
        return '#' + Math.floor(Math.random() * 16777215).toString(16);
    }

    function updateDepartmentChart() {
        var selectedYear = document.getElementById('departmentYearSelect').value;
        fetch(`/admin/internsByDepartment/${selectedYear}`)
            .then(response => response.json())
            .then(data => {
                var departments = Object.keys(data);
                var counts = Object.values(data);

                // Calculate the total number of interns
                var total = counts.reduce((sum, count) => sum + count, 0);

                // Calculate percentages
                var percentages = counts.map(count => (count / total * 100).toFixed(2));

                // Filter out departments with 0%
                var filteredDepartments = departments.filter((dept, index) => percentages[index] > 0);
                var filteredCounts = filteredDepartments.map(dept => data[dept]);
                var filteredPercentages = filteredDepartments.map(dept => (data[dept] / total * 100).toFixed(2));

                departmentChart.setOption({
                    title: { 
                        text: 'Stagiaire par département pour une année', 
                        subtext: '', 
                        left: 'center' 
                    },
                    tooltip: { trigger: 'axis' },
                    xAxis: { 
                        type: 'category', 
                        data: filteredDepartments,
                        axisLabel: {
                            rotate: 45,  // Rotate labels to make them vertical or diagonal
                            interval: 0  // Show all labels, even if they overlap
                        }
                    },
                    yAxis: { type: 'value' },
                    dataZoom: [
                        {
                            type: 'slider',  // Add a slider for scrolling if there are many departments
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
                                // Generate a random color for each bar
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
            })
            .catch(error => console.error('Fetch error:', error));
    }

    document.getElementById('departmentYearSelect').addEventListener('change', updateDepartmentChart);
    document.getElementById('departmentYearSelect').dispatchEvent(new Event('change'));
});



                    </script>

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

                                    genderChart.setOption({
                                        title: { text: 'Staigiare par sexe pour une année', subtext: '', left: 'center' },
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
                                })
                                .catch(error => console.error('Fetch error:', error));
                        }

                        document.getElementById('genderYearSelect').addEventListener('change', updateGenderChart);
                        document.getElementById('genderYearSelect').dispatchEvent(new Event('change'));
                    });

     </script>


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
    
                    var natureStageOptions = {
                        title: { text: 'Stagiaire par nature de stage pour une année', subtext: '', left: 'center' },
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
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                });
        }
    
        document.getElementById('natureStageYearSelect').addEventListener('change', updateNatureStageChart);
        
        // Trigger initial load
        document.getElementById('natureStageYearSelect').dispatchEvent(new Event('change'));
    });
    

</script>
</body>
</html>
