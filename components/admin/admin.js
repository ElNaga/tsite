// Admin Panel JavaScript Logic

// Sidebar navigation
const menuLinks = document.querySelectorAll('.admin-menu a');
const sections = {
    events: document.getElementById('section-events'),
    people: document.getElementById('section-people'),
    blog: document.getElementById('section-blog')
};

menuLinks.forEach(link => {
    link.addEventListener('click', function (e) {
        e.preventDefault();
        menuLinks.forEach(l => l.classList.remove('active'));
        this.classList.add('active');
        Object.values(sections).forEach(sec => sec.classList.remove('active'));

        if (this.getAttribute('href') === '#events') {
            sections.events.classList.add('active');
        } else if (this.getAttribute('href') === '#people') {
            sections.people.classList.add('active');
            loadPeople(); // Load people when switching to people section
        } else if (this.getAttribute('href') === '#blog') {
            sections.blog.classList.add('active');
            // Initialize blog section if not already initialized
            if (typeof window.initBlogSection === 'function') {
                window.initBlogSection();
            }
        }
    });
});

// Load and display events in the table
function renderEventsTable(events) {
    const tbody = document.querySelector('#section-events .admin-table tbody');
    tbody.innerHTML = '';

    if (!events.en.length) {
        tbody.innerHTML = '<tr><td colspan="5" style="text-align:center;color:#888;">No events found.</td></tr>';
        return;
    }

    for (let i = 0; i < events.en.length; i++) {
        const en = events.en[i] || {};
        const mk = events.mk[i] || {};
        const fr = events.fr[i] || {};

        tbody.innerHTML += `<tr data-id="${en.id}">
            <td>${en.id || ''}</td>
            <td>${en.title || ''}</td>
            <td>${mk.title || ''}</td>
            <td>${fr.title || ''}</td>
            <td>
                <button class="admin-btn edit-btn" style="padding:0.3rem 0.7rem;">Edit</button>
                <button class="admin-btn delete-btn btn-secondary" style="padding:0.3rem 0.7rem;">Delete</button>
            </td>
        </tr>`;
    }

    // Attach event listeners for edit/delete
    tbody.querySelectorAll('.edit-btn').forEach((btn, idx) => {
        btn.onclick = () => openEventModal(events, idx);
    });

    tbody.querySelectorAll('.delete-btn').forEach((btn, idx) => {
        btn.onclick = () => deleteEvent(events.en[idx].id);
    });
}

function loadEvents() {
    fetch('/admin_events.php')
        .then(r => r.json())
        .then(events => renderEventsTable(events))
        .catch(error => {
            console.error('Failed to load events:', error);
            alert('Failed to load events. Please refresh the page.');
        });
}

// Modal logic for Add/Edit Event
const eventModal = document.getElementById('event-modal');
const eventForm = document.getElementById('event-form');
let editingId = null;

function openEventModal(events = null, idx = null) {
    eventModal.classList.add('active');

    if (events && idx !== null) {
        // Editing
        editingId = events.en[idx].id;
        populateForm(events, idx);
    } else {
        // Adding
        editingId = null;
        eventForm.reset();
    }
}

function populateForm(events, idx) {
    const en = events.en[idx] || {};
    const mk = events.mk[idx] || {};
    const fr = events.fr[idx] || {};

    // English fields
    eventForm.title_en.value = en.title || '';
    eventForm.desc_en.value = en.desc || '';
    eventForm.book_label_en.value = en.book_label || '';
    eventForm.book_url_en.value = en.book_url || '';
    eventForm.image_en.value = en.image || '';
    eventForm.image_alt_en.value = en.image_alt || '';

    // Macedonian fields
    eventForm.title_mk.value = mk.title || '';
    eventForm.desc_mk.value = mk.desc || '';
    eventForm.book_label_mk.value = mk.book_label || '';
    eventForm.book_url_mk.value = mk.book_url || '';
    eventForm.image_mk.value = mk.image || '';
    eventForm.image_alt_mk.value = mk.image_alt || '';

    // French fields
    eventForm.title_fr.value = fr.title || '';
    eventForm.desc_fr.value = fr.desc || '';
    eventForm.book_label_fr.value = fr.book_label || '';
    eventForm.book_url_fr.value = fr.book_url || '';
    eventForm.image_fr.value = fr.image || '';
    eventForm.image_alt_fr.value = fr.image_alt || '';
}

