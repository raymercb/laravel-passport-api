<?php

namespace App\Console\Commands;

use App\Notification;
use Illuminate\Console\Command;

class ClearNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all notifications for all users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Notification::truncate();
        echo 'Notifications deleted.';
    }
}
