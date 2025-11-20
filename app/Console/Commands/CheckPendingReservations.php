<?php

namespace App\Console\Commands;

use App\Mail\PendingReservationNotification;
use App\Models\Reservation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckPendingReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-pending-reservations {minutes=30}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for pending reservations older than X minutes and notify drivers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $minutes = $this->argument('minutes');
        $threshold = now()->subMinutes($minutes);

        // Get pending reservations older than threshold
        $pendingReservations = Reservation::where('status', 'pending')
            ->where('created_at', '<=', $threshold)
            ->with('ride.user', 'passenger')
            ->get();

        if ($pendingReservations->isEmpty()) {
            $this->info('No pending reservations found.');
            return 0;
        }

        // Group by driver
        $reservationsByDriver = $pendingReservations->groupBy('ride.user_id');

        foreach ($reservationsByDriver as $driverId => $reservations) {
            $driver = $reservations->first()->ride->user;
            
            // Send email to driver
            Mail::to($driver->email)->send(new PendingReservationNotification($driver, $reservations));
            
            $this->info("Sent notification to {$driver->name} ({$driver->email}) for {$reservations->count()} pending reservations.");
        }

        $this->info("Total notifications sent: {$reservationsByDriver->count()}");
        return 0;
    }
}