function closeEventModal() {
    eventModal.classList.remove('active');
    eventForm.reset();
    editingId = null;
}

// Form submission
eventForm.onsubmit = function (e) {
    e.preventDefault();

    const data = {
        en: {
            title: eventForm.title_en.value,
            desc: eventForm.desc_en.value,
            book_label: eventForm.book_label_en.value,
            book_url: eventForm.book_url_en.value || '#',
            image: eventForm.image_en.value || '/assets/background-image.png',
            image_alt: eventForm.image_alt_en.value
        },
        mk: {
            title: eventForm.title_mk.value,
            desc: eventForm.desc_mk.value,
            book_label: eventForm.book_label_mk.value,
            book_url: eventForm.book_url_mk.value || '#',
            image: eventForm.image_mk.value || '/assets/background-image.png',
            image_alt: eventForm.image_alt_mk.value
        },
        fr: {
            title: eventForm.title_fr.value,
            desc: eventForm.desc_fr.value,
            book_label: eventForm.book_label_fr.value,
            book_url: eventForm.book_url_fr.value || '#',
            image: eventForm.image_fr.value || '/assets/background-image.png',
            image_alt: eventForm.image_alt_fr.value
        }
    };

    let method = 'POST';
    if (editingId) {
        data.id = editingId;
        method = 'PUT';
    }

    fetch('/admin_events.php', {
        method: method,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                closeEventModal();
                loadEvents();
            } else {
                alert('Failed to save event: ' + (res.error || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Save error:', error);
            alert('Failed to save event. Please try again.');
        });
};

function deleteEvent(id) {
    if (!confirm('Are you sure you want to delete this event?')) return;

    fetch('/admin_events.php', {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id })
    })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                loadEvents();
            } else {
                alert('Failed to delete event: ' + (res.error || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Delete error:', error);
            alert('Failed to delete event. Please try again.');
        });
}

// Event listeners
document.addEventListener('DOMContentLoaded', function () {
    loadEvents();
    loadPeople(); // Load people data when page loads

    // Add event button (only for events section)
    const eventsSection = document.getElementById('section-events');
    if (eventsSection) {
        const eventBtn = eventsSection.querySelector('.admin-header .admin-btn');
        if (eventBtn) {
            eventBtn.onclick = () => openEventModal();
        }
    }

    // Close modal on background click
    eventModal.onclick = function (e) {
        if (e.target === eventModal || e.target.classList.contains('btn-secondary')) {
            closeEventModal();
        }
    };

    // Add person button
    const addPersonBtn = document.getElementById('add-person-btn');
    if (addPersonBtn) {
        addPersonBtn.onclick = function () {
            openPeopleModal();
        };
    }

    // Close people modal on background click
    if (peopleModal) {
        peopleModal.onclick = function (e) {
            if (e.target === peopleModal || e.target.classList.contains('btn-secondary')) {
                closePeopleModal();
            }
        };
    }

    // Close modal on escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && eventModal.classList.contains('active')) {
            closeEventModal();
        }
        if (e.key === 'Escape' && peopleModal.classList.contains('active')) {
            closePeopleModal();
        }
    });
});

// ===== PEOPLE MANAGEMENT =====

