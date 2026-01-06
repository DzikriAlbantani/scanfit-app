<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Brand;
use Illuminate\Support\Facades\Auth;

class TestBrandDashboard extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-brand-dashboard';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test brand dashboard access';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing Brand Dashboard Access...');

        // Find the brand owner
        $user = User::where('email', 'owner@erigo.com')->first();

        if (!$user) {
            $this->error('Brand owner user not found!');
            return;
        }

        $this->info("User found: {$user->name} ({$user->email})");
        $this->info("User role: {$user->role}");
        $this->info("Is brand: " . ($user->isBrand() ? 'Yes' : 'No'));

        // Check brand
        $brand = $user->brand;
        if (!$brand) {
            $this->error('Brand not found for user!');
            return;
        }

        $this->info("Brand: {$brand->brand_name}");
        $this->info("Brand status: {$brand->status}");
        $this->info("Brand approved: " . ($brand->isApproved() ? 'Yes' : 'No'));

        // Try to authenticate user
        Auth::login($user);
        $this->info("User authenticated: " . (Auth::check() ? 'Yes' : 'No'));

        // Test controller method
        try {
            $controller = new \App\Http\Controllers\BrandDashboardController();
            $response = $controller->dashboard();

            if ($response instanceof \Illuminate\View\View) {
                $this->info('Controller returned view successfully');
                $this->info('View name: ' . $response->getName());
            } else {
                $this->error('Controller did not return a view');
            }
        } catch (\Exception $e) {
            $this->error('Error calling controller: ' . $e->getMessage());
        }

        Auth::logout();
    }
}
