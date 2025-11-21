<?php
// Services are already loaded in index.php
try {
    $events = EventService::getEvents();
} catch (Exception $e) {
    // If database/service fails, use empty array
    error_log("Hero: Failed to load events: " . $e->getMessage());
    $events = [];
}

// Get carousel images from assets/hero-carousel directory
// __DIR__ is components/hero/, so go up two levels to project root
$carouselDir = __DIR__ . '/../../assets/hero-carousel/';
$carouselImages = [];

if (is_dir($carouselDir)) {
    $files = @scandir($carouselDir);
    if ($files !== false) {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;
            
            $filePath = $carouselDir . $file;
            if (is_file($filePath)) {
                $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                if (in_array($extension, $allowedExtensions)) {
                    $carouselImages[] = '/assets/hero-carousel/' . htmlspecialchars($file, ENT_QUOTES, 'UTF-8');
                }
            }
        }
        
        // Sort images alphabetically for consistent ordering
        sort($carouselImages);
    }
}

// If no images found, use a fallback
if (empty($carouselImages)) {
    $carouselImages[] = '/assets/background-image.png';
}
?>
<section class="hero-section">
    <div class="hero-bg-carousel">
        <?php foreach ($carouselImages as $index => $imageUrl): ?>
            <div class="hero-carousel-slide<?= $index === 0 ? ' active' : '' ?>" style="background-image: url('<?= htmlspecialchars($imageUrl) ?>');"></div>
        <?php endforeach; ?>
    </div>
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
                        <div class="hero-event-dots-scroll-btn hero-event-dots-scroll-left" style="display: none;">‹</div>
                        <div class="hero-event-dots-container">
                            <span class="hero-event-overflow-dot hero-event-overflow-left" style="display: none;">⋯</span>
                            <?php foreach ($events as $idx => $ev): ?>
                                <span class="hero-event-list-dot" data-idx="<?= $idx ?>"></span>
                            <?php endforeach; ?>
                            <span class="hero-event-overflow-dot hero-event-overflow-right" style="display: none;">⋯</span>
                        </div>
                        <div class="hero-event-dots-scroll-btn hero-event-dots-scroll-right" style="display: none;">›</div>
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
const dotsContainer = document.querySelector('.hero-event-dots-container');
const scrollLeftBtn = document.querySelector('.hero-event-dots-scroll-left');
const scrollRightBtn = document.querySelector('.hero-event-dots-scroll-right');
const heroCard = document.getElementById('hero-event-card');

// Overflow dot elements
const overflowLeft = document.querySelector('.hero-event-overflow-left');
const overflowRight = document.querySelector('.hero-event-overflow-right');

// Configuration
const MAX_VISIBLE_DOTS = 5;
let dotsScrollOffset = 0;
let touchStartX = 0;
let touchEndX = 0;

// Initialize dots visibility and scrolling
function initDotsScrolling() {
    if (dots.length <= MAX_VISIBLE_DOTS) {
        scrollLeftBtn.style.display = 'none';
        scrollRightBtn.style.display = 'none';
        return;
    }
    
    updateScrollButtons();
    updateDotsVisibility();
}

function updateScrollButtons() {
    scrollLeftBtn.style.display = dotsScrollOffset > 0 ? 'block' : 'none';
    scrollRightBtn.style.display = dotsScrollOffset < dots.length - MAX_VISIBLE_DOTS ? 'block' : 'none';
}

function updateDotsVisibility() {
    dots.forEach((dot, index) => {
        const isActive = dot.classList.contains('active');
        const isVisible = index >= dotsScrollOffset && index < dotsScrollOffset + MAX_VISIBLE_DOTS;
        const shouldShow = isVisible || isActive; // Always show active dot
        const isFirstVisible = index === dotsScrollOffset;
        const isLastVisible = index === dotsScrollOffset + MAX_VISIBLE_DOTS - 1;
        
        // Remove any existing transition classes
        dot.classList.remove('dot-fade-in', 'dot-fade-out');
        
        if (shouldShow) {
            // Show dot
            dot.style.display = 'inline-block';
            
            // Add fade-in animation
            dot.classList.add('dot-fade-in');
        } else {
            // Hide dot with fade-out animation
            dot.classList.add('dot-fade-out');
            
            // Hide after animation completes
            setTimeout(() => {
                if (dot.classList.contains('dot-fade-out')) {
                    dot.style.display = 'none';
                    dot.classList.remove('dot-fade-out');
                }
            }, 300);
        }
        
        // Apply edge dot styling (but not to active dot)
        if (shouldShow && !isActive) {
            if ((isFirstVisible || isLastVisible)) {
                dot.classList.add('edge-dot');
            } else {
                dot.classList.remove('edge-dot');
            }
        } else {
            dot.classList.remove('edge-dot');
        }
    });
    
    // Update overflow indicators
    overflowLeft.style.display = dotsScrollOffset > 0 ? 'inline-block' : 'none';
    overflowRight.style.display = dotsScrollOffset < dots.length - MAX_VISIBLE_DOTS ? 'inline-block' : 'none';
}

function scrollDotsLeft() {
    if (currentIdx > 0) {
        // Go to previous event
        currentIdx--;
        showEventWithLayout(currentIdx);
    }
}