// Load and display people in the table
function renderPeopleTable(people) {
    console.log('renderPeopleTable called with:', people);
    const tbody = document.querySelector('#section-people .admin-table tbody');
    console.log('Found tbody element:', tbody);
    tbody.innerHTML = '';

    if (!people || !people.length) {
        console.log('No people found, showing empty message');
        tbody.innerHTML = '<tr><td colspan="8" style="text-align:center;color:#888;">No people found.</td></tr>';
        return;
    }

    // People are now grouped by display_order, each person has en/mk/fr properties
    people.forEach((person, index) => {
        const en = person.en || {};
        const mk = person.mk || {};
        const fr = person.fr || {};

        tbody.innerHTML += `<tr data-id="${en.id || mk.id || fr.id}" data-display-order="${person.display_order}">
            <td>${en.id || mk.id || fr.id || ''}</td>
            <td>${en.name || ''}</td>
            <td>${mk.name || ''}</td>
            <td>${fr.name || ''}</td>
            <td>${en.title || mk.title || fr.title || ''}</td>
            <td>${person.is_visible ? 'Yes' : 'No'}</td>
            <td>${person.display_order || 0}</td>
            <td>
                <button class="admin-btn move-up-btn" style="padding:0.2rem 0.4rem;" ${index === 0 ? 'disabled' : ''}>↑</button>
                <button class="admin-btn move-down-btn" style="padding:0.2rem 0.4rem;" ${index === people.length - 1 ? 'disabled' : ''}>↓</button>
            </td>
            <td>
                <button class="admin-btn edit-people-btn" style="padding:0.3rem 0.7rem;">Edit</button>
                <button class="admin-btn delete-people-btn btn-secondary" style="padding:0.3rem 0.7rem;">Delete</button>
            </td>
        </tr>`;
    });

    // Attach event listeners for edit/delete/move
    tbody.querySelectorAll('.edit-people-btn').forEach((btn, idx) => {
        btn.onclick = () => {
            console.log('Edit button clicked for index:', idx);
            console.log('Person data:', people[idx]);
            openPeopleModal(people, idx);
        };
    });

    tbody.querySelectorAll('.delete-people-btn').forEach((btn, idx) => {
        btn.onclick = () => {
            const person = people[idx];
            const personId = person.en?.id || person.mk?.id || person.fr?.id;
            deletePerson(personId);
        };
    });

    tbody.querySelectorAll('.move-up-btn').forEach((btn, idx) => {
        btn.onclick = () => {
            if (idx > 0) {
                movePerson(people, idx, idx - 1);
            }
        };
    });

    tbody.querySelectorAll('.move-down-btn').forEach((btn, idx) => {
        btn.onclick = () => {
            if (idx < people.length - 1) {
                movePerson(people, idx, idx + 1);
            }
        };
    });
}

function loadPeople() {
    console.log('Loading people...');
    fetch('/admin_people.php')
        .then(r => {
            console.log('Response status:', r.status);
            if (!r.ok) {
                throw new Error(`HTTP ${r.status}: ${r.statusText}`);
            }
            return r.json();
        })
        .then(people => {
            console.log('People data received:', people);
            console.log('Total people count:', people ? people.length : 0);
            renderPeopleTable(people);
        })
        .catch(error => {
            console.error('Failed to load people:', error);
            alert('Failed to load people: ' + error.message + '. Please make sure you are logged in as admin.');
        });
}

// People Modal logic
const peopleModal = document.getElementById('people-modal');
const peopleForm = document.getElementById('people-form');
let editingPersonId = null;

function openPeopleModal(people = null, idx = null) {
    if (!peopleModal) {
        console.error('People modal not found!');
        return;
    }

    peopleModal.classList.add('active');

    if (people && idx !== null) {
        // Editing
        const person = people[idx];
        editingPersonId = person.en?.id || person.mk?.id || person.fr?.id;
        populatePeopleForm(people, idx);
    } else {
        // Adding
        editingPersonId = null;
        if (peopleForm) {
            peopleForm.reset();
        }
    }
}

function populatePeopleForm(people, idx) {
    console.log('=== POPULATE FORM DEBUG ===');
    console.log('people:', people);
    console.log('idx:', idx);

    const person = people[idx];
    const en = person.en || {};
    const mk = person.mk || {};
    const fr = person.fr || {};

    console.log('en:', en);
    console.log('mk:', mk);
    console.log('fr:', fr);

    // English fields
    peopleForm.name_en.value = en.name || '';
    peopleForm.title_en.value = en.title || '';
    peopleForm.description_en.value = en.description || '';

    // Macedonian fields
    peopleForm.name_mk.value = mk.name || '';
    peopleForm.title_mk.value = mk.title || '';
    peopleForm.description_mk.value = mk.description || '';

    // French fields
    peopleForm.name_fr.value = fr.name || '';
    peopleForm.title_fr.value = fr.title || '';
    peopleForm.description_fr.value = fr.description || '';

    // Common fields (display_order is read-only, auto-assigned)
    peopleForm.is_visible.checked = person.is_visible !== false;

    console.log('Form populated. name_en.value:', peopleForm.name_en.value);
}

