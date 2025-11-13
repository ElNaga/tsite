# 🚀 Google Analytics Setup Guide

## **Step 1: Get Your Google Analytics ID**

1. **Go to Google Analytics:**
   - Visit: https://analytics.google.com
   - Sign in with your Google account

2. **Create a New Property:**
   - Click "Create Account" or "Create Property"
   - Choose "Web" as your platform
   - Enter your website URL: `http://localhost:8000` (for testing)
   - Enter account name: "Teatar za tebe"
   - Enter property name: "Teatar za tebe Website"

3. **Get Your Measurement ID:**
   - After setup, you'll see a Measurement ID like: `G-XXXXXXXXXX`
   - Copy this ID

## **Step 2: Add Your ID to the Website**

1. **Open the file:** `components/analytics/ga4.php`
2. **Find this line:**
   ```php
   $ga4_measurement_id = 'G-XXXXXXXXXX'; // Replace with your actual Measurement ID
   ```
3. **Replace with your actual ID:**
   ```php
   $ga4_measurement_id = 'G-ABC123DEF4'; // Your actual ID here
   ```

## **Step 3: Test It Works**

1. **Start your server:**
   ```bash
   php -S localhost:8000 router.php
   ```

2. **Visit your website:**
   - Go to: http://localhost:8000
   - Open browser developer tools (F12)
   - Go to "Network" tab
   - Look for requests to `googletagmanager.com` - this means it's working!

3. **Check Google Analytics:**
   - Go back to Google Analytics
   - Click "Realtime" in the left menu
   - You should see "1 user currently" if you're on the site

## **Step 4: What You'll See in Google Analytics**

### **📊 Real-time Data:**
- Live visitor count
- Current page views
- User locations
- Traffic sources

### **📈 Reports Available:**
- **Audience:** Who visits your site
- **Acquisition:** How people find you
- **Behavior:** What pages they visit
- **Conversions:** Contact form submissions

### **🎯 Custom Events Tracked:**
- Page views
- Language switches
- Contact form submissions
- Admin logins
- Button clicks

## **🔧 Advanced Setup (Optional)**

### **Enhanced Ecommerce (if you add booking system):**
```javascript
// Track booking conversions
gtag('event', 'purchase', {
  transaction_id: 'booking_123',
  value: 50.00,
  currency: 'EUR',
  items: [{
    item_id: 'event_booking',
    item_name: 'Theater Event',
    category: 'Entertainment',
    quantity: 1,
    price: 50.00
  }]
});
```

### **Custom Dimensions:**
- Track user language preferences
- Track admin vs regular users
- Track mobile vs desktop usage

## **📱 Mobile Analytics**

Google Analytics automatically tracks:
- Mobile vs desktop users
- Device types
- Screen resolutions
- Operating systems

## **🌍 International Analytics**

Since your site supports multiple languages:
- Track which languages are most popular
- See geographic distribution of users
- Monitor language-specific page performance

## **⚡ Quick Test**

Once you've added your Measurement ID:

1. **Visit your site:** http://localhost:8000
2. **Check Google Analytics:** Go to "Realtime" → "Overview"
3. **You should see:** "1 user currently" (that's you!)

## **🚨 Troubleshooting**

### **If you don't see data:**
1. Check your Measurement ID is correct
2. Make sure you're visiting the site (not just opening files)
3. Wait 5-10 minutes for data to appear
4. Check browser console for errors

### **If you see errors:**
1. Make sure you're using the correct format: `G-XXXXXXXXXX`
2. Check that the file `components/analytics/ga4.php` exists
3. Verify the include in `index.php` is working

## **🎉 You're Done!**

Once set up, Google Analytics will automatically track:
- ✅ Page views
- ✅ User sessions
- ✅ Traffic sources
- ✅ Device information
- ✅ Geographic data
- ✅ Custom events

**Your analytics will be available at:** https://analytics.google.com






