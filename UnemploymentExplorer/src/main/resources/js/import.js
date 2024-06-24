export function handleFiles(files, year, month, type) {
    if (files.length === 0) return;
    const file = files[0];
    const reader = new FileReader();
    reader.onload = function(event) {
      const text = event.target.result;
      parseCSV(text, year, month, type);
    };
    reader.readAsText(file);
  }
  
export function parseCSV(text, year, month, type) {
    const lines = text.split('\n').map(line => line.trim()).filter(line => line);



    const header = lines[0].toLowerCase();
    
    // Define keywords for each type
    const typeKeywords = {
        'educatie': ['studii', 'primar', 'gimnazi', 'lice', 'postlice', 'profesi', 'universita'], 
        'mediu': ['urban', 'rural', 'mediu'] ,
        'varsta': ['varsta', 'ani', '25', '29'],
        'rata': ['rata', '%']
    };
    
    // Check if the header contains any of the keywords for the selected type
    const keywords = typeKeywords[type];
    const containsKeywords = keywords.some(keyword => header.includes(keyword));
    
    if (!containsKeywords) {
      alert('Fisierul incarcat nu este de tipul selectat. Va rugam verificati din nou.');
        console.error('Selected type does not match the file content.');
        return;
    }








    const regex = /(?:,|\n|^)("(?:(?:"")*[^"]*)*"|[^",\n]*|(?:\n|$))/g;
    let result = lines.map(line => {
        let matches = [];
        let match;
        while ((match = regex.exec(line)) !== null) {
            let field = match[1];
            if (field === undefined) continue; // Skip undefined captures
            if (field.startsWith('"') && field.endsWith('"')) {
                field = field.substring(1, field.length - 1).replace(/""/g, '"');
            }
            field = field.trim();
            if (field || matches.length > 0) { // Avoid pushing empty fields, unless it's a middle field
                matches.push(field);
            }
        }
        // Filter out any trailing empty match, if necessary
        if (matches.length > 0 && matches[matches.length - 1] === '') {
            matches.pop();
        }
        return matches;
    });

    // Filter out empty ending lines from result
    result = result.filter(line => line.length > 0 && line.some(field => field !== ''));

    // Determine the number of header columns
    const headerLength = result[0].length;
    
    const processedResult = result.slice(1).map(line => {
      let firstElement = line[0].toUpperCase().trim();
    
      if(firstElement.includes('BISTR'))
          firstElement = 'BISTRITA';
      else if( firstElement.includes('CARA'))
          firstElement = 'CARAS';
      else if (firstElement.includes('BUC')) 
          firstElement = 'BUCURESTI';
      else if (firstElement.includes('SATU'))
          firstElement = 'SATU';
      
      line[0] = firstElement;
    
      // Ensure the line has the same number of columns as the header
      if (line.length > headerLength) {
          line = line.slice(0, headerLength);
      }
    
      return line;
    });
    // Re-add the first line to the processed result
    processedResult.unshift(result[0]);
    
    // Ensure the final result matches the header length
    processedResult.forEach(line => {
      if (line.length > headerLength) {
        line.pop();
      }
    });
    
    sendResult(processedResult, year, month, type);
  }


export function sendResult(result, year, month, type) {
  $.ajax({
    url: "../php/repository/uploadFileToDB.php",
    type: "POST",
    data: {
      year: year,
      month: month,
      type: type,
      data: JSON.stringify(result)
    },
    success: function(data) {
      console.log(data);
      alert('Fisierul a fost incarcat cu succes!');
    },
    error: function(xhr, status, error) {
      console.error(xhr);
      console.error(status);
      console.error(error);
      // Parse JSON error response
      var errorMsg = "Unknown error";
      try {
        var resp = JSON.parse(xhr.responseText);
        errorMsg = resp.error || errorMsg;
      } catch (e) {
        console.error("Error parsing error response:", e);
      }
      alert('A aparut o eroare la incarcarea fisierului: ' + errorMsg);
    }
  });
}