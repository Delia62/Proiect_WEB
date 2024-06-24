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

        
        var ctx = canvas.getContext('2d');

        var svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
        svg.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
        svg.setAttribute('width', canvas.width);
        svg.setAttribute('height', canvas.height);

        var rect = document.createElementNS('http://www.w3.org/2000/svg', 'rect');
        rect.setAttribute('width', '100%');
        rect.setAttribute('height', '100%');
        rect.setAttribute('fill', 'white');
        svg.appendChild(rect);

        var img = new Image();
        img.src = canvas.toDataURL('image/png');
        img.onload = function() {
            var image = document.createElementNS('http://www.w3.org/2000/svg', 'image');
            image.setAttribute('href', img.src);
            image.setAttribute('width', canvas.width);
            image.setAttribute('height', canvas.height);
            svg.appendChild(image);

            var svgData = new XMLSerializer().serializeToString(svg);
            var svgBlob = new Blob([svgData], {type: 'image/svg+xml;charset=utf-8'});
            var svgUrl = URL.createObjectURL(svgBlob);

            var downloadLink = document.createElement('a');
            downloadLink.href = svgUrl;
            downloadLink.download = filename;
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
            URL.revokeObjectURL(svgUrl);
        };
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

        function generateCSVFromChartData() {
            const chart = Chart.getChart('myChart');
            if (!chart) {
                console.error('Chart instance not found.');
                return;
            }

            let csvContent = '';
            const data = chart.data;
            const labels = data.labels;
            const datasets = data.datasets;

            
            csvContent += ['Label', ...datasets.map(ds => ds.label)].join(',') + '\n';

            
            labels.forEach((label, index) => {
                const row = [label, ...datasets.map(ds => ds.data[index])];
                csvContent += row.join(',') + '\n';
            });

            return csvContent;
        }

        document.getElementById('export-svg-button').addEventListener('click', function () {
            downloadSVG('chart-data.svg');
        });

        document.getElementById('export-pdf-button').addEventListener('click', function () {
            downloadPDF('chart-data.pdf');
        });

        document.getElementById('export-csv-button').addEventListener('click', function () {
            const csvData = generateCSVFromChartData();
            downloadCSV(csvData, 'chart-data.csv');
        });
});
