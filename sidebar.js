
document.addEventListener('DOMContentLoaded', function() {
    // Create the sidebar HTML
    const sidebarHTML = `
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h2>Livestock Management</h2>
            <button class="toggle-btn">
                <i class="fas fa-bars"></i>
            </button>
        </div>
        
        <!-- Search Bar -->
        <div class="search-container">
            <input type="search" class="search-bar" placeholder="Search menu...">
            <i class="fas fa-search search-icon"></i>
        </div>
        
        <!-- Navigation Menu -->
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="/dashboard.html" data-title="Dashboard">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard Overview</span>
                </a>
            </li>

            <li class="nav-item has-submenu">
                <a href="#" data-title="Livestock">
                    <i class="fas fa-cow"></i>
                    <span>Livestock Inventory</span>
                </a>
                <ul class="submenu">
                    <li><a href="/animals.html">Animals</a></li>
                    <li><a href="/breeds.html">Breeds</a></li>
                    <li><a href="/groups.html">Groups/Pens</a></li>
                </ul>
            </li>

            <li class="nav-item has-submenu">
                <a href="#" data-title="Vaccine">
                    <i class="fas fa-heartbeat"></i>
                    <span>Vaccine Management</span>
                </a>
                <ul class="submenu">
                    <li><a href="/health-records.html">Health Records</a></li>
                    <li><a href="/schedule_vaccination.html">Vaccinations Schedule</a></li>
                    <li><a href="/vet-contacts.html">Veterinary Contacts</a></li>
                </ul>
            </li>

            <li class="nav-item has-submenu">
                <a href="#" data-title="Breeding">
                    <i class="fas fa-baby"></i>
                    <span>Breeding & Reproduction</span>
                </a>
                <ul class="submenu">
                    <li><a href="/breeding-schedule.html">Breeding Schedule</a></li>
                    <li><a href="/pregnancy_records.html">Pregnancy Tracking</a></li>
                    <li><a href="/birth-records.html">Birth Records</a></li>
                </ul>
            </li>

            <li class="nav-item has-submenu">
                <a href="#" data-title="Health">
                    <i class="fas fa-drumstick-bite"></i>
                    <span>Health Management</span>
                </a>
                <ul class="submenu">
                    <li><a href="/feed-inventory.html">Feed Inventory</a></li>
                    <li><a href="/feeding-schedule.html">Feeding Schedule</a></li>
                    <li><a href="/nutrition-plans.html">Nutrition Plans</a></li>
                </ul>
            </li>

            <li class="nav-item has-submenu">
                <a href="#" data-title="Production">
                    <i class="fas fa-chart-line"></i>
                    <span>Production & Performance</span>
                </a>
                <ul class="submenu">
                    <li><a href="/weight-tracking.html">Weight Tracking</a></li>
                </ul>
            </li>

            <li class="nav-item has-submenu">
                <a href="#" data-title="Sales">
                    <i class="fas fa-dollar-sign"></i>
                    <span>Sales Management</span>
                </a>
                <ul class="submenu">
                    <li><a href="/buyers.html">Buyers</a></li> 
                    <li><a href="/sellers.html">Sellers</a></li> 
                    <li><a href="/sales.html">Livestock Sale List</a></li>
                    <li><a href="/profit-analysis.html">Profit Analysis</a></li>
                </ul>
            </li>

            <li class="nav-item has-submenu">
                <a href="#" data-title="Reports">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reports & Analytics</span>
                </a>
                <ul class="submenu">
                    <li><a href="/health-reports.html">Health Reports</a></li>
                    <li><a href="/production-reports.html">Production Reports</a></li>
                    <li><a href="/financial-reports.html">Financial Reports</a></li>
                </ul>
            </li>

            <li class="nav-item has-submenu">
                <a href="#" data-title="Settings">
                    <i class="fas fa-cog"></i>
                    <span>Settings & Configuration</span>
                </a>
                <ul class="submenu">
                    <li><a href="/user-management.html">User Management</a></li>
                    <li><a href="/farm-details.html">Farm Details</a></li>
                    <li><a href="/system-preferences.html">System Preferences</a></li>
                </ul>
            </li>

            <li class="nav-item has-submenu">
                <a href="#" data-title="Help">
                    <i class="fas fa-question-circle"></i>
                    <span>Help & Support</span>
                </a>
                <ul class="submenu">
                    <li><a href="/user-guides.html">User Guides</a></li>
                    <li><a href="/contact-support.html">Contact Support</a></li>
                </ul>
            </li>
        </ul>
    </div>`;

    // Insert the sidebar at the beginning of the body
    const sidebarContainer = document.getElementById('sidebar-container');
    if (sidebarContainer) {
        sidebarContainer.innerHTML = sidebarHTML;
    }

    // Get sidebar state from localStorage
    const sidebarState = localStorage.getItem('sidebarState');
    const sidebar = document.querySelector('.sidebar');
    
    // Apply saved state (collapsed or expanded)
    if (sidebarState === 'collapsed' && sidebar) {
        sidebar.classList.add('collapsed');
    }

    // Toggle sidebar collapse
    const toggleBtn = document.querySelector('.toggle-btn');
    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            
            // Save state to localStorage
            const isCollapsed = sidebar.classList.contains('collapsed');
            localStorage.setItem('sidebarState', isCollapsed ? 'collapsed' : 'expanded');
        });
    }

    // Handle submenu toggles
    const menuItems = document.querySelectorAll('.nav-item.has-submenu');
    
    menuItems.forEach(item => {
        const link = item.querySelector('a');
        const submenu = item.querySelector('.submenu');
        
        if (link && submenu) {
            link.addEventListener('click', (e) => {
                // Only prevent default for parent menu items with submenus
                e.preventDefault();
                
                menuItems.forEach(otherItem => {
                    if (otherItem !== item) {
                        otherItem.classList.remove('active');
                        const otherSubmenu = otherItem.querySelector('.submenu');
                        if (otherSubmenu) {
                            otherSubmenu.classList.remove('active');
                        }
                    }
                });
                
                item.classList.toggle('active');
                submenu.classList.toggle('active');
            });
        }
    });

    // Highlight current page in navigation
    const currentPage = window.location.pathname.split('/').pop();
    const menuLinks = document.querySelectorAll('.nav-menu a');
    
    menuLinks.forEach(link => {
        const linkPage = link.getAttribute('href').split('/').pop();
        
        if (linkPage === currentPage) {
            link.classList.add('active');
            
            // If it's in a submenu, open that submenu
            const parentSubmenu = link.closest('.submenu');
            if (parentSubmenu) {
                parentSubmenu.classList.add('active');
                const parentItem = parentSubmenu.closest('.nav-item');
                if (parentItem) {
                    parentItem.classList.add('active');
                }
            }
        }
    });

    // Search functionality
    const searchBar = document.querySelector('.search-bar');
    if (searchBar) {
        searchBar.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            menuLinks.forEach(link => {
                const text = link.textContent.toLowerCase();
                const listItem = link.closest('li');
                
                if (text.includes(searchTerm)) {
                    if (listItem) listItem.style.display = '';
                    const parentSubmenu = link.closest('.submenu');
                    if (parentSubmenu) {
                        parentSubmenu.style.display = '';
                        const parentItem = parentSubmenu.closest('.nav-item');
                        if (parentItem) {
                            parentItem.style.display = '';
                        }
                    }
                } else {
                    if (listItem) listItem.style.display = 'none';
                }
            });
        });
    }
});