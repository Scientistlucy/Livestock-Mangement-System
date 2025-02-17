<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Animal Information</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #f0f2f5;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #1b5e20;
            margin-bottom: 30px;
        }

        .form-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 16px;
            margin-bottom: 8px;
            color: #333;
        }

        input[type="text"], select, input[type="date"], input[type="number"], textarea {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-size: 16px;
            width: 100%;
        }

        input[type="text"]:focus, select:focus, input[type="date"]:focus, textarea:focus {
            border-color: #4caf50;
            outline: none;
        }

        button {
            padding: 12px 20px;
            background: #4caf50;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        button:hover {
            background: #45a049;
        }

        button:focus {
            outline: none;
        }

        .form-container .readonly {
            background-color: #f5f5f5;
            cursor: not-allowed;
        }

        .record-section {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 6px;
            box-sizing: border-box;
        }

        .add-record-btn {
        background-color: #4caf50; /* Match the color of the Save button */
        margin-bottom: 20px;
        width: 100%;
        box-sizing: border-box;
        padding: 12px 20px;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .add-record-btn:hover {
        background-color: #45a049; /* Match the hover effect of the Save button */
    }

    .add-record-btn:focus {
        outline: none;
    }
    </style>
</head>
<body>
    <h1>Edit Animal Information</h1>
    <div class="form-container">
        <form>
            <label for="rfid">RFID:</label>
            <input type="text" id="rfid" name="rfid" readonly class="readonly"><br>

            <label for="breed">Breed:</label>
            <input type="text" id="breed" name="breed"><br>

            <label for="type">Type:</label>
            <select id="type" name="type" required>
                <option value="cow">Cow</option>
                <option value="bull">Bull</option>
                <option value="heifer">Heifer</option>
            </select><br>

            <label for="age">Age:</label>
            <input type="text" id="age" name="age"><br>

            <label for="weight">Weight (kg):</label>
            <input type="number" id="weight" name="weight" required><br>
            <label for="health">Health:</label>
            <select id="health" name="health" required>
                <option value="healthy">Healthy</option>
                <option value="sick">Sick</option>
                <option value="recovering">Recovering</option>
                <option value="not-checked">Not Checked</option>
            </select><br>
            

            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required><br>

            <label for="sex">Sex:</label>
            <select id="sex" name="sex" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select><br>

            <label for="animal-type">Type of Animal:</label>
            <select id="animal-type" name="animal-type" required>
                <option value="cow">Cow</option>
                <option value="bull">Bull</option>
                <option value="heifer">Heifer</option>
            </select><br>

            <label for="weight">Weight (kg):</label>
            <input type="number" id="weight" name="weight" required><br>

            <label for="price">Price (Ksh):</label>
            <input type="number" id="price" name="price" required><br>

            <label for="images">Upload Images:</label>
            <input type="file" id="images" name="images" accept="image/*" multiple><br>
            
            <label for="image-description">Image Description:</label>
            <input type="text" id="image-description" name="image-description" placeholder="Enter description for the uploaded images"><br>
            

            <div class="record-section" id="vaccination-records-section">
                <h3>Vaccination Records</h3>
                <div id="vaccination-entries"></div>
                <button type="button" class="add-record-btn" onclick="addVaccinationRecord()">Update Vaccination Record</button>
            </div>

            <div class="record-section" id="treatment-records-section">
                <h3>Treatment Records</h3>
                <div id="treatment-entries"></div>
                <button type="button" class="add-record-btn" onclick="addTreatmentRecord()">Update Treatment Record</button>
            </div>

            <label for="other-health-notes">Other Health Notes</label>
            <textarea id="other-health-notes" name="other-health-notes" rows="4"></textarea><br>

            <button type="button" onclick="redirectToIndex()">Save</button>
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
                <input type="text" id="vaccine-name-${vaccinationCounter}" name="vaccine-name-${vaccinationCounter}" required>
                
                <label for="vaccine-date-${vaccinationCounter}">Date Administered</label>
                <input type="date" id="vaccine-date-${vaccinationCounter}" name="vaccine-date-${vaccinationCounter}" required>
                
                <label for="batch-number-${vaccinationCounter}">Batch Number</label>
                <input type="text" id="batch-number-${vaccinationCounter}" name="batch-number-${vaccinationCounter}" required>
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
                <input type="text" id="illness-${treatmentCounter}" name="illness-${treatmentCounter}" required>
                
                <label for="treatment-date-${treatmentCounter}">Date of Treatment</label>
                <input type="date" id="treatment-date-${treatmentCounter}" name="treatment-date-${treatmentCounter}" required>
                
                <label for="treatment-details-${treatmentCounter}">Treatment Details</label>
                <textarea id="treatment-details-${treatmentCounter}" name="treatment-details-${treatmentCounter}" required></textarea>
            `;
            container.appendChild(recordDiv);
            treatmentCounter++;
        }

        function redirectToIndex() {
            window.location.href = "index.html";
        }

        function getQueryParams() {
            const urlParams = new URLSearchParams(window.location.search);
            return {
                rfid: urlParams.get('rfid'),
                breed: urlParams.get('breed'),
                type: urlParams.get('type'),
                age: urlParams.get('age'),
                weight: urlParams.get('weight'),
                health: urlParams.get('health')
            };
        }

        window.onload = function() {
            const params = getQueryParams();
            document.getElementById('rfid').value = params.rfid;
            document.getElementById('breed').value = params.breed;
            document.getElementById('type').value = params.type;
            document.getElementById('age').value = params.age;
            document.getElementById('weight').value = params.weight;
            document.getElementById('health').value = params.health;
        };
    </script>
</body>
</html>
