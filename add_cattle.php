<?php
// Include database connection
include('includes/connect.php');

// Start session to access farmer_id
session_start();

// Check if farmer is logged in
if (!isset($_SESSION['farmer_id'])) {
    // Redirect to login page with a message
    $_SESSION['error_message'] = "Please log in to add cattle.";
    header("Location: login.php");
    exit();
}

$farmer_id = $_SESSION['farmer_id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect cattle data
    $rfid_tag = $_POST['rfid'];
    $breed = $_POST['breed'];
    $sex = $_POST['sex'];
    $animal_type = $_POST['animal-type'];
    $weight = $_POST['weight'];
    $price = $_POST['price'];
    $other_health_notes = $_POST['other-health-notes'];

    // Handle image uploads
    $image_paths = [];
    if (!empty($_FILES['images']['name'][0])) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            $file_name = basename($_FILES['images']['name'][$key]);
            $file_path = $upload_dir . $file_name;
            if (move_uploaded_file($tmp_name, $file_path)) {
                $image_paths[] = $file_path;
            }
        }
    }
    $images = implode(',', $image_paths);

    // Check if the rfid_tag already exists
    $check_stmt = $con->prepare("SELECT COUNT(*) FROM cattle WHERE rfid_tag = ?");
    $check_stmt->bind_param("s", $rfid_tag);
    $check_stmt->execute();
    $check_stmt->bind_result($count);
    $check_stmt->fetch();
    $check_stmt->close(); // Close the check statement

    if ($count > 0) {
        echo "Error: Cattle with this RFID tag already exists!";
    } else {
        // Insert cattle data into the database
        $stmt = $con->prepare("INSERT INTO cattle (farmer_id, rfid_tag, breed, sex, animal_type, weight, price, images, other_health_notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssdsss", $farmer_id, $rfid_tag, $breed, $sex, $animal_type, $weight, $price, $images, $other_health_notes);

        if ($stmt->execute()) {
            $cattle_id = $stmt->insert_id; // Get the last inserted cattle_id
            $stmt->close(); // Close the cattle insert statement

            // Insert vaccination records
            if (isset($_POST['vaccine-name'])) {
                for ($i = 0; $i < count($_POST['vaccine-name']); $i++) {
                    $vaccine_name = $_POST['vaccine-name'][$i];
                    $vaccine_date = $_POST['vaccine-date'][$i];
                    $batch_number = $_POST['batch-number'][$i];

                    $vaccination_stmt = $con->prepare("INSERT INTO vaccination_records (cattle_id, vaccine_name, date_administered, batch_number) VALUES (?, ?, ?, ?)");
                    $vaccination_stmt->bind_param("isss", $cattle_id, $vaccine_name, $vaccine_date, $batch_number);
                    $vaccination_stmt->execute();
                    $vaccination_stmt->close(); // Close the vaccination statement
                }
            }

            // Insert treatment records
            if (isset($_POST['illness'])) {
                for ($i = 0; $i < count($_POST['illness']); $i++) {
                    $illness = $_POST['illness'][$i];
                    $treatment = $_POST['treatment'][$i];
                    $treatment_date = $_POST['treatment-date'][$i];
                    $medication = $_POST['medication'][$i];

                    $treatment_stmt = $con->prepare("INSERT INTO treatment_records (cattle_id, illness, treatment, treatment_date, medication) VALUES (?, ?, ?, ?, ?)");
                    $treatment_stmt->bind_param("issss", $cattle_id, $illness, $treatment, $treatment_date, $medication);
                    $treatment_stmt->execute();
                    $treatment_stmt->close(); // Close the treatment statement
                }
            }

            echo "Cattle information added successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    // Redirect to index.php or another page if successful
    header("Location: index.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Cattle</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            padding: 20px;
            margin: 0;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: 0 auto;
        }
        .form-container h2, .form-container h3 {
            margin-bottom: 20px;
            text-align: center;
            color: #333;
        }
        .form-container label {
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
            color: #555;
        }
        .form-container input, .form-container select, .form-container textarea {
            width: calc(100% - 24px); /* Adjust width accounting for padding */
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-size: 16px;
            transition: border-color 0.3s ease;
            box-sizing: border-box; /* Include padding in width calculation */
        }
        .form-container input:focus, .form-container select:focus, .form-container textarea:focus {
            border-color: #4caf50;
            outline: none;
        }
        .form-container button {
            background-color: #4caf50;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            margin: 10px 0;
            box-sizing: border-box;
        }
        .form-container button:hover {
            background-color: #45a049;
        }
        .record-section {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 6px;
            box-sizing: border-box;
        }
        .record-entry {
            background: #f8f9fa;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 6px;
            box-sizing: border-box;
        }
        .record-entry input {
            width: calc(100% - 24px);
            margin-bottom: 15px;
            box-sizing: border-box;
        }
        .add-record-btn {
            background-color: #007bff;
            margin-bottom: 20px;
            width: 100%;
            box-sizing: border-box;
        }
        .add-record-btn:hover {
            background-color: #0056b3;
        }
        /* Form grid for better alignment */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
        }
        @media (max-width: 768px) {
            .form-container {
                padding: 15px;
            }
            .form-container button {
                font-size: 14px;
            }
            .record-section {
                padding: 15px;
            }
            .record-entry {
                padding: 10px;
            }
        }

          /* Add these new styles for the popup */
          .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .popup-content {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            z-index: 1001;
        }

        .popup-buttons {
            margin-top: 20px;
        }

        .popup-button {
            padding: 10px 20px;
            margin: 0 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .close-button {
            background-color: #6c757d;
            color: white;
        }

        .add-new-button {
            background-color: #4caf50;
            color: white;
        }
    </style>>
</head>
<body>

<div class="popup-overlay" id="successPopup">
        <div class="popup-content">
            <h3>Success!</h3>
            <p>Livestock has been added successfully</p>
            <div class="popup-buttons">
                <button class="popup-button close-button" onclick="closePopup()">Close</button>
                <button class="popup-button add-new-button" onclick="addNewLivestock()">Add Another Livestock</button>
            </div>
        </div>
    </div>
    <div class="form-container">
        <h2>Add New Cattle</h2>
        <form action="" method="POST" enctype="multipart/form-data" class="form-grid">
       
            <label for="rfid">RFID Tag</label>
            <input type="text" id="rfid" name="rfid" required>
            
            <label for="breed">Breed</label>
            <select id="breed" name="breed" required>
                <option value="holstein">Holstein</option>
                <option value="jersey">Jersey</option>
                <option value="angus">Angus</option>
                <option value="brahman">Brahman</option>
                <option value="charolais">Charolais</option>
                <option value="guernsey">Guernsey</option>
                <option value="hereford">Hereford</option>
                <option value="simmental">Simmental</option>
                <option value="limousin">Limousin</option>
                <option value="sahiwal">Sahiwal</option>
            </select>

            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" required>
            
            <label for="sex">Sex</label>
            <select id="sex" name="sex" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            
            <label for="animal-type">Type of Animal</label>
            <select id="animal-type" name="animal-type" required>
                <option value="cow">Cow</option>
                <option value="bull">Bull</option>
                <option value="heifer">Heifer</option>
            </select>
            
            <label for="weight">Weight (kg)</label>
            <input type="number" id="weight" name="weight" required>
            
            <label for="price">Price (Ksh)</label>
            <input type="number" id="price" name="price" required>
            
            <label for="images">Upload Images</label>
            <input type="file" id="images" name="images[]" accept="image/*" multiple>

            <!-- Vaccination Records Section -->
            <div class="record-section" id="vaccination-records-section">
                <h3>Vaccination Records</h3>
                <div id="vaccination-entries"></div>
                <button type="button" class="add-record-btn" onclick="addVaccinationRecord()">Add Vaccination Record</button>
            </div>

            <!-- Treatment Records Section -->
            <div class="record-section" id="treatment-records-section">
                <h3>Treatment Records</h3>
                <div id="treatment-entries"></div>
                <button type="button" class="add-record-btn" onclick="addTreatmentRecord()">Add Treatment Record</button>
            </div>

            <label for="other-health-notes">Other Health Notes</label>
            <textarea id="other-health-notes" name="other-health-notes" rows="4"></textarea>

            <button type="submit">Add Cattle</button>
        </form>
    </div>

    <script>
        let vaccinationCounter = 0;
        let treatmentCounter = 0;

        function addVaccinationRecord() {
            const container = document.getElementById('vaccination-entries');
            const recordDiv = document.createElement('div');
            recordDiv.className = 'record-entry';
            recordDiv.innerHTML = `
                <label for="vaccine-name-${vaccinationCounter}">Vaccine Name</label>
                <input type="text" id="vaccine-name-${vaccinationCounter}" name="vaccine-name[]" required>
                
                <label for="vaccine-date-${vaccinationCounter}">Date Administered</label>
                <input type="date" id="vaccine-date-${vaccinationCounter}" name="vaccine-date[]" required>
                
                <label for="batch-number-${vaccinationCounter}">Batch Number</label>
                <input type="text" id="batch-number-${vaccinationCounter}" name="batch-number[]" required>
            `;
            container.appendChild(recordDiv);
            vaccinationCounter++;
        }

        function addTreatmentRecord() {
            const container = document.getElementById('treatment-entries');
            const recordDiv = document.createElement('div');
            recordDiv.className = 'record-entry';
            recordDiv.innerHTML = `
                <label for="illness-${treatmentCounter}">Illness/Condition</label>
                <input type="text" id="illness-${treatmentCounter}" name="illness[]" required>
                
                <label for="treatment-${treatmentCounter}">Treatment Administered</label>
                <input type="text" id="treatment-${treatmentCounter}" name="treatment[]" required>
                
                <label for="treatment-date-${treatmentCounter}">Date of Treatment</label>
                <input type="date" id="treatment-date-${treatmentCounter}" name="treatment-date[]" required>
                
                <label for="medication-${treatmentCounter}">Medication/Dosage</label>
                <input type="text" id="medication-${treatmentCounter}" name="medication[]" required>
            `;
            container.appendChild(recordDiv);
            treatmentCounter++;
        }

        // Add initial record entries
        addVaccinationRecord();
        addTreatmentRecord();
    </script>

    
    <script>
        // [Previous JavaScript code for vaccination and treatment records remains the same]

        // Add these new functions for handling the popup
        function showPopup() {
            document.getElementById('successPopup').style.display = 'block';
        }

        function closePopup() {
            document.getElementById('successPopup').style.display = 'none';
            window.location.href = 'index.php';
        }

        function addNewLivestock() {
            document.getElementById('successPopup').style.display = 'none';
            document.querySelector('form').reset();
            // Clear vaccination and treatment entries
            document.getElementById('vaccination-entries').innerHTML = '';
            document.getElementById('treatment-entries').innerHTML = '';
            // Add initial records
            addVaccinationRecord();
            addTreatmentRecord();
        }

        // Update form submission to handle the popup
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch('', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showPopup();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while submitting the form');
            });
        });
    </script>
</body>
</html>   
