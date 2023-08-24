<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Cron\NewsController;

class News extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'News created';

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
        // error_log('123123213123123123');
        $controller = new NewsController();

        // Call the controller method
        $controller->newsApi();

        $this->info('success');
    }
}
