<?php
require_once __DIR__ . '/../../i18n.php';
?>
<section class="page-section">
    <div class="container">
        <h1><?= htmlspecialchars(I18nService::t('contact')) ?></h1>
        <div class="contact-content">
            <div class="contact-info">
                <h3>Get in Touch</h3>
                <p>Email: info@teatarzatebe.mk</p>
                <p>Phone: +389 XX XXX XXX</p>
                <p>Address: Skopje, Macedonia</p>
            </div>
            <div class="contact-form">
                <h3>Send us a Message</h3>
                <form action="#" method="POST">
                    <input type="text" name="name" placeholder="Your Name" required>
                    <input type="email" name="email" placeholder="Your Email" required>
                    <textarea name="message" placeholder="Your Message" required></textarea>
                    <button type="submit">Send Message</button>
                </form>
            </div>
        </div>
    </div>
</section> 