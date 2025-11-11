# Item Slots Reservation System

## Overview
Each book and equipment item now has **25 reservation slots per day** that reset automatically at midnight. This allows multiple users to reserve the same item each day.

## How It Works

### Database Structure
Each item (book/equipment) has three new columns:
- `max_slots` (integer, default: 25) - Maximum reservations allowed per day
- `reserved_today` (integer, default: 0) - Current count of reservations today
- `last_reset_date` (date, nullable) - Last date the counter was reset

### Visual Display
In the student portal, each item card shows:
```
15/25 slots available
```

This tells students:
- **15** = Number of slots still available today
- **25** = Total slots for this item per day

### Reservation Flow

1. **Student browses items**
   - Each card displays available slots (e.g., "15/25 slots available")
   - Button shows "No Slots Available" when `reserved_today >= max_slots`

2. **Student attempts reservation**
   - System checks if item has available slots
   - System checks if user hasn't exceeded their daily limit (25 total)
   - If both checks pass, reservation is created
   - Item's `reserved_today` counter is incremented

3. **Item reaches maximum**
   - When `reserved_today >= max_slots`, item status becomes "Unavailable"
   - Button is disabled with "No Slots Available" message

4. **Daily reset (midnight)**
   - Scheduled task runs at 00:00
   - All items: `reserved_today` reset to 0
   - All items: `last_reset_date` updated to current date
   - Item status reset to "Available"
   - Users can reserve again

### Auto-Reset Feature
Items automatically reset if accessed after the last reset date:
```php
// Reset if last reset was not today
if ($book->last_reset_date != now()->toDateString()) {
    $book->update([
        'reserved_today' => 0,
        'last_reset_date' => now()->toDateString(),
    ]);
}
```

## Implementation Details

### Migration
File: `database/migrations/2025_11_11_204552_add_max_slots_to_books_and_equipments_table.php`

Adds to both `books` and `equipments` tables:
```php
$table->integer('max_slots')->default(25);
$table->integer('reserved_today')->default(0);
$table->date('last_reset_date')->nullable();
```

### Models Updated
- `app/Models/Books.php` - Added fields to fillable and casts
- `app/Models/Equipment.php` - Added fields to fillable and casts

### Controller Logic
File: `app/Http/Controllers/Student/StudentController.php`

**Viewing Items:**
```php
public function bookReservation()
{
    $books = Books::all()->map(function ($book) {
        // Auto-reset if needed
        if ($book->last_reset_date != now()->toDateString()) {
            $book->update([
                'reserved_today' => 0,
                'last_reset_date' => now()->toDateString(),
            ]);
        }
        
        return [
            // ... other fields
            'max_slots' => $book->max_slots,
            'reserved_today' => $book->reserved_today,
            'available_slots' => $book->max_slots - $book->reserved_today,
        ];
    });
}
```

**Creating Reservation:**
```php
public function bookReservationCreate(Request $request)
{
    $book = Books::findOrFail($request->book_id);
    
    // Auto-reset if needed
    if ($book->last_reset_date != now()->toDateString()) {
        $book->update([
            'reserved_today' => 0,
            'last_reset_date' => now()->toDateString(),
        ]);
        $book->refresh();
    }
    
    // Check if book has available slots
    if ($book->reserved_today >= $book->max_slots) {
        return back()->withErrors([
            'slots' => 'This book has reached its maximum reservation limit for today.'
        ]);
    }
    
    // Create reservation
    BookReservation::create([...]);
    
    // Increment counter
    $book->increment('reserved_today');
    
    // Mark as unavailable if all slots taken
    if ($book->reserved_today >= $book->max_slots) {
        $book->update(['status' => 'Unavailable']);
    }
}
```

### Frontend Display
Files updated:
- `resources/js/pages/student/book-reservation.tsx`
- `resources/js/pages/student/equipment-reservation.tsx`

**TypeScript Types:**
```typescript
type BookReservationProps = {
    books: {
        id: number;
        title: string;
        author: string;
        status: string;
        image: string | null;
        description: string | null;
        max_slots: number;
        reserved_today: number;
        available_slots: number;
    }[];
    remainingReservations: number;
}
```

