import "./import.js";
import { handleFiles } from "./import.js";

const monthsOrder = ["ianuarie", "februarie", "martie", "aprilie", "mai", "iunie", "iulie", "august", "septembrie", "octombrie", "noiembrie", "decembrie"];
const typesOrder = ["educatie", "mediu", "varsta", "rata"];
let globalAvailableFiles = [];
updateAvailableFiles();

function updateYears(){


    let years = Object.keys(globalAvailableFiles);
    years.sort();
    console.log(years);

    let downloadYears = document.getElementById("download-an");
    downloadYears.innerHTML = "";
    for (let i = 0; i < years.length; i++){
        let option = document.createElement("option");
        option.text = years[i];
        downloadYears.add(option);
    }

    updateMonths();
}

function updateMonths(){
    console.log(globalAvailableFiles);
    let year = document.getElementById("download-an").value;
    let months = Object.keys(globalAvailableFiles[year]);
    months.sort(function(a, b){
        return monthsOrder.indexOf(a) - monthsOrder.indexOf(b);
    });
    console.log(months);

    let downloadMonths = document.getElementById("download-luna");
    downloadMonths.innerHTML = "";
    for (let i = 0; i < months.length; i++){
        let option = document.createElement("option");
        option.text = months[i];
        downloadMonths.add(option);
    }

    updateTypes();
}

function updateTypes(){
    let year = document.getElementById("download-an").value;
    let month = document.getElementById("download-luna").value;
    let types = globalAvailableFiles[year][month];
    types.sort(function(a, b){
        return typesOrder.indexOf(a) - typesOrder.indexOf(b);
    });

    let downloadTypes = document.getElementById("download-tip");
    downloadTypes.innerHTML = "";
    for (let i = 0; i < types.length; i++){
        let option = document.createElement("option");
        option.text = types[i];
        downloadTypes.add(option);
    }

}


function updateAvailableFiles(){
    
    //ajax call to get available files
    $.ajax({
        url: "../php/repository/availableFiles.php",
        type: "POST",
        data: {},
        success: function(data){
            //console.log(data);
            var files = JSON.parse(data);
            globalAvailableFiles = files;
            console.log(globalAvailableFiles);
            updateYears();
        }
    });
}


document.getElementById("download-an").addEventListener("change", updateMonths);
document.getElementById("download-luna").addEventListener("change", updateTypes);


document.getElementById('upload-file').addEventListener('change', function() {
    const year = document.getElementById("upload-an").value;
    const month = document.getElementById("upload-luna").value;
    const type = document.getElementById("upload-tip").value;
    if(!year || !month || !type){
        alert("Selectati anul, luna si tipul fisierului!");
        return; 
    }

    if(globalAvailableFiles[year] && globalAvailableFiles[year][month] && globalAvailableFiles[year][month].includes(type)){
        alert("Fisierul selectat exista deja in baza de date!");
        return;
    }

    handleFiles(this.files, year, month, type);
    updateAvailableFiles();
});


document.getElementById("download-button").addEventListener("click", function(e){
    e.preventDefault();


    const year = document.getElementById("download-an").value;
    const month = document.getElementById("download-luna").value;
    const type = document.getElementById("download-tip").value;
    if(!year || !month || !type){
        alert("Selectati anul, luna si tipul fisierului!");
        return; 
    }

    const csvRadio = document.getElementById("csv");
    const jsonRadio = document.getElementById("json");
    const pdfRadio = document.getElementById("pdf");
    if(!csvRadio.checked && !jsonRadio.checked && !pdfRadio.checked){
        alert("Selectati formatul in care doriti sa descarcati fisierul!");
        return;
    }

    function determineFormat() {
        return csvRadio.checked ? "csv" : jsonRadio.checked ? "json" : "pdf";
    }

    function determineMimeType(format) {
        return format === "csv" ? 'text/csv' : format === "json" ? 'application/json' : 'application/pdf';
    }

    function handleSuccess(data, year, month, type) {
        const format = determineFormat();
        const mimeType = determineMimeType(format);
        const blob = new Blob([data], { type: mimeType });
        const link = document.createElement('a');
        link.href = window.URL.createObjectURL(blob);
        link.download = `${year}-${month}-${type}.${format}`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    const format = determineFormat();

    if (format === "pdf") {
        $.ajax({
            url: "../php/repository/downloadFile.php",
            type: "POST",
            data: {
                year: year,
                month: month,
                type: type,
                format: format
            },
            xhrFields: {
                responseType: 'blob'
            },
            success: function(data) {
                handleSuccess(data, year, month, type);
            },
            error: function(xhr, status, error) {
                console.error("Download failed:", status, error);
            }
        });
    } else {
        $.ajax({
            url: "../php/repository/downloadFile.php",
            type: "POST",
            data: {
                year: year,
                month: month,
                type: type,
                format: format
            },
            success: function(data) {
                handleSuccess(data, year, month, type);
            },
            error: function(xhr, status, error) {
                console.error("Download failed:", status, error);
            }
        });
    }
});