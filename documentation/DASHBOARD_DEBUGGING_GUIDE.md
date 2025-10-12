# Dashboard Debugging Guide

**Quick Reference for Troubleshooting Dashboard Issues**

---

## Quick Diagnostics

### 1. Check if Dashboard Loads
```
URL: http://127.0.0.1:8585/dashboard
Expected: Dashboard page displays
```

### 2. Check Browser Console (F12)
```javascript
// Should see these logs:
Dashboard API Response: {...}
Stock Distribution: {...}
Daily Orders: {...}
Daily Receivings: {...}
```

### 3. Check Network Tab
```
Request: GET /api/dashboard/all
Status: 200 OK
Response: JSON with success: true
```

---

## Error Messages and Solutions

### Error: "Class 'Inertia' not found"

**Location:** `/dashboard` route  
**File:** `routes/web.php`

**Solution:**
```php
// Add this import at the top of routes/web.php
use Inertia\Inertia;
```

**Verify Fix:**
```bash
php artisan route:clear
# Then reload /dashboard
```

---

### Error: "Failed to execute 'observe' on 'MutationObserver'"

**Cause:** Chart component receiving invalid data structure

**Debug Steps:**
1. Open browser console
2. Check the data structure:
```javascript
console.log('Raw API Response:', response);
console.log('Stock Distribution:', stockDistribution.value);
console.log('Formatted Data:', stockDistributionData.value);
```

3. Verify data has required properties:
```javascript
// For Doughnut Chart:
stockDistributionData.value = {
  labels: [...],    // Must exist
  datasets: [{      // Must exist
    data: [...],
    backgroundColor: [...]
  }]
}

// For Bar Chart:
dailyOrdersData.value = {
  labels: [...],    // Must exist
  datasets: [...]   // Must exist
}
```

**Solution:**
- Ensure computed properties format data correctly
- Check API returns expected structure
- Verify chart components have data validation

---

### Error: Charts Display "No data available"

**Possible Causes:**
1. API returns empty data
2. Data format is incorrect
3. Computed property returns null

**Debug Steps:**

**Step 1: Check API Response**
```javascript
// In browser console
fetch('/api/dashboard/all')
  .then(r => r.json())
  .then(d => console.log('API Data:', d));
```

**Step 2: Check Raw Data**
```javascript
console.log('Stock Distribution Raw:', stockDistribution.value);
// Should show: {labels: [...], values: [...], colors: [...]}
```

**Step 3: Check Computed Property**
```javascript
console.log('Stock Distribution Computed:', stockDistributionData.value);
// Should show: {labels: [...], datasets: [{...}]}
```

**Step 4: Check Database**
```sql
-- Check if you have data
SELECT COUNT(*) FROM assets;
SELECT COUNT(*) FROM orders;
SELECT COUNT(*) FROM receivings;
```

**Solutions:**
- If API returns empty: Add sample data to database
- If format wrong: Check computed property logic
- If computed returns null: Check conditional logic

---

### Error: API Returns 500 Internal Server Error

**Debug Steps:**

**Step 1: Check Laravel Logs**
```bash
# View last 50 lines of log
tail -n 50 storage/logs/laravel.log

# Or on Windows PowerShell
Get-Content storage\logs\laravel.log -Tail 50
```

**Step 2: Common Causes**

**A. Database Connection Error**
```bash
# Test database connection
php artisan tinker
>>> DB::connection()->getPdo();
```

**B. Missing Model Relationships**
```php
// Check if models have relationships defined
// In ReportsApiController.php
Order::with(['customer', 'orderStatus'])->first();
Receiving::with(['asset', 'receivingStatus'])->first();
```

**C. SQL Query Error**
```php
// Enable query logging in ReportsApiController
DB::enableQueryLog();
// ... your query ...
dd(DB::getQueryLog());
```

**Step 3: Test Individual Endpoints**
```bash
# Test each endpoint separately
curl http://127.0.0.1:8585/api/dashboard/summary
curl http://127.0.0.1:8585/api/dashboard/stock-distribution
curl http://127.0.0.1:8585/api/dashboard/daily-orders
curl http://127.0.0.1:8585/api/dashboard/daily-receivings
```

---

### Error: API Returns 401 Unauthorized

**Cause:** Not authenticated or session expired

**Solutions:**

**Option 1: Login Again**
```
1. Go to /login
2. Enter credentials
3. Return to /dashboard
```

**Option 2: Check Session Configuration**
```bash
# Check .env file
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Clear config cache
php artisan config:clear
```

**Option 3: Check Middleware**
```php
// In routes/web.php
Route::group(['middleware' => ['auth']], function() {
    Route::get('/dashboard', ...);
});
```

---

### Error: Computed Property Returns Undefined

**Symptom:** Console shows `undefined` for computed properties

**Debug:**
```javascript
// Check if ref is initialized
console.log('stockDistribution ref:', stockDistribution.value);

// Check computed property
console.log('stockDistributionData computed:', stockDistributionData.value);

// Check if data exists
if (stockDistribution.value) {
  console.log('Has labels:', stockDistribution.value.labels);
  console.log('Has values:', stockDistribution.value.values);
  console.log('Has colors:', stockDistribution.value.colors);
}
```

**Solution:**
```javascript
// Ensure computed property has null check
const stockDistributionData = computed(() => {
  if (!stockDistribution.value) return null;  // Add this check
  return {
    labels: stockDistribution.value.labels || [],
    datasets: [{
      data: stockDistribution.value.values || [],
      backgroundColor: stockDistribution.value.colors || [],
    }]
  };
});
```

---

## Data Flow Debugging

