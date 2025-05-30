// Theme toggle logic with localStorage to remember preference
document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('themeToggle');
    const icon = themeToggle.querySelector('i');
    
    // Check for saved theme preference
    if (localStorage.getItem('darkMode') === 'true') {
        document.body.classList.add('dark-mode');
        themeToggle.classList.add('dark');
        icon.classList.remove('bi-moon');
        icon.classList.add('bi-sun');
    }
    
    themeToggle.onclick = function() {
        document.body.classList.toggle('dark-mode');
        themeToggle.classList.toggle('dark');
        
        if(document.body.classList.contains('dark-mode')) {
            icon.classList.remove('bi-moon');
            icon.classList.add('bi-sun');
            localStorage.setItem('darkMode', 'true');
        } else {
            icon.classList.remove('bi-sun');
            icon.classList.add('bi-moon');
            localStorage.setItem('darkMode', 'false');
        }
    };
    
    // Show toast on load with animation
    setTimeout(function() {
        var toastEl = document.getElementById('mainToast');
        if (toastEl) {
            var toast = new bootstrap.Toast(toastEl, { delay: 3000 });
            toast.show();
        }
    }, 500);
    
    // Add active class to current page in sidebar
    const currentLocation = window.location.pathname;
    const sidebarLinks = document.querySelectorAll('.sidebar a');
    
    sidebarLinks.forEach(link => {
        if (link.getAttribute('href') === currentLocation) {
            link.classList.add('active');
            document.querySelectorAll('.sidebar a.active').forEach(activeLink => {
                if (activeLink !== link) activeLink.classList.remove('active');
            });
        }
    });
});