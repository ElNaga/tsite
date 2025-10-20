<?php
/**
 * Google Analytics 4 Integration
 * Add this to your website for comprehensive analytics
 */

// Get your GA4 Measurement ID from Google Analytics
// TODO: Replace with your actual Google Analytics Measurement ID
$ga4_measurement_id = 'G-XXXXXXXXXX'; // Replace with your actual Measurement ID

// Only include analytics if ID is set
if ($ga4_measurement_id !== 'G-XXXXXXXXXX'): ?>

<!-- Google Analytics 4 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?= $ga4_measurement_id ?>"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '<?= $ga4_measurement_id ?>', {
    // Enhanced measurement settings
    send_page_view: true,
    enhanced_measurement: {
      scrolls: true,
      outbound_clicks: true,
      site_search: true,
      video_engagement: true,
      file_downloads: true
    }
  });

  // Track custom events
  function trackEvent(eventName, parameters = {}) {
    gtag('event', eventName, parameters);
  }

  // Track page views
  function trackPageView(pageName, pageTitle) {
    gtag('event', 'page_view', {
      page_title: pageTitle,
      page_location: window.location.href,
      page_name: pageName
    });
  }

  // Track language switches
  function trackLanguageSwitch(language) {
    gtag('event', 'language_switch', {
      language: language,
      page_location: window.location.href
    });
  }

  // Track contact form submissions
  function trackContactForm() {
    gtag('event', 'contact_form_submit', {
      event_category: 'engagement',
      event_label: 'contact_form'
    });
  }

  // Track admin login attempts
  function trackAdminLogin(success) {
    gtag('event', 'admin_login', {
      event_category: 'admin',
      success: success
    });
  }
</script>

<?php endif; ?>
