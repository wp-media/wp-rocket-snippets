# WP Rocket | Performance Tweaks (Preload & RUCSS)

This plugin provides advanced performance tuning for **WP Rocket** by adjusting **Preload** and **Remove Unused CSS (RUCSS)** internal parameters.

It is intended for technical users who want to reduce CPU load, avoid server overload, and prevent broken layouts caused by excessively small Used CSS files.

---

## ⚠️ Requirements

- WordPress
- WP Rocket installed and activated
- PHP 7.4 or higher

This plugin **does nothing if WP Rocket is not active**.

---

## 🚀 What This Plugin Does

The plugin modifies internal WP Rocket parameters via filters.  
It does **not** add a UI and does **not** store anything in the database.

All values are defined as constants and can be easily adjusted.

---

## 🔧 Configuration Overview

### 1. Preload Optimization

These settings help reduce CPU and server usage during cache preload.

| Setting | Purpose |
|------|------|
| Preload batch size | Limits how many URLs are processed per batch |
| Preload cron interval | Adds delay between preload batches |
| Delay between requests | Prevents simultaneous requests for the same URL |

**Configured values:**

- **Batch size:** `15` URLs (default: 45)
- **Cron interval:** `180` seconds (default: 60)
- **Delay between requests:** `2` seconds (default: 0.5)

---

### 2. RUCSS (Remove Unused CSS) Optimization

These parameters control how RUCSS jobs are processed.

| Setting | Purpose |
|------|------|
| RUCSS batch size | Controls how many URLs are analyzed per batch |
| RUCSS cron interval | Adds delay between RUCSS batches |

**Configured values:**

- **Batch size:** `15` URLs (default: 100)
- **Cron interval:** `180` seconds (default: 60)

---

### 3. Minimum Acceptable RUCSS CSS Size

This setting helps prevent broken pages caused by **incorrectly generated Used CSS**.

If the generated Used CSS file is **smaller than the defined threshold**, WP Rocket will **discard it and retry later**.

**Configured value:**

- **Minimum CSS size:** `20000` bytes (~20 KB)
- **Default WP Rocket value:** `150` bytes

---

## 🧪 How to Choose the Right Minimum CSS Size

1. Identify a **working page**
   - Check the `shakedCSS_size` value via Postman
   - This represents a “good” CSS size

2. Identify a **broken page**
   - Copy the generated Used CSS
   - Measure its size using a tool like https://www.javainuse.com/bytesize

3. Set `RUCSS_MIN_CSS_SIZE` to a value:
   - Slightly **higher than the broken CSS size**
   - Lower than normal “good” CSS sizes

### Size examples

| Size | Bytes |
|----|------|
| 2 KB | 2000 |
| 4 KB | 4000 |
| 8 KB | 8000 |
| 10 KB | 10000 |
| 20 KB | 20000 |