function toggleSearch() {
    const navRow = document.getElementById('nav-row');
    const searchBar = document.getElementById('search-bar');
    const navbar = document.querySelector('.navbar');
    
    if (searchBar.style.display === 'none' || searchBar.style.display === '') {
        // Show search bar
        searchBar.style.display = 'flex';
        searchBar.style.alignItems = 'center';
        searchBar.style.height = navbar.offsetHeight + 'px';
        navRow.style.visibility = 'hidden';
        
        // Style the container and input
        const container = searchBar.querySelector('.container');
        container.style.width = '100%';
        container.style.padding = '0 15px';
        
        // Create search input if it doesn't exist
        if (!searchBar.querySelector('.search-input')) {
            const input = document.createElement('input');
            input.type = 'text';
            input.className = 'form-control search-input';
            input.placeholder = 'Search...';
            input.style.width = '100%';
            input.style.padding = '10px';
            container.innerHTML = ''; // Clear existing content
            container.appendChild(input);
            
            // Add close button
            const closeBtn = document.createElement('button');
            closeBtn.className = 'btn btn-light position-absolute';
            closeBtn.innerHTML = '<i class="fas fa-times"></i>';
            closeBtn.style.right = '25px';
            closeBtn.style.top = '50%';
            closeBtn.style.transform = 'translateY(-50%)';
            closeBtn.onclick = toggleSearch;
            container.appendChild(closeBtn);
        }
        
        // Focus on input
        searchBar.querySelector('input').focus();
    } else {
        searchBar.style.display = 'none';
        navRow.style.visibility = 'visible';
    }
}