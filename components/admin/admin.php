<?php
// Enhanced Admin Panel Layout with dynamic content switching
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f6fa; }
        .admin-layout { display: flex; height: 100vh; }
        .admin-sidebar {
            width: 220px;
            background: #1E2C74;
            color: #fff;
            display: flex;
            flex-direction: column;
            padding: 0;
            box-shadow: 2px 0 8px rgba(30,44,116,0.08);
        }
        .admin-sidebar h2 {
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
            padding: 1.5rem 1rem 1rem 1.5rem;
            letter-spacing: 1px;
        }
        .admin-menu {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            padding: 0 1rem;
        }
        .admin-menu a {
            color: #fff;
            text-decoration: none;
            padding: 0.7rem 1rem;
            border-radius: 6px;
            font-size: 1.1rem;
            transition: background 0.2s;
        }
        .admin-menu a.active, .admin-menu a:hover {
            background: #d7263d;
        }
        .admin-content {
            flex: 1;
            padding: 2rem 2.5rem;
            background: #fff;
            min-width: 0;
            overflow-y: auto;
        }
        .admin-section { display: none; }
        .admin-section.active { display: block; }
        .admin-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; }
        .admin-header h1 { margin: 0; font-size: 2rem; color: #1E2C74; }
        .admin-btn { background: #d7263d; color: #fff; border: none; border-radius: 6px; padding: 0.6rem 1.2rem; font-size: 1rem; font-weight: 600; cursor: pointer; transition: background 0.2s; }
        .admin-btn:hover { background: #b71c2a; }
        .admin-table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        .admin-table th, .admin-table td { border: 1px solid #eee; padding: 0.7rem 1rem; text-align: left; }
        .admin-table th { background: #f4f6fa; color: #1E2C74; }
    </style>
</head>
<body>
<div class="admin-layout">
    <aside class="admin-sidebar">
        <h2>Admin Panel</h2>
        <nav class="admin-menu">
            <a href="#events" class="active">Events</a>
            <a href="#people">People of TZT</a>
        </nav>
    </aside>
    <main class="admin-content">
        <section id="section-events" class="admin-section active">
            <div class="admin-header">
                <h1>Events</h1>
                <button class="admin-btn" onclick="alert('Add Event form coming soon!')">Add New Event</button>
            </div>
            <table class="admin-table">
                <thead>
                    <tr><th>ID</th><th>Title (EN)</th><th>Title (MK)</th><th>Title (FR)</th><th>Actions</th></tr>
                </thead>
                <tbody>
                    <tr><td>1</td><td>Sample EN</td><td>Sample MK</td><td>Sample FR</td><td><button class="admin-btn" style="padding:0.3rem 0.7rem;">Edit</button> <button class="admin-btn" style="padding:0.3rem 0.7rem;background:#888;">Delete</button></td></tr>
                </tbody>
            </table>
        </section>
        <section id="section-people" class="admin-section">
            <div class="admin-header">
                <h1>People of TZT</h1>
                <button class="admin-btn" onclick="alert('Add Person form coming soon!')">Add New Person</button>
            </div>
            <p>Manage organization members here.</p>
        </section>
    </main>
</div>
<!-- Event Modal (hidden by default) -->
<div id="event-modal" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(30,44,116,0.18);z-index:1000;align-items:center;justify-content:center;">
  <div style="background:#fff;padding:2rem 2.5rem;border-radius:12px;box-shadow:0 4px 32px rgba(30,44,116,0.18);min-width:340px;max-width:90vw;">
    <h2 style="margin-top:0;color:#1E2C74;">Add/Edit Event</h2>
    <form id="event-form">
      <div style="display:flex;gap:1.2rem;flex-wrap:wrap;">
        <div style="flex:1;min-width:220px;">
          <label>Title (EN):<br><input name="title_en" required style="width:100%;padding:0.4rem;"></label><br>
          <label>Description (EN):<br><textarea name="desc_en" required style="width:100%;padding:0.4rem;"></textarea></label><br>
          <label>Book Label (EN):<br><input name="book_label_en" required style="width:100%;padding:0.4rem;" value="Book now"></label><br>
          <label>Book URL (EN):<br><input name="book_url_en" style="width:100%;padding:0.4rem;" value="#"></label><br>
          <label>Image URL (EN):<br><input name="image_en" style="width:100%;padding:0.4rem;" value="/assets/background-image.png"></label><br>
          <label>Image Alt (EN):<br><input name="image_alt_en" style="width:100%;padding:0.4rem;"></label>
        </div>
        <div style="flex:1;min-width:220px;">
          <label>Title (MK):<br><input name="title_mk" required style="width:100%;padding:0.4rem;"></label><br>
          <label>Description (MK):<br><textarea name="desc_mk" required style="width:100%;padding:0.4rem;"></textarea></label><br>
          <label>Book Label (MK):<br><input name="book_label_mk" required style="width:100%;padding:0.4rem;" value="Резервирај"></label><br>
          <label>Book URL (MK):<br><input name="book_url_mk" style="width:100%;padding:0.4rem;" value="#"></label><br>
          <label>Image URL (MK):<br><input name="image_mk" style="width:100%;padding:0.4rem;" value="/assets/background-image.png"></label><br>
          <label>Image Alt (MK):<br><input name="image_alt_mk" style="width:100%;padding:0.4rem;"></label>
        </div>
        <div style="flex:1;min-width:220px;">
          <label>Title (FR):<br><input name="title_fr" required style="width:100%;padding:0.4rem;"></label><br>
          <label>Description (FR):<br><textarea name="desc_fr" required style="width:100%;padding:0.4rem;"></textarea></label><br>
          <label>Book Label (FR):<br><input name="book_label_fr" required style="width:100%;padding:0.4rem;" value="Réserver"></label><br>
          <label>Book URL (FR):<br><input name="book_url_fr" style="width:100%;padding:0.4rem;" value="#"></label><br>
          <label>Image URL (FR):<br><input name="image_fr" style="width:100%;padding:0.4rem;" value="/assets/background-image.png"></label><br>
          <label>Image Alt (FR):<br><input name="image_alt_fr" style="width:100%;padding:0.4rem;"></label>
        </div>
      </div>
      <div style="margin-top:1.2rem;display:flex;gap:1rem;justify-content:flex-end;">
        <button type="submit" class="admin-btn">Save</button>
        <button type="button" class="admin-btn" style="background:#888;" onclick="closeEventModal()">Cancel</button>
      </div>
    </form>
  </div>
</div>
<script>
// Sidebar navigation for admin panel
const menuLinks = document.querySelectorAll('.admin-menu a');
const sections = {
    events: document.getElementById('section-events'),
    people: document.getElementById('section-people')
};
menuLinks.forEach(link => {
    link.addEventListener('click', function(e) {
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
                <button class="admin-btn delete-btn" style="padding:0.3rem 0.7rem;background:#888;">Delete</button>
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
        .then(events => renderEventsTable(events));
}

document.addEventListener('DOMContentLoaded', loadEvents);
// Modal logic for Add/Edit Event
const eventModal = document.getElementById('event-modal');
const eventForm = document.getElementById('event-form');
let editingId = null;
function openEventModal(events = null, idx = null) {
    eventModal.style.display = 'flex';
    if (events && idx !== null) {
        // Editing
        editingId = events.en[idx].id;
        eventForm.title_en.value = events.en[idx].title || '';
        eventForm.desc_en.value = events.en[idx].desc || '';
        eventForm.book_label_en.value = events.en[idx].book_label || '';
        eventForm.book_url_en.value = events.en[idx].book_url || '';
        eventForm.image_en.value = events.en[idx].image || '';
        eventForm.image_alt_en.value = events.en[idx].image_alt || '';
        eventForm.title_mk.value = events.mk[idx].title || '';
        eventForm.desc_mk.value = events.mk[idx].desc || '';
        eventForm.book_label_mk.value = events.mk[idx].book_label || '';
        eventForm.book_url_mk.value = events.mk[idx].book_url || '';
        eventForm.image_mk.value = events.mk[idx].image || '';
        eventForm.image_alt_mk.value = events.mk[idx].image_alt || '';
        eventForm.title_fr.value = events.fr[idx].title || '';
        eventForm.desc_fr.value = events.fr[idx].desc || '';
        eventForm.book_label_fr.value = events.fr[idx].book_label || '';
        eventForm.book_url_fr.value = events.fr[idx].book_url || '';
        eventForm.image_fr.value = events.fr[idx].image || '';
        eventForm.image_alt_fr.value = events.fr[idx].image_alt || '';
    } else {
        // Adding
        editingId = null;
        eventForm.reset();
    }
}
function closeEventModal() { eventModal.style.display = 'none'; eventForm.reset(); editingId = null; }
document.querySelector('.admin-header .admin-btn').onclick = openEventModal;
eventForm.onsubmit = function(e) {
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
        alert('Failed to save event.');
      }
    })
    .catch(() => alert('Failed to save event.'));
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
            alert('Failed to delete event.');
        }
    })
    .catch(() => alert('Failed to delete event.'));
}
// Close modal on background click
 eventModal.onclick = function(e) { if (e.target === eventModal) closeEventModal(); };
</script>
</body>
</html> 