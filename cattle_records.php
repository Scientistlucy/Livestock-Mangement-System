<?php
// Include database connection
include('includes/connect.php');

// Start session if needed
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livestock Records</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body, h1, table, input, button, select {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #e8f5e9;
            color: #2e7d32;
            line-height: 1.6;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #1b5e20;
        }

        .container {
            max-width: 3000px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .Livestock-record h2 {
            font-size: 20px;
            margin-bottom: 15px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #388e3c;
            color: white;
        }

        tr:hover {
            background-color: #c8e6c9;
        }

        td img {
            width: 100px;
            height: auto;
        }

        .search-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .search-form {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 20px;
        }

        .search-select {
            position: relative;
            min-width: 200px;
        }

        .search-select select {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #388e3c;
            border-radius: 4px;
            appearance: none;
            background: white url('data:image/svg+xml;utf8,<svg fill="%23388e3c" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>') no-repeat right 10px center;
            cursor: pointer;
            color: #2e7d32;
        }

        .search-btn {
            background: #388e3c;
            color: white;
            border: none;
            padding: 10px 40px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .search-btn:hover {
            background: #2e7d32;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
            padding: 0 20px;
        }

        .btn {
            background-color: #388e3c;
            color: white;
            padding: 12px 25px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            border: none;
            flex: 0 1 200px;
            text-align: center;
            display: inline-block;
            text-decoration: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn:hover {
            background-color: #2e7d32;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .record-separator {
            border-bottom: 1px solid #ddd;
            margin: 10px 0;
            list-style-type: none;
        }

        td ul {
            padding-left: 20px;
            margin: 0;
        }

        td li {
            margin-bottom: 5px;
        }

        .general-notes {
            margin-top: 20px;
            background-color: #c8e6c9;
            padding: 15px;
            border-radius: 8px;
        }

        .general-notes h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .general-notes p {
            font-size: 14px;
            color: #555;
        }
/* Sidebar Base Styles */
.sidebar {
    width: 250px;
    background: #1b5e20;
    min-height: 100vh;
    color: white;
    padding: 20px 0;
}

.sidebar-header {
    padding: 0 20px 10px;
    border-bottom: 1px solid #2e7d32;
}

.sidebar-header h2 {
    color: white;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
}

.nav-menu {
    list-style: none;
    padding: 0px 0;
    font-size: 18px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;

}

.nav-item {
    padding: 12px 20px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 18px;
    padding: 10px 20px;
    transition: all 0.3s ease;
    width:84%;
}

.nav-item a {
    color: white;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
}

.nav-item:hover {
    background: rgb(89, 146, 91);
    transition: background-color 0.3s ease;
    font-size: 18px;
    padding: 12px 20px;
    transform: scale(1.05);
    width: 82%;
}

.nav-item.active {
    background: #2e7d32;
}

.nav-item i {
    font-size: 18px;
    width: 20px;
    text-align: center;
}

/* Main content wrapper */
body {
    display: flex;
    background: #f0f2f5;
    padding: 0;
    margin: 0;
}

.container {
    flex: 1;
    margin: 20px;
    max-width: none;
}


        .download-container {
    display: flex;
    gap: 15px;
    margin: 20px 0;
    justify-content: flex-end;
}

.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
}

.modal-content {
    background-color: #fff;
    margin: 15% auto;
    padding: 20px;
    border-radius: 8px;
    width: 80%;
    max-width: 500px;
}

.close {
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    z-index: 1001;
}

.modal-form {
    margin-top: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.date-inputs {
    display: flex;
    gap: 10px;
    align-items: center;
    margin-top: 5px;
}

.date-input {
    padding: 8px;
    border: 1px solid #388e3c;
    border-radius: 4px;
}

#downloadFormat {
    width: 100%;
    padding: 8px;
    border: 1px solid #388e3c;
    border-radius: 4px;
    margin-top: 5px;
}
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>
<body>



  <!-- Add the sidebar -->
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
                <a href="cattle_records.html">
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


    
    <div class="container">
    <div id="downloadModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="document.getElementById('downloadModal').style.display = 'none';">&times;</span>
        <h2>Download Report</h2>
        <div class="modal-form">
            <div class="form-group">
                <label>Date Range:</label>
                <div class="date-inputs">
                    <input type="date" id="startDate" class="date-input">
                    <span>to</span>
                    <input type="date" id="endDate" class="date-input">
                </div>
            </div>
            <div class="form-group">
                <label>Select Format:</label>
                <select id="downloadFormat">
                    <option value="csv">CSV</option>
                    <option value="pdf">PDF</option>
                </select>
            </div>
            <button id="confirmDownload" class="btn">Download</button>
        </div>
    </div>
</div>
    
        <h1>Livestock Records</h1>
        <div class="download-container">
    <button id="downloadBtn" class="btn">Download Report</button>
    
</div>

        <div class="search-container">
            <form class="search-form">
                <div class="search-select">
                    <select id="livestock-select">
                        <option value="">Livestock</option>
                        <option value="cattle">Cattle</option>
                        <option value="sheep">Sheep</option>
                        <option value="goats">Goats</option>
                    </select>
                </div>
                
                <div class="search-select">
                    <select id="breed-select">
                        <option value="">Breed</option>
                        <option value="holstein">Holstein</option>
                        <option value="angus">Angus</option>
                        <option value="hereford">Hereford</option>
                    </select>
                </div>
                
                <div class="search-select">
                    <select id="class-select">
                        <option value="">Class</option>
                        <option value="dairy">Dairy</option>
                        <option value="beef">Beef</option>
                        <option value="dual">Dual Purpose</option>
                    </select>
                </div>
                
                <button type="submit" class="search-btn">Search</button>
            </form>
        </div>

        <div class="Livestock-record">
            <?php
            // Updated query to use cattle_id
            $query = "
                SELECT 
                    c.cattle_id,
                    c.rfid_tag,
                    c.images,
                    c.breed,
                    c.sex,
                    c.animal_type,
                    c.weight,
                    c.price,
                    c.other_health_notes
                FROM 
                    cattle c
                WHERE 
                    c.farmer_id = ?
                ORDER BY 
                    c.rfid_tag ASC";

            try {
                $stmt = $con->prepare($query);
                $stmt->bind_param("i", $_SESSION['farmer_id']);
                $stmt->execute();
                $result = $stmt->get_result();

                echo '<table id="LivestockTable">
                        <thead>
                            <tr>
                                <th>RFID Tag</th>
                                <th>Image</th>
                                <th>Breed</th>
                                <th>Gender</th>
                                <th>Type</th>
                                <th>Weight (kg)</th>
                                <th>Price (Ksh)</th>
                                <th>Vaccination Records</th>
                                <th>Treatment Records</th>
                                <th>Other Health Notes</th>
                            </tr>
                        </thead>
                        <tbody>';

                while ($cattle = $result->fetch_assoc()) {
                    // Fetch vaccination records using cattle_id
                    $vac_query = "SELECT vaccine_name, date_administered, batch_number 
                                FROM vaccination_records 
                                WHERE cattle_id = ?
                                ORDER BY date_administered DESC";
                    $vac_stmt = $con->prepare($vac_query);
                    $vac_stmt->bind_param("i", $cattle['cattle_id']);
                    $vac_stmt->execute();
                    $vac_result = $vac_stmt->get_result();

                    // Fetch treatment records using cattle_id
                    $treat_query = "SELECT illness, treatment, treatment_date, medication 
                                  FROM treatment_records 
                                  WHERE cattle_id = ?
                                  ORDER BY treatment_date DESC";
                    $treat_stmt = $con->prepare($treat_query);
                    $treat_stmt->bind_param("i", $cattle['cattle_id']);
                    $treat_stmt->execute();
                    $treat_result = $treat_stmt->get_result();

                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($cattle['rfid_tag']) . '</td>';
                    
                    // Handle multiple images
                    $images = explode(',', $cattle['images']);
                    echo '<td>';
                    foreach ($images as $image) {
                        if (!empty($image)) {
                            echo '<img src="' . htmlspecialchars($image) . '" alt="Cattle Image">';
                        }
                    }
                    echo '</td>';
                    
                    echo '<td>' . htmlspecialchars($cattle['breed']) . '</td>';
                    echo '<td>' . htmlspecialchars($cattle['sex']) . '</td>';
                    echo '<td>' . htmlspecialchars($cattle['animal_type']) . '</td>';
                    echo '<td>' . htmlspecialchars($cattle['weight']) . '</td>';
                    echo '<td>' . number_format($cattle['price']) . '</td>';
                    
                    // Display vaccination records
                    echo '<td><ul>';
                    if ($vac_result->num_rows > 0) {
                        while ($vac = $vac_result->fetch_assoc()) {
                            echo '<li>Vaccine: ' . htmlspecialchars($vac['vaccine_name']) . '</li>';
                            echo '<li>Date: ' . htmlspecialchars($vac['date_administered']) . '</li>';
                            echo '<li>Batch: ' . htmlspecialchars($vac['batch_number']) . '</li>';
                            echo '<li class="record-separator"></li>';
                        }
                    } else {
                        echo '<li>No vaccination records found</li>';
                    }
                    echo '</ul></td>';
                    
                    // Display treatment records
                    echo '<td><ul>';
                    if ($treat_result->num_rows > 0) {
                        while ($treat = $treat_result->fetch_assoc()) {
                            echo '<li>Illness: ' . htmlspecialchars($treat['illness']) . '</li>';
                            echo '<li>Treatment: ' . htmlspecialchars($treat['treatment']) . '</li>';
                            echo '<li>Date: ' . htmlspecialchars($treat['treatment_date']) . '</li>';
                            echo '<li>Medication: ' . htmlspecialchars($treat['medication']) . '</li>';
                            echo '<li class="record-separator"></li>';
                        }
                    } else {
                        echo '<li>No treatment records found</li>';
                    }
                    echo '</ul></td>';
                    
                    echo '<td>' . htmlspecialchars($cattle['other_health_notes']) . '</td>';
                    echo '</tr>';

                    $vac_stmt->close();
                    $treat_stmt->close();
                }

                echo '</tbody></table>';
                
                $stmt->close();

            } catch (Exception $e) {
                echo "Error: " . $e->getMessage();
            }

            $con->close();
            ?>

            <div class="general-notes">
                <h3>General Livestock Notes</h3>
                <p>All Livestock are regularly checked by veterinarians. Special care is taken to monitor the health of the injured Livestock, and their recovery process is closely monitored.</p>
            </div>

           
        </div>
    </div>

    <!-- Keep all the existing JavaScript code -->
    <script>
// Remove the old button event listeners and add these new ones
document.getElementById('downloadBtn').addEventListener('click', function() {
    document.getElementById('downloadFormat').value = 'csv';
    document.getElementById('downloadModal').style.display = 'block';
});

document.getElementById('downloadPdfBtn').addEventListener('click', function() {
    document.getElementById('downloadFormat').value = 'pdf';
    document.getElementById('downloadModal').style.display = 'block';
});

// Close modal when clicking the X
document.querySelector('.close').addEventListener('click', function() {
    document.getElementById('downloadModal').style.display = 'none';
});

// Close modal when clicking outside
window.addEventListener('click', function(event) {
    if (event.target == document.getElementById('downloadModal')) {
        document.getElementById('downloadModal').style.display = 'none';
    }
});

document.getElementById('confirmDownload').addEventListener('click', function() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    const format = document.getElementById('downloadFormat').value;
    
    if (!startDate || !endDate) {
        alert('Please select both start and end dates');
        return;
    }

    let table = document.getElementById('LivestockTable');
    
    if (format === 'csv') {
        // CSV download logic
        let rows = table.rows;
        let csvContent = "";
        
        for (let i = 0; i < rows.length; i++) {
            let cells = rows[i].cells;
            let rowData = [];
            for (let j = 0; j < cells.length; j++) {
                rowData.push(cells[j].innerText);
            }
            csvContent += rowData.join(",") + "\n";
        }

        let link = document.createElement('a');
        link.href = "data:text/csv;charset=utf-8," + encodeURI(csvContent);
        link.target = "_blank";
        link.download = `Livestock_records_${startDate}_to_${endDate}.csv`;
        link.click();
    } else {
        // PDF download logic
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        
        doc.text(`Livestock Records (${startDate} to ${endDate})`, 14, 10);
        doc.autoTable({ 
            html: '#LivestockTable',
            startY: 20,
            theme: 'striped'
        });

        doc.save(`Livestock_records_${startDate}_to_${endDate}.pdf`);
    }

    document.getElementById('downloadModal').style.display = 'none';
});
</script>
</body>
</html>