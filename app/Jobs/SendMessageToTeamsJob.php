<?php

namespace App\Jobs;

use App\Notifications\Dto\TeamsMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendMessageToTeamsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private TeamsMessage $message,
        private string $webhookUrl
    ) {
        $this->onQueue('high');
    }

    public function handle(): void
    {
        Http::post($this->webhookUrl, $this->message->toArray());
    }
}