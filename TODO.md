# TODO: Footer &amp; Branding Update to EduCore / MGTechs

## Status: In Progress

### 1. [✅] Update config/app.php
   - Set &#39;name&#39; => &#39;EduCore&#39;
   - Uses config fallback in layouts

### 2. [✅] Update resources/views/layouts/admin.blade.php  
   - Replace "SchoolMS Pro" → "EduCore" (sidebar header)
   - Replace "Developed by Hashing Heroes Developers" → "MGTechs (mgtechs.com.ng)"

### 3. [✅] Update resources/views/welcome.blade.php
   - Replace all "SchoolMS Pro" → "EduCore" (title, navbar, footer)
   - Update contact section:
     * "support@schoolms.com" → "admin@mgtechs.com.ng"
     * "+234 812 345 6789" → "+234 8161595906"
     * "Lagos, Nigeria" → "Yola, Nigeria"
   - Update copyright developer credit to MGTechs details

### 4. [✅] Clear config cache &amp; Test
   - `php artisan config:clear`
   - Check / (welcome) &amp; /dashboard pages

### 5. [✅] Complete &amp; cleanup
   - Mark all ✅
   - Archive this TODO
php artisan serve