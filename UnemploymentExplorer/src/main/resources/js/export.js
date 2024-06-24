document.addEventListener('DOMContentLoaded', function() {
    console.log('Export SVG Button:', document.getElementById('export-svg-button'));
    console.log('Export PDF Button:', document.getElementById('export-pdf-button'));
    console.log('Export CSV Button:', document.getElementById('export-csv-button'));

    function downloadSVG(filename) {
        var canvas = document.getElementById('myChart');
    
        if (!canvas) {
            console.error('Canvas element not found.');
            return;
        }
    
        var svg = canvas.toDataURL('image/svg+xml');
        var downloadLink = document.createElement('a');
        downloadLink.href = svg;
        downloadLink.download = filename;
    
        document.body.appendChild(downloadLink);
        downloadLink.click();

        document.body.removeChild(downloadLink);
    }
    
    
function downloadPDF(filename) {
    const canvas = document.getElementById('myChart');
    const canvasImage = canvas.toDataURL('image/jpeg', 1.0);

    let pdf = new jsPDF('landscape');
    pdf.setFontSize(10);

    pdf.setFillColor(255, 255, 255);
    pdf.rect(0, 0, pdf.internal.pageSize.width, pdf.internal.pageSize.height, 'F');
    
    pdf.addImage(canvasImage, 'JPEG', 15, 15, 210, 150);

    pdf.save(filename);
}


function downloadCSV(csv, filename) {
    var csvFile = new Blob([csv], { type: 'text/csv' });
    var downloadLink = document.createElement('a');
    downloadLink.download = filename;
    downloadLink.href = window.URL.createObjectURL(csvFile);
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}

document.getElementById('export-svg-button').addEventListener('click', function () {
    downloadSVG('chart-data.svg');
});

document.getElementById('export-pdf-button').addEventListener('click', function () {
    downloadPDF('chart-data.pdf');
});

document.getElementById('export-csv-button').addEventListener('click', function () {
    var csvData = 'Coloană1,Coloană2,Coloană3\nValoare1,Valoare2,Valoare3';
    downloadCSV(csvData, 'chart-data.csv');
});


});
