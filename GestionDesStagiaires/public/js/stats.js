function printDiv(divId) {
    // Get all charts and other elements in the page
    const charts = document.querySelectorAll('.chart-container');
    const chartToPrint = document.getElementById(divId).parentElement;

    // Store original styles for restoration
    const originalStyles = [];
    charts.forEach(chart => {
        originalStyles.push(chart.style.cssText);
        if (chart !== chartToPrint) {
            chart.style.display = 'none';
        }
    });

    // Create a container for the logo and chart
    const printContainer = document.createElement('div');
    printContainer.style.display = 'flex';
    printContainer.style.flexDirection = 'column';
    printContainer.style.justifyContent = 'center';
    printContainer.style.alignItems = 'center';
    printContainer.style.width = '100%';
    printContainer.style.height = '100vh';
    printContainer.style.position = 'fixed';
    printContainer.style.top = '0';
    printContainer.style.left = '0';
    printContainer.style.zIndex = '9999';
    printContainer.style.backgroundColor = 'white';
    printContainer.style.paddingTop = '20px';

    // Create and style the logo
    const logoImg = document.createElement('img');
    logoImg.src = "../storage/images/2M_logo.png"; // Use Laravel's asset helper
    logoImg.style.maxWidth = '200px';
    logoImg.style.marginBottom = '20px';

    // Append the logo and chart to the container
    printContainer.appendChild(logoImg);
    printContainer.appendChild(chartToPrint);

    // Append the container to the body
    document.body.appendChild(printContainer);

    // Trigger the print dialog
    window.print();

    // Remove the print container and restore original styles
    document.body.removeChild(printContainer);
    charts.forEach((chart, index) => {
        chart.style.cssText = originalStyles[index];
    });
}


document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.btn-primary').forEach((button, index) => {
        button.addEventListener('click', function() {
            const chartIds = [
               'natureStageChart', 'genderChart', 'departmentChart', 
                'yearlyFlowChart', 'monthlyFlowChart', 'encadrantChart'
            ];
            printDiv(chartIds[index]);
        });
    });
});