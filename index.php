
<?php

session_start();

// Include database connection
include('includes/connect.php');

// Fetch recent cattle data from the database
$sql = "SELECT 
            cattle_id, 
            farmer_id, 
            rfid_tag, 
            breed, 
            sex, 
            animal_type, 
            weight, 
            price, 
            images, 
            other_health_notes, 
            created_at 
        FROM 
            cattle";
$result = $con->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            display: flex;
            background: #f0f2f5;
        }

       
        /* Main Content Area */
        .main-content {
            flex: 1;
            padding: 20px;
        }

        /* Dashboard Cards */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .stat-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-card.blue { background: #2196f3; color: white; }
        .stat-card.green { background: #4caf50; color: white; }
        .stat-card.orange { background: #ff9800; color: white; }
        .stat-card.red { background: #f44336; color: white; }

        .stat-info h3 {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .stat-info .number {
            font-size: 24px;
            font-weight: bold;
        }

        .stat-icon {
            font-size: 40px;
            opacity: 0.8;
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .action-card {
            background: #4caf50;
            color: white;
            padding: 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .action-card:hover {
            transform: translateY(-2px);
        }

        .action-card h3 {
            margin-bottom: 10px;
        }

        /* Recent Activities Table */
        .table-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #f5f5f5;
            font-weight: 600;
        }

        .status {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
        }

        .status.healthy { background: #c8e6c9; color: #2e7d32; }
        .status.sick { background: #ffcdd2; color: #c62828; }
        .status.recovering { background: #fff3e0; color: #ef6c00; }

        .btn {
            padding: 6px 12px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-primary {
            background: #2196f3;
            color: white;
        }
        .btn-primary:hover {
    background-color: #0056b3; /* Darker Blue */
}

        .btn-success {
            background: #4caf50;
            color: white;
        }
        .add-Livestock-button {
        background: none;
        border: none;
        font-size: 1.5em; /* Similar to h3 */
        font-weight: bold;
        color: #ffffff;
        cursor: pointer;
        padding: 5px;
    }

    .btn-success {
    background: #4caf50;
    color: white;
}

.btn-danger {
    background: #f44336;
    color: white;
}
.btn-danger:hover {
    background-color: #c82333; /* Darker Red */
}

.btn-info {
    background: #ff9800;
    color: white;
}
.btn-info:hover {
    background-color: #e68900; /* Darker Orange */
}



.search-filter-section {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }

    .search-bar {
        margin-bottom: 20px;
    }

    .search-input {
        width: 100%;
        padding: 12px;
        border: 2px solid #e2e8f0;
        border-radius: 6px;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .search-input:focus {
        border-color: #4caf50;
        outline: none;
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.2);
    }

    .filters-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
    }

    .filter-group label {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 5px;
        color: #2d3748;
    }

    .filter-group select,
    .filter-group input {
        padding: 8px 12px;
        border: 2px solid #e2e8f0;
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .filter-group select:focus,
    .filter-group input:focus {
        border-color: #4caf50;
        outline: none;
        box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.2);
    }

    .price-range {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .price-input {
        width: 100%;
    }

    .filter-buttons {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .filter-btn {
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .apply-filters {
        background: #4caf50;
        color: white;
    }

    .apply-filters:hover {
        background: #388e3c;
    }

    .reset-filters {
        background: #f44336;
        color: white;
    }

    .reset-filters:hover {
        background: #d32f2f;
    }
    a {
    text-decoration: none;
    color: inherit;
}


.card {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.stat-card.pregnant {
    background-color: #8e44ad; /* Purple color for Pregnant Animals */
    color: white;
}

.stat-info {
    display: flex;
    flex-direction: column;
}

.stat-info h3 {
    font-size: 18px;
    margin-bottom: 5px;
}

.number {
    font-size: 24px;
    font-weight: bold;
}

.stat-icon {
    font-size: 40px;
    margin-left: 15px;
}


/*schedhule vaccination */
.card {
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.card.stat-card.schedule-vaccination {
    background-color: #7f8c8d; /* Gray color for Schedule Vaccination */
    color: white;
}


.stat-info {
    display: flex;
    flex-direction: column;
}

.stat-info h3 {
    font-size: 18px;
    margin-bottom: 5px;
}

.number {
    font-size: 24px;
    font-weight: bold;
}

.stat-icon {
    font-size: 40px;
    margin-left: 15px;
}

/*sales*/
.card {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        /* Sales card styling with vibrant green color for sales */
        .card.stat-card.sales {
            background-color: #7f8c8d;/* Green color to represent success/growth */
            color: white;
        }

        .stat-info {
            display: flex;
            flex-direction: column;
        }

        .stat-info h3 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .number {
            font-size: 24px;
            font-weight: bold;
        }

        .stat-icon {
            font-size: 40px;
            margin-left: 15px;
        }

        .stat-info p {
            font-size: 14px;
            margin-top: 5px;
            opacity: 0.8;
        }


        /* Sidebar Styles */
.sidebar {
    width: 250px;
    background: #1b5e20;
    min-height: 100vh;
    color: white;
    padding: 20px 0;
}

.sidebar-header {
    padding: 0 20px 20px;
    border-bottom: 1px solid #2e7d32;
}

.nav-menu {
    list-style: none;
    padding: 20px 0;
    font-size: 18px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.nav-item {
    padding: 12px 20px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 18px; /* Default text size */
    padding: 10px 20px; /* Default padding */
    transition: all 0.3s ease; /* Smooth transition for all properties */
}

.nav-item:hover {
    background:rgb(89, 146, 91); /* Brighter shade of your theme color */
    transition: background-color 0.3s ease;
    font-size: 18px; /* Increase text size on hover */
    padding: 12px 20px; /* Adjust padding to allow the item to grow */
    transform: scale(1.05);
    width:98%; /* Slightly scale up the whole nav item */ /* Smooth transition */
}

.nav-item.active {
    background: #2e7d32;
}
       
    </style>
        
       
    </style>
</head>
<body>
    <!-- Sidebar -->
   <!-- Sidebar -->
<div class="sidebar">
    <div class="sidebar-header">
        <h2>Livestock Management</h2>
    </div>
    <ul class="nav-menu">
        <li class="nav-item">
            <a href="index.php">
                <i class="fas fa-dashboard"></i>
                Dashboard
            </a>
        </li>
        
        <li class="nav-item active">
            <a href="cattle_records.php">
                <i class="fas fa-cow"></i>
                Livestock Records
            </a>
        </li>
        
        <li class="nav-item">
            <a href="rfid_management_records.html">
                <i class="fas fa-tag"></i>
                RFID Records
            </a>
        </li>
        <li class="nav-item">
            <a href="sale_records.html">
                <i class="fas fa-chart-line"></i>
                Sale Records
            </a>
        </li>
        
        
        <li class="nav-item">
            <a href="vaccination_reports.html">
                <i class="fas fa-syringe"></i>
                Vaccination Records
            </a>
        </li>
        
        <li class="nav-item">
            <a href="pregnancy_records.html">
                <i class="fas fa-baby"></i>
                Pregnancy Records
            </a>
        </li>
        
        <li class="nav-item">
            <i class="fas fa-user"></i>
            Profile
        </li>
        <li class="nav-item">
            <i class="fas fa-cog"></i>
            Settings
        </li>
    </ul>
</div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Statistics Cards -->
        <div class="dashboard-cards">
            <div class="card stat-card blue">
                <div class="stat-info">
                    <h3>Total Livestock</h3>
                    <div class="number">156</div>
                </div>
                <i class="fas fa-cow stat-icon"></i>
            </div>
            <div class="card stat-card green">
                <div class="stat-info">
                    <h3>Healthy</h3>
                    <div class="number">142</div>
                </div>
                <i class="fas fa-heart stat-icon"></i>
            </div>
            <div class="card stat-card orange">
                <div class="stat-info">
                    <h3>Under Treatment</h3>
                    <div class="number">8</div>
                </div>
                <i class="fas fa-stethoscope stat-icon"></i>
            </div>
            <div class="card stat-card red">
                <div class="stat-info">
                    <h3>Needs Attention</h3>
                    <div class="number">6</div>
                </div>
                <i class="fas fa-exclamation-circle stat-icon"></i>
            </div>
            <div class="card stat-card pregnant">
                <div class="stat-info">
                    <h3>Pregnant Animals</h3>
                    <div class="number" id="pregnantAnimalsCount">6</div> <!-- Number of pregnant animals here -->
                </div>
                <i class="fas fa-pregnant-woman stat-icon"></i>
            </div>
            
            <div class="card stat-card sales">
                <div class="stat-info">
                    <h3>Sales This Month</h3>
                    <div class="number" id="salesCount">150</div> <!-- Number of sales this month -->
                    <p>+10% from last month</p> <!-- Showing growth percentage -->
                </div>
                <i class="fas fa-chart-line stat-icon"></i> <!-- Icon for sales growth -->
            </div>
            
            
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
        <div class="action-card">
    <button type="button" onclick="window.location.href='add_cattle.php'" class="add-Livestock-button">Add New Livestock</button>
    <p>Register new Livestock in the system</p>
</div>

            
            <div class="action-card">
                
                <button type="button" onclick="redirectToScheduleVaccination()" class="add-Livestock-button">Schedule Vaccination</button>
                <p>Plan upcoming vaccinations</p>
            </div>
            <div class="action-card">
               
                <button type="button" onclick="redirectToHealthCheck()" class="add-Livestock-button">Health Check</button>
                <p>Record health observations</p>
            </div>
        </div>





        <div class="table-container">
            <h2>Recent Activities</h2>
            <table>
                <thead>
                    <tr>
                    <th>Cattle ID</th>
                        <th>Farmer ID</th>
                        <th>RFID Tag</th>
                        <th>Breed</th>
                        <th>Sex</th>
                        <th>Animal Type</th>
                        <th>Weight</th>
                        <th>Price</th>
                        <th>Images</th>
                        <th>Health Notes</th>
                        <th>Created At</th>
                        <th>Actions</th> <!-- Added Actions Column -->
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <?php
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["cattle_id"] . "</td>";
                            echo "<td>" . $row["farmer_id"] . "</td>";
                            echo "<td>" . $row["rfid_tag"] . "</td>";
                            echo "<td>" . $row["breed"] . "</td>";
                            echo "<td>" . $row["sex"] . "</td>";
                            echo "<td>" . $row["animal_type"] . "</td>";
                            echo "<td>" . $row["weight"] . "</td>";
                            echo "<td>" . $row["price"] . "</td>";
                            echo "<td>" . $row["images"] . "</td>";
                            echo "<td>" . $row["other_health_notes"] . "</td>";
                            echo "<td>" . $row["created_at"] . "</td>";
                            // Add buttons for view, edit, and delete actions
        echo "<td>
        <a href='view_details.php?id=" . $row["cattle_id"] . "'>View</a> |
        <a href='edit_livestock.php?id=" . $row["cattle_id"] . "'>Edit</a> |
        <a href='delete.php?id=" . $row["cattle_id"] . "' onclick=\"return confirm('Are you sure you want to delete this record?');\">Delete</a>
      </td>";

                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='11'>No cattle data found.</td></tr>";
                    }
                    ?>
                        
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function viewMoreAnimal(animalId) {
            // Redirect to the Livestock_details.html page with the animal ID as a query parameter
            window.location.href = `cattle_details.html?animalId=${animalId}`;
        }
        function redirectToAddLivestock() {
            window.location.href = "add_cattle.html";
        }
        function redirectToScheduleVaccination() {
            window.location.href = "schedule_vaccination.html";
        }
        function redirectToHealthCheck() {
            window.location.href = "healthcheck.html";
        }
    
        function editAnimal(rfid, breed, type, age, weight, health) {
            const url = `edit_page.html?rfid=${encodeURIComponent(rfid)}&breed=${encodeURIComponent(breed)}&type=${encodeURIComponent(type)}&age=${encodeURIComponent(age)}&weight=${encodeURIComponent(weight)}&health=${encodeURIComponent(health)}`;
            window.location.href = url;
        }

        function applyFilters() {
            // Implementation for applying filters
            console.log('Applying filters...');
            // Add your filter logic here
        }

        function resetFilters() {
            // Reset all form inputs
            document.querySelectorAll('.search-input, .filter-group select, .filter-group input').forEach(input => {
                input.value = '';
            });
        }
    </script>


</body>
</html>