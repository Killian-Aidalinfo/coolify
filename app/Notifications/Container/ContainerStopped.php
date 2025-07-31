<?php

namespace App\Notifications\Container;

use App\Models\Server;
use App\Notifications\CustomEmailNotification;
use App\Notifications\Dto\DiscordMessage;
use App\Notifications\Dto\PushoverMessage;
use App\Notifications\Dto\SlackMessage;
use App\Notifications\Dto\TeamsMessage;
use Illuminate\Notifications\Messages\MailMessage;

class ContainerStopped extends CustomEmailNotification
{
    public function __construct(public string $name, public Server $server, public ?string $url = null)
    {
        $this->onQueue('high');
    }

    public function via(object $notifiable): array
    {
        return $notifiable->getEnabledChannels('status_change');
    }

    public function toMail(): MailMessage
    {
        $mail = new MailMessage;
        $mail->subject("Coolify: A resource  has been stopped unexpectedly on {$this->server->name}");
        $mail->view('emails.container-stopped', [
            'containerName' => $this->name,
            'serverName' => $this->server->name,
            'url' => $this->url,
        ]);

        return $mail;
    }

    public function toDiscord(): DiscordMessage
    {
        $message = new DiscordMessage(
            title: ':cross_mark: Resource stopped',
            description: "{$this->name} has been stopped unexpectedly on {$this->server->name}.",
            color: DiscordMessage::errorColor(),
        );

        if ($this->url) {
            $message->addField('Resource', '[Link]('.$this->url.')');
        }

        return $message;
    }

    public function toTelegram(): array
    {
        $message = "Coolify: A resource ($this->name) has been stopped unexpectedly on {$this->server->name}";
        $payload = [
            'message' => $message,
        ];
        if ($this->url) {
            $payload['buttons'] = [
                [
                    [
                        'text' => 'Open Application in Coolify',
                        'url' => $this->url,
                    ],
                ],
            ];
        }

        return $payload;
    }

    public function toPushover(): PushoverMessage
    {
        $buttons = [];
        if ($this->url) {
            $buttons[] = [
                'text' => 'Open Application in Coolify',
                'url' => $this->url,
            ];
        }

        return new PushoverMessage(
            title: 'Resource stopped',
            level: 'error',
            message: "A resource ({$this->name}) has been stopped unexpectedly on {$this->server->name}",
            buttons: $buttons,
        );
    }

    public function toSlack(): SlackMessage
    {
        $title = 'Resource stopped';
        $description = "A resource ({$this->name}) has been stopped unexpectedly on {$this->server->name}";

        if ($this->url) {
            $description .= "\n*Resource URL:* {$this->url}";
        }

        return new SlackMessage(
            title: $title,
            description: $description,
            color: SlackMessage::errorColor()
        );
    }

    public function toTeams(): TeamsMessage
    {
        $message = new TeamsMessage(
            title: "Resource {$this->name} stopped unexpectedly",
            summary: "Resource stopped unexpectedly",
            themeColor: TeamsMessage::COLOR_ERROR
        );

        $message->addSection(
            title: 'Resource Information',
            facts: [
                ['Resource', $this->name],
                ['Server', $this->server->name],
                ['Status', 'Stopped Unexpectedly'],
            ]
        );

        $message->addSection(
            text: 'The resource has been stopped unexpectedly. Please check the application logs for more information.'
        );

        if ($this->url) {
            $message->addAction('View Resource', $this->url);
        }

        return $message;
    }
}
