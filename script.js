// Mock data
const cattleData = [
    {
        id: 1,
        rfidTag: "RF001",
        breed: "Holstein",
        dateOfBirth: "2022-01-15",
        sex: "Female",
        type: "Cow",
        weight: "600 kg",
        image: "/placeholder.svg",
        price: "$2,000",
        healthStatus: "Healthy",
        vaccinations: [
            {
                name: "BVD",
                date: "2023-06-15",
                batchNumber: "BVD123"
            }
        ],
        treatments: [
            {
                illness: "Mastitis",
                treatment: "Antibiotics",
                date: "2023-05-20",
                medication: "Penicillin 10mg/dose"
            }
        ],
        healthNotes: "Regular checkups show good health"
    },
    // Add more cattle data as needed
];

// Initialize the page
document.addEventListener('DOMContentLoaded', () => {
    renderCattleList();
    initializeModal();
    initializeTabs();
});

// Render cattle list
function renderCattleList() {
    const animalList = document.querySelector('.animal-list');
    
    cattleData.forEach(cattle => {
        const card = createCattleCard(cattle);
        animalList.appendChild(card);
    });
}

// Create cattle card
function createCattleCard(cattle) {
    const card = document.createElement('div');
    card.className = 'animal-card';
    card.innerHTML = `
        <img src="${cattle.image}" alt="${cattle.breed} ${cattle.type}">
        <div class="animal-info">
            <h3>RFID: ${cattle.rfidTag}</h3>
            <span class="status-badge status-${cattle.healthStatus.toLowerCase()}">${cattle.healthStatus}</span>
            <p>Breed: ${cattle.breed}</p>
            <p>Type: ${cattle.type}</p>
            <button class="view-more-btn" data-id="${cattle.id}">View More</button>
        </div>
    `;
    
    card.querySelector('.view-more-btn').addEventListener('click', () => showModal(cattle));
    return card;
}

// Modal functionality
function initializeModal() {
    const modal = document.getElementById('animalModal');
    const closeBtn = modal.querySelector('.close');
    
    closeBtn.onclick = () => modal.style.display = "none";
    window.onclick = (event) => {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
}

// Show modal with cattle details
function showModal(cattle) {
    const modal = document.getElementById('animalModal');
    
    // Update modal content
    document.getElementById('modalImage').src = cattle.image;
    document.getElementById('modalRfid').textContent = cattle.rfidTag;
    document.getElementById('modalBreed').textContent = cattle.breed;
    document.getElementById('modalDob').textContent = cattle.dateOfBirth;
    document.getElementById('modalSex').textContent = cattle.sex;
    document.getElementById('modalType').textContent = cattle.type;
    document.getElementById('modalWeight').textContent = cattle.weight;
    document.getElementById('modalPrice').textContent = cattle.price;
    document.getElementById('modalHealthStatus').textContent = cattle.healthStatus;
    
    // Update vaccinations
    const vaccinationsList = document.getElementById('vaccinationsList');
    vaccinationsList.innerHTML = cattle.vaccinations.map(vac => `
        <tr>
            <td>${vac.name}</td>
            <td>${vac.date}</td>
            <td>${vac.batchNumber}</td>
        </tr>
    `).join('');
    
    // Update treatments
    const treatmentsList = document.getElementById('treatmentsList');
    treatmentsList.innerHTML = cattle.treatments.map(treatment => `
        <tr>
            <td>${treatment.illness}</td>
            <td>${treatment.treatment}</td>
            <td>${treatment.date}</td>
            <td>${treatment.medication}</td>
        </tr>
    `).join('');
    
    // Update health notes
    document.getElementById('healthNotes').textContent = cattle.healthNotes;
    
    modal.style.display = "block";
}

// Initialize tabs
function initializeTabs() {
    const tabs = document.querySelectorAll('.tab-btn');
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            // Remove active class from all tabs and contents
            tabs.forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // Add active class to clicked tab and corresponding content
            tab.classList.add('active');
            const contentId = tab.getAttribute('data-tab');
            document.getElementById(contentId).classList.add('active');
        });
    });
}