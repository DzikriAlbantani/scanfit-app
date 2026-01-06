<?php

namespace App\Console\Commands;

use App\Mail\BannerPlacementEndingMail;
use App\Models\BannerPlacement;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class PlacementsDailyCommand extends Command
{
    protected $signature = 'placements:daily';
    protected $description = 'Expire finished banner placements and send ending reminders to brands';

    public function handle(): int
    {
        $today = now()->toDateString();
        $tomorrow = now()->addDay()->toDateString();

        // Expire placements whose end_date has passed
        $expired = BannerPlacement::where('status', 'active')
            ->whereDate('end_date', '<', $today)
            ->update(['status' => 'expired']);
        $this->info("Expired placements updated: {$expired}");

        // Send reminders for placements ending tomorrow
        $toRemind = BannerPlacement::with(['brand.user'])
            ->where('status', 'active')
            ->whereDate('end_date', $tomorrow)
            ->get();

        $count = 0;
        foreach ($toRemind as $placement) {
            $meta = $placement->metadata ?? [];
            if (!empty($meta['reminded_tomorrow_at'])) {
                continue; // already reminded
            }
            $user = optional($placement->brand)->user;
            if (!$user || empty($user->email)) {
                continue;
            }
            try {
                Mail::to($user->email)->send(new BannerPlacementEndingMail($placement));
                $meta['reminded_tomorrow_at'] = now()->toIso8601String();
                $placement->metadata = $meta;
                $placement->save();
                $count++;
            } catch (\Throwable $e) {
                // swallow email errors, continue
            }
        }
        $this->info("Reminders sent: {$count}");

        return Command::SUCCESS;
    }
}