### Step-by-Step Data Flow

```
1. Component Mounts
   ↓
2. fetchDashboardData() called
   ↓
3. API Request: GET /api/dashboard/all
   ↓
4. ReportsApiController::getAllDashboardData()
   ↓
5. Database Queries Execute
   ↓
6. JSON Response Returned
   ↓
7. Response Parsed in Frontend
   ↓
8. Refs Updated (stockDistribution, dailyOrders, etc.)
   ↓
9. Computed Properties Triggered
   ↓
10. Chart Components Receive Data
   ↓
11. Charts Render
```

### Add Debug Logs at Each Step

**Backend (ReportsApiController.php):**
```php
public function getAllDashboardData()
{
    try {
        \Log::info('Dashboard API called');
        
        $summary = $this->getDashboardSummary()->getData()->data;
        \Log::info('Summary fetched', ['summary' => $summary]);
        
        $stockDist = $this->getStockDistribution()->getData()->data;
        \Log::info('Stock distribution fetched', ['data' => $stockDist]);
        
        // ... rest of the method
    } catch (\Exception $e) {
        \Log::error('Dashboard API error', [
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        throw $e;
    }
}
```

**Frontend (HomeEnhanced.vue):**
```javascript
const fetchDashboardData = async () => {
  console.log('1. Starting fetch...');
  
  const response = await dashboardService.getAllDashboardData();
  console.log('2. API Response:', response);
  
  stockDistribution.value = response.data.stock_distribution;
  console.log('3. Stock Distribution Set:', stockDistribution.value);
  
  console.log('4. Computed Property:', stockDistributionData.value);
};
```

---

## Performance Debugging

### Slow API Response

**Measure Query Time:**
```php
// In ReportsApiController.php
$start = microtime(true);

// Your query here
$result = DB::table('assets')->get();

$time = microtime(true) - $start;
\Log::info('Query time: ' . $time . ' seconds');
```

**Common Slow Queries:**
1. Missing indexes on foreign keys
2. N+1 query problems
3. Large dataset without pagination

**Solutions:**
```php
// Add indexes
Schema::table('asset_order', function (Blueprint $table) {
    $table->index('asset_id');
    $table->index('created_at');
});

// Use eager loading
Order::with(['customer', 'orderStatus'])->get();

// Add pagination
Order::latest()->paginate(10);
```

---

## Chart-Specific Debugging

### Doughnut Chart Not Displaying

**Required Data Structure:**
```javascript
{
  labels: ['Label 1', 'Label 2', ...],
  datasets: [{
    data: [10, 20, ...],
    backgroundColor: ['#color1', '#color2', ...]
  }]
}
```

**Debug:**
```javascript
const data = stockDistributionData.value;
console.log('Has labels:', Array.isArray(data?.labels));
console.log('Has datasets:', Array.isArray(data?.datasets));
console.log('Has data:', Array.isArray(data?.datasets[0]?.data));
console.log('Has colors:', Array.isArray(data?.datasets[0]?.backgroundColor));
```

### Bar Chart Not Displaying

**Required Data Structure:**
```javascript
{
  labels: ['Day 1', 'Day 2', ...],
  datasets: [{
    label: 'Orders',
    data: [5, 10, ...],
    backgroundColor: '#3699FF'
  }]
}
```

**Debug:**
```javascript
const data = dailyOrdersData.value;
console.log('Labels:', data?.labels);
console.log('Datasets:', data?.datasets);
console.log('First dataset:', data?.datasets[0]);
```

---

## Quick Fixes

### Clear Everything and Start Fresh

```bash
# Backend
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
composer dump-autoload

# Frontend
npm cache clean --force
rm -rf node_modules
npm install
npm run dev

# Browser
# Hard refresh: Ctrl+Shift+R (Windows) or Cmd+Shift+R (Mac)
```

### Reset Database (Development Only!)

```bash
php artisan migrate:fresh --seed
```

### Verify All Files Are Saved

```bash
# Check git status
git status

# See what changed
git diff
```

---

## Testing Individual Components

### Test Chart Component Directly

Create a test route:
```php
// In routes/web.php
Route::get('/test-chart', function() {
    return Inertia::render('TestChart');
});
```

Create test component:
```vue
<!-- resources/js/Pages/TestChart.vue -->
<script setup>
import DoughnutChart from '../Components/Dashboard/DoughnutChart.vue';

const testData = {
  labels: ['Red', 'Blue', 'Yellow'],
  datasets: [{
    data: [300, 50, 100],
    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
  }]
};
</script>

<template>
  <div style="width: 400px; height: 400px;">
    <DoughnutChart :data="testData" />
  </div>
</template>
```

---

## Contact Points for Issues

### File Locations

**Backend:**
- Routes: `routes/web.php`, `routes/api.php`
- Controller: `app/Http/Controllers/Api/ReportsApiController.php`
- Models: `app/Models/`

**Frontend:**
- Main Component: `resources/js/Pages/HomeEnhanced.vue`
- Chart Components: `resources/js/Components/Dashboard/`
- API Service: `resources/js/Api/DashboardApi.js`

**Logs:**
- Laravel: `storage/logs/laravel.log`
- Browser: DevTools Console (F12)

---

## Emergency Rollback

If dashboard is completely broken:

```bash
# Revert to previous working version
git log --oneline  # Find last working commit
git checkout <commit-hash> -- routes/web.php
git checkout <commit-hash> -- resources/js/Pages/HomeEnhanced.vue

# Rebuild
npm run dev
php artisan route:clear
```

---

**Last Updated:** October 12, 2025  
**Maintained By:** Development Team
