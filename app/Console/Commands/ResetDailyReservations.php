<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use App\Models\Books;
use App\Models\Equipment;

class ResetDailyReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset daily reservation counters for all users and item slots';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Clear all user reservation counters from cache
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
        
        $booksCount = Books::count();
        $equipmentCount = Equipment::count();
        
        $this->info('Daily reservation counters have been reset successfully.');
        $this->info("Reset {$booksCount} books and {$equipmentCount} equipment items.");
        
        return 0;
    }
}
