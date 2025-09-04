<?php
// Services are already loaded in index.php
$events = EventService::getEvents();
?>
<section class="hero-section">
    <video class="hero-bg-video" autoplay loop muted playsinline>
        <source src="/assets/videos/Edu.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="hero-event-card" id="hero-event-card">
            <div class="hero-event-split">
                <div class="hero-event-info">
<?php if (!empty($events) && isset($events[0]['title'])): ?>
                    <h1 class="hero-event-title" id="hero-event-title"><?= htmlspecialchars($events[0]['title'] ?? '') ?></h1>
                    <p class="hero-event-desc" id="hero-event-desc"><?= htmlspecialchars($events[0]['description'] ?? '') ?></p>
                    <a href="<?= htmlspecialchars($events[0]['book_url'] ?? '#') ?>" class="hero-event-btn" id="hero-event-btn"><?= htmlspecialchars($events[0]['book_label'] ?? '') ?></a>
<?php else: ?>
                    <h1 class="hero-event-title" id="hero-event-title">No events available</h1>
                    <p class="hero-event-desc" id="hero-event-desc">Please check back later or contact the site administrator to add events.</p>
                    <a href="#" class="hero-event-btn" id="hero-event-btn" style="pointer-events:none;opacity:0.5;">No Event</a>
<?php endif; ?>
                    <div class="hero-event-progress-container">
                        <div class="hero-event-progress-bar" id="hero-event-progress-bar"></div>
                    </div>
                    <div class="hero-event-list">
                        <?php foreach ($events as $idx => $ev): ?>
                            <span class="hero-event-list-dot" data-idx="<?= $idx ?>"></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="hero-event-image-side">
<?php if (!empty($events) && isset($events[0]['image'])): ?>
                    <img id="hero-event-image" src="<?= htmlspecialchars($events[0]['image']) ?>" alt="<?= htmlspecialchars($events[0]['image_alt']) ?>" class="hero-event-image">
<?php else: ?>
                    <img id="hero-event-image" src="/assets/background-image.png" alt="No event image" class="hero-event-image">
<?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="about-us-bg">
<?php include __DIR__ . '/servicesoffered.php'; ?>
<?php include __DIR__ . '/aboutus.php'; ?>
</div>
<?php include __DIR__ . '/additional-info.php'; ?>
<script>
const events = <?php echo json_encode($events); ?>;
let currentIdx = 0;
const duration = 9000; // 9 seconds
const image = document.getElementById('hero-event-image');
const title = document.getElementById('hero-event-title');
const desc = document.getElementById('hero-event-desc');
const btn = document.getElementById('hero-event-btn');
const progressBar = document.getElementById('hero-event-progress-bar');
const dots = document.querySelectorAll('.hero-event-list-dot');

function showEvent(idx) {
    if (!events.length) return;
    const ev = events[idx];
    image.src = ev.image;
    image.alt = ev.image_alt;
    title.textContent = ev.title;
    desc.textContent = ev.description;
    btn.textContent = ev.book_label;
    btn.href = ev.book_url;
    dots.forEach(dot => dot.classList.remove('active'));
    if (dots[idx]) dots[idx].classList.add('active');
    progressBar.style.transition = 'none';
    progressBar.style.width = '0%';
    setTimeout(() => {
        progressBar.style.transition = `width ${duration}ms linear`;
        progressBar.style.width = '100%';
    }, 50);
}

dots.forEach(dot => {
    dot.addEventListener('click', () => {
        currentIdx = parseInt(dot.getAttribute('data-idx'));
        showEvent(currentIdx);
        resetInterval();
    });
});

function nextEvent() {
    if (!events.length) return;
    currentIdx = (currentIdx + 1) % events.length;
    showEvent(currentIdx);
}

let interval = setInterval(nextEvent, duration);
function resetInterval() {
    clearInterval(interval);
    interval = setInterval(nextEvent, duration);
}

if (events.length) showEvent(0);
</script> 