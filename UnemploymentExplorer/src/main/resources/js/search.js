document.addEventListener('DOMContentLoaded', function() {
    const searchBox = document.getElementById('search-box');
    const suggestionsContainer = document.getElementById('suggestions-container');
    
    // Hide suggestions container by default
    suggestionsContainer.style.display = 'none';
  
    searchBox.addEventListener('input', function() {
      const searchText = searchBox.value.toLowerCase();
      
      // Hide suggestions and return early if input is empty
      if (searchText.trim() === '') {
        suggestionsContainer.style.display = 'none';
        return; // Stop further execution
      }
      
      fetch('./searchIndex.json') 
        .then(response => response.json())
        .then(data => {
            
          const filteredData = data.filter(item => item.keyword.toLowerCase().includes(searchText));
          displaySuggestions(filteredData);
        });
    });
  });
  
  function displaySuggestions(suggestions) {
    const suggestionsContainer = document.getElementById('suggestions-container');
    suggestionsContainer.innerHTML = ''; // Clear previous suggestions
    if(suggestions.length === 0) {
      suggestionsContainer.style.display = 'none';
      return;
    }
  
    suggestions.forEach(suggestion => {
      const div = document.createElement('div');
      div.textContent = suggestion.page;
      div.addEventListener('click', () => {
        window.location.href = suggestion.url; // Navigate to the selected page
      });
      suggestionsContainer.appendChild(div);
    });
    
    suggestionsContainer.style.display = 'block'; // Ensure container is visible when there are suggestions
  }