function closePeopleModal() {
    if (peopleModal) {
        peopleModal.classList.remove('active');
    }
    if (peopleForm) {
        peopleForm.reset();
    }
    editingPersonId = null;
}

// People form submission
peopleForm.onsubmit = function (e) {
    e.preventDefault();

    const formData = new FormData();

    // Add language data
    formData.append("en", JSON.stringify({
        name: peopleForm.name_en.value,
        title: peopleForm.title_en.value,
        description: peopleForm.description_en.value
    }));

    console.log('Form data after appending en:', formData.en);
    console.log('Form data after appending mk:', formData.mk);
    console.log('Form data after appending fr:', formData.fr);


    formData.append("mk", JSON.stringify({
        name: peopleForm.name_mk.value,
        title: peopleForm.title_mk.value,
        description: peopleForm.description_mk.value
    }));
    formData.append("fr", JSON.stringify({
        name: peopleForm.name_fr.value,
        title: peopleForm.title_fr.value,
        description: peopleForm.description_fr.value
    }));

    // Other fields (display_order is auto-assigned)
    formData.append("is_visible", peopleForm.is_visible.checked ? "1" : "0");

    // Add image if selected
    if (peopleForm.profile_image.files.length > 0) {
        formData.append("profile_image", peopleForm.profile_image.files[0]);
    }

    // Debug formData content
    console.log("=== FORM DATA DUMP ===");
    for (let [key, value] of formData.entries()) {
        console.log(key, value);
    }

    let url = "/admin_people.php";
    let method = "POST";

    if (editingPersonId) {
        // either backend must handle _method override OR switch to PUT
        formData.append("_method", "PUT");
        formData.append("id", editingPersonId);
        // If backend accepts real PUT, then do:
        // method = "PUT";
    }

    fetch(url, {
        method,
        body: formData
    })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                closePeopleModal();
                loadPeople();
            } else {
                alert("Failed to save person: " + (res.error || "Unknown error"));
            }
        })
        .catch(error => {
            console.error("Save error:", error);
            alert("Failed to save person. Please try again.");
        });
};


function movePerson(people, fromIndex, toIndex) {
    const person1 = people[fromIndex];
    const person2 = people[toIndex];

    // Get IDs from any language version
    const person1Id = person1.en?.id || person1.mk?.id || person1.fr?.id;
    const person2Id = person2.en?.id || person2.mk?.id || person2.fr?.id;

    console.log('=== MOVE PERSON DEBUG ===');
    console.log('fromIndex:', fromIndex, 'toIndex:', toIndex);
    console.log('person1:', person1);
    console.log('person2:', person2);
    console.log('person1Id:', person1Id);
    console.log('person2Id:', person2Id);

    if (!person1Id || !person2Id) {
        alert('Error: Could not find person IDs for reordering');
        return;
    }

    const requestData = {
        person1_id: person1Id,
        person2_id: person2Id
    };

    console.log('Sending PATCH request with data:', requestData);

    // Send reorder request (using POST with method override since PATCH might not be supported)
    fetch('/admin_people.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            _method: 'PATCH',
            ...requestData
        })
    })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                loadPeople(); // Reload the table
            } else {
                alert('Failed to reorder: ' + (res.error || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Reorder error:', error);
            alert('Failed to reorder people. Please try again.');
        });
}

function deletePerson(id) {
    if (!confirm('Are you sure you want to delete this person?')) return;

    fetch('/admin_people.php', {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id })
    })
        .then(r => r.json())
        .then(res => {
            if (res.success) {
                loadPeople();
            } else {
                alert('Failed to delete person: ' + (res.error || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Delete error:', error);
            alert('Failed to delete person. Please try again.');
        });
}

// People button and modal setup (moved to main DOMContentLoaded)