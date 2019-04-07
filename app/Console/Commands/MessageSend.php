<?php

namespace App\Console\Commands;

use App\Jobs\DispatchMessage;
use Illuminate\Console\Command;

class MessageSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:message-send';

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
        $this->info('Testing Message Dispatch');

        $recipient = [
            "id" => "1",
			"phone" => "+0490928809",
			"first_name" => "Kyle",
			"last_name" => "Waters"
        ];

        $recipient = collect($recipient);

        $this->info('Queuing Message Dispatch');

        DispatchMessage::dispatch('sms', $recipient, "Test message for {first_name}", 'sms-dervelopment-2');

        $this->info('Should be queued....');
    }
}
