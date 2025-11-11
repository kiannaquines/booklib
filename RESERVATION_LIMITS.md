# Daily Reservation Limits

## Overview
The system now enforces a maximum of **25 reservations per day** for each user across all reservation types:
- Book Reservations
- Equipment Reservations
- Seat Reservations

These limits reset automatically at midnight every day.

## Features Implemented

### 1. Daily Reservation Tracking
- Each user can make up to 25 reservations per day for each type
- Counters are stored in Laravel's cache system
- Counters automatically expire at the end of each day

### 2. User Interface Alerts
- **Blue Alert** (> 5 remaining): Shows available reservation count
- **Orange Alert** (1-5 remaining): Warning that limit is approaching
- **Red Alert** (0 remaining): Maximum limit reached notification

### 3. Automatic Daily Reset
- Scheduled task runs at midnight (00:00) every day
- Clears all reservation counters
- Users start fresh each day

## Setup Instructions

### For Development (Local)

To test the scheduled task manually:

```powershell
php artisan reservations:reset
```

To run the scheduler locally, you need to run this command in a separate terminal:

```powershell
php artisan schedule:work
```

This will run the scheduler every minute and execute tasks when they're due.

### For Production (Server)

Add this cron entry to your server's crontab:

```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

Replace `/path-to-your-project` with your actual project path.

#### For Windows Server (Task Scheduler):

1. Open Task Scheduler
2. Create a new task
3. Set trigger to run daily at startup and repeat every 1 minute
4. Set action to run:
   ```
   C:\path\to\php.exe C:\path\to\your-project\artisan schedule:run
   ```

## Technical Details

### Files Modified/Created

1. **app/Console/Kernel.php** - Defines the schedule
2. **app/Console/Commands/ResetDailyReservations.php** - Command to reset counters
3. **app/Http/Controllers/Student/StudentController.php** - Added limit checking logic
4. **resources/js/pages/student/book-reservation.tsx** - UI with alerts
5. **resources/js/pages/student/equipment-reservation.tsx** - UI with alerts
6. **resources/js/pages/student/seat-reservation.tsx** - UI with alerts

### How It Works

```php
// Check if user can make a reservation
protected function canMakeReservation(string $type): bool
{
    $userId = $this->userId();
    $today = now()->toDateString();
    $cacheKey = "reservations_{$type}_{$userId}_{$today}";
    
    $count = Cache::get($cacheKey, 0);
    
    return $count < self::MAX_DAILY_RESERVATIONS;
}

// Increment the counter after successful reservation
protected function incrementReservationCount(string $type): void
{
    $userId = $this->userId();
    $today = now()->toDateString();
    $cacheKey = "reservations_{$type}_{$userId}_{$today}";
    
    $count = Cache::get($cacheKey, 0);
    Cache::put($cacheKey, $count + 1, now()->endOfDay());
}
```

### Cache Configuration

Make sure your `.env` file has a proper cache driver configured:

```env
CACHE_DRIVER=file
```

For production, consider using Redis or Memcached for better performance:

```env
CACHE_DRIVER=redis
```

## Testing

1. Make several reservations (books, equipment, or seats)
2. Check that the counter decreases with each reservation
3. Try to make more than 25 reservations - should be blocked
4. Run `php artisan reservations:reset` manually
5. Verify that you can make reservations again

## Troubleshooting

### Counters not resetting
- Check if the scheduler is running: `php artisan schedule:work`
- Verify cron job is configured correctly on production
- Check Laravel logs in `storage/logs/`

### Cache not working
- Clear cache: `php artisan cache:clear`
- Check cache driver in `.env`
- Verify cache directory permissions: `storage/framework/cache/`

### Alerts not showing
- Run `npm run build` to compile frontend changes
- Clear browser cache
- Check browser console for errors

## Future Enhancements

Potential improvements:
- Different limits for different user roles (students vs. staff)
- Configurable limits via admin panel
- Weekly or monthly reservation limits
- Reservation history and analytics
- Email notifications when approaching limit