function scrollDotsRight() {
    if (currentIdx < events.length - 1) {
        // Go to next event
        currentIdx++;
        showEventWithLayout(currentIdx);
    }
}

// Auto-scroll to keep current dot visible (simplified)
function ensureCurrentDotVisible() {
    if (dots.length <= MAX_VISIBLE_DOTS) return;
    
    const currentDotIndex = currentIdx;
    const visibleStart = dotsScrollOffset;
    const visibleEnd = dotsScrollOffset + MAX_VISIBLE_DOTS - 1;
    
    // If active dot is outside visible window, adjust scroll offset
    if (currentDotIndex < visibleStart) {
        // Active dot is to the left, move scroll window left
        dotsScrollOffset = currentDotIndex;
    } else if (currentDotIndex > visibleEnd) {
        // Active dot is to the right, move scroll window right
        dotsScrollOffset = currentDotIndex - MAX_VISIBLE_DOTS + 1;
    }
    
    updateDotsVisibility();
    updateScrollButtons();
}

function showEvent(idx) {
    if (!events.length) return;
    const ev = events[idx];
    
    // Update content immediately
    image.src = ev.image;
    image.alt = ev.image_alt;
    title.textContent = ev.title;
    desc.textContent = ev.description;
    btn.textContent = ev.book_label;
    btn.href = ev.book_url;
    
    dots.forEach(dot => dot.classList.remove('active'));
    if (dots[idx]) dots[idx].classList.add('active');
    
    // Ensure current dot is visible and update edge styling
    ensureCurrentDotVisible();
    updateDotsVisibility();
    
    // Start progress bar animation
    startProgressBar();
}

// Event listeners
dots.forEach(dot => {
    dot.addEventListener('click', () => {
        currentIdx = parseInt(dot.getAttribute('data-idx'));
        showEventWithLayout(currentIdx);
        resetInterval();
    });
});

// Scroll button event listeners will be set up after functions are defined

// Simple progress bar function
function startProgressBar() {
    progressBar.style.transition = 'none';
    progressBar.style.width = '0%';
    
    setTimeout(() => {
        progressBar.style.transition = `width ${duration}ms linear`;
        progressBar.style.width = '100%';
    }, 10);
}

// Touch/swipe functionality for mobile
heroCard.addEventListener('touchstart', (e) => {
    touchStartX = e.touches[0].clientX;
});

heroCard.addEventListener('touchend', (e) => {
    touchEndX = e.changedTouches[0].clientX;
    handleSwipe();
});

function handleSwipe() {
    const swipeThreshold = 50;
    const swipeDistance = touchStartX - touchEndX;
    
    if (Math.abs(swipeDistance) > swipeThreshold) {
        if (swipeDistance > 0) {
            // Swipe left - next event
            nextEvent();
        } else {
            // Swipe right - previous event
            previousEvent();
        }
    }
}

function nextEvent() {
    if (!events.length) return;
    currentIdx = (currentIdx + 1) % events.length;
    showEventWithLayout(currentIdx);
}

function previousEvent() {
    if (!events.length) return;
    currentIdx = currentIdx === 0 ? events.length - 1 : currentIdx - 1;
    showEventWithLayout(currentIdx);
}

let interval = setInterval(nextEvent, duration);
function resetInterval() {
    clearInterval(interval);
    interval = setInterval(nextEvent, duration);
}

// Responsive layout detection
function isDesktopLayout() {
    return window.innerWidth >= 1200;
}

function isTabletLayout() {
    return window.innerWidth >= 769 && window.innerWidth <= 1199;
}

function isMobileLayout() {
    return window.innerWidth <= 768;
}

// Enhanced showEvent function
function showEventWithLayout(idx) {
    showEvent(idx);
}

// Set up scroll button event listeners
if (scrollLeftBtn && scrollRightBtn) {
    scrollLeftBtn.addEventListener('click', function(e) {
        e.preventDefault();
        scrollDotsLeft();
    });
    
    scrollRightBtn.addEventListener('click', function(e) {
        e.preventDefault();
        scrollDotsRight();
    });
}

// Initialize
if (events.length) {
    showEventWithLayout(0);
    initDotsScrolling();
}
</script>
<script>
// Hero background carousel functionality
(function() {
    const carouselSlides = document.querySelectorAll('.hero-carousel-slide');
    if (carouselSlides.length === 0) return;
    
    let currentSlide = 0;
    const carouselDuration = 5000; // 5 seconds per image
    
    function nextCarouselSlide() {
        // Remove active class from current slide
        carouselSlides[currentSlide].classList.remove('active');
        
        // Move to next slide
        currentSlide = (currentSlide + 1) % carouselSlides.length;
        
        // Add active class to new slide
        carouselSlides[currentSlide].classList.add('active');
    }
    
    // Initialize: ensure first slide is active
    carouselSlides[0].classList.add('active');
    
    // Start auto-rotation
    let carouselInterval = setInterval(nextCarouselSlide, carouselDuration);
    
    // Pause on hover (optional enhancement)
    const heroSection = document.querySelector('.hero-section');
    if (heroSection) {
        heroSection.addEventListener('mouseenter', () => {
            clearInterval(carouselInterval);
        });
        heroSection.addEventListener('mouseleave', () => {
            carouselInterval = setInterval(nextCarouselSlide, carouselDuration);
        });
    }
})();
</script> 