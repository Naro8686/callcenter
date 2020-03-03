<?php

namespace App\Console\Commands;

use App\Contact;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ContactStatusChange extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:change';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        try {
            Contact::query()->where('status', '=', true)
                ->update(['status' => false]);
        }catch (Exception $exception){
            Log::error($exception->getMessage());
        }
    }
}