**UI Elements:**
```tsx
<CardHeader>
    <CardTitle>{book.title}</CardTitle>
    <CardDescription>by {book.author}</CardDescription>
    <div className="mt-2">
        <Badge variant="outline" className="text-xs">
            {book.available_slots}/{book.max_slots} slots available
        </Badge>
    </div>
</CardHeader>

<Button
    disabled={
        book.status === 'Unavailable' || 
        processing === book.id || 
        remainingReservations === 0 || 
        book.available_slots === 0
    }
>
    {book.available_slots === 0 ? (
        <>
            <XCircle className="w-4 h-4 mr-2" />
            No Slots Available
        </>
    ) : (
        <>
            <BookOpen className="w-4 h-4 mr-2" />
            Reserve Book
        </>
    )}
</Button>
```

## Daily Reset Command

File: `app/Console/Commands/ResetDailyReservations.php`

Resets both user limits and item slots:
```php
public function handle()
{
    // Clear user reservation counters
    Cache::flush();
    
    // Reset book slots
    Books::query()->update([
        'reserved_today' => 0,
        'last_reset_date' => now()->toDateString(),
    ]);
    
    // Reset equipment slots
    Equipment::query()->update([
        'reserved_today' => 0,
        'last_reset_date' => now()->toDateString(),
    ]);
}
```

## Testing

### Manual Testing
1. **View items:**
   ```powershell
   # Should show "25/25 slots available" for new items
   ```

2. **Make reservations:**
   - Reserve the same book multiple times (up to 25)
   - Watch the counter decrease: 24/25, 23/25, etc.
   - At 0/25, button should say "No Slots Available"

3. **Test reset:**
   ```powershell
   php artisan reservations:reset
   ```
   - All counters should reset to 0
   - All items should show "25/25 slots available"
   - All items should be "Available" status

### Automated Reset
Schedule runs daily at midnight:
```php
// app/Console/Kernel.php
protected function schedule(Schedule $schedule): void
{
    $schedule->command('reservations:reset')->dailyAt('00:00');
}
```

## User Experience Flow

### Example: Popular Book
- **8:00 AM**: Book shows "25/25 slots available"
- **10:00 AM**: After 10 reservations, shows "15/25 slots available"
- **2:00 PM**: After 20 reservations, shows "5/25 slots available" (orange warning)
- **4:00 PM**: After 25 reservations, shows "0/25 slots available" (disabled button)
- **11:59 PM**: Still unavailable
- **12:00 AM**: System resets, shows "25/25 slots available" again

### User Limits + Item Slots
Both systems work together:
- **User limit**: Each user can make 25 reservations per day (total across all items)
- **Item slots**: Each item can be reserved 25 times per day (by different users)

Example scenario:
- User A reserves Book X (User A: 24 left, Book X: 24 slots left)
- User B reserves Book X (User B: 24 left, Book X: 23 slots left)
- User C reserves Book X (User C: 24 left, Book X: 22 slots left)
- ... continues until Book X reaches 0 slots
- Book X becomes unavailable for everyone
- Users can still reserve other books (if they have reservations left)

## Customization

### Changing Max Slots
To change the default 25 slots:

1. **For new items:**
   ```php
   // In migration
   $table->integer('max_slots')->default(50); // Change 25 to 50
   ```

2. **For existing items:**
   ```php
   Books::query()->update(['max_slots' => 50]);
   Equipment::query()->update(['max_slots' => 50]);
   ```

3. **For specific items:**
   - Admin panel can allow editing `max_slots` field per item
   - Some items might have 10 slots, others 50, based on availability

### Per-Item Customization
You can set different limits for different items:
```php
// Popular textbooks might have more slots
Books::where('title', 'like', '%Calculus%')->update(['max_slots' => 50]);

// Rare equipment might have fewer slots
Equipment::where('name', 'like', '%Telescope%')->update(['max_slots' => 5]);
```

## Benefits

1. **Fair Access**: Multiple students can use the same resource daily
2. **Realistic**: Models real library systems where items can be used by many
3. **Flexible**: Admin can adjust slots per item based on demand
4. **Automatic**: Resets happen automatically without manual intervention
5. **Transparent**: Students see exactly how many slots are left
6. **Scalable**: System handles high-demand items gracefully

## Troubleshooting

### Slots not resetting
- Check if scheduler is running: `php artisan schedule:work`
- Manually reset: `php artisan reservations:reset`
- Check `last_reset_date` in database

### Incorrect slot count
- Auto-reset triggers when viewing items after midnight
- Manual fix: `php artisan reservations:reset`

### Status not updating
- Status automatically updates when `reserved_today >= max_slots`
- Reset command restores status to "Available"
