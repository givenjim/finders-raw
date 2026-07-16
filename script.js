// Mock Data for Workers [cite: 188]
const workers = [
    { name: "John Mwangi", skill: "Plumber", loc: "Nakuru", rating: "4.7/5", contact: "0712 345 678" },
    { name: "Mary Atieno", skill: "Nanny", loc: "Nairobi", rating: "4.9/5", contact: "0722 111 222" },
    { name: "Peter Kamau", skill: "Electrician", loc: "Kiambu", rating: "4.5/5", contact: "0733 444 555" }
];

function showSection(sectionId) {
    document.getElementById('home').style.display = 'none';
    document.getElementById('dashboard').style.display = 'none';
    document.getElementById(sectionId).style.display = sectionId === 'dashboard' ? 'grid' : 'block';
}

function login(role) {
    alert("Logging in as " + role + "...");
    document.getElementById('logout-link').style.display = 'block';
    showSection('dashboard');
    document.getElementById('view-title').innerText = role + " Dashboard";
}

function logout() {
    if (confirm("Are you sure you want to log out? [cite: 175]")) {
        document.getElementById('logout-link').style.display = 'none';
        showSection('home');
    }
}

function filterWorkers(category) {
    const displayArea = document.getElementById('display-area');
    document.getElementById('view-title').innerText = category + " Listings";
    
    // Filter logic [cite: 125]
    const filtered = workers.filter(w => w.skill === category || category === 'All');
    
    if (filtered.length === 0) {
        displayArea.innerHTML = `<p>No ${category}s found in your area.</p>`;
        return;
    }

    displayArea.innerHTML = filtered.map(w => `
        <div class="worker-card">
            <h4>${w.name}</h4>
            <p><strong>Location:</strong> ${w.loc}</p>
            <p><strong>Rating:</strong> ${w.rating}</p>
            <p><strong>Contact:</strong> ${w.contact}</p>
            <button onclick="alert('Message sent to ${w.name}')" style="font-size: 0.8rem;">Send Message</button>
        </div>
    `).join('');
}