// Admin Panel JavaScript Logic

// Sidebar navigation
const menuLinks = document.querySelectorAll('.admin-menu a');
const sections = {
    events: document.getElementById('section-events'),
    people: document.getElementById('section-people')
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

    // Add event button
    document.querySelector('.admin-header .admin-btn').onclick = () => openEventModal();

    // Close modal on background click
    eventModal.onclick = function (e) {
        if (e.target === eventModal || e.target.classList.contains('btn-secondary')) {
            closeEventModal();
        }
    };

    // Close modal on escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && eventModal.classList.contains('active')) {
            closeEventModal();
        }
    });
}); 