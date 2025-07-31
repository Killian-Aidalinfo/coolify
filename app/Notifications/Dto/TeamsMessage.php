<?php

namespace App\Notifications\Dto;

class TeamsMessage
{
    public array $sections = [];
    public array $potentialAction = [];

    public function __construct(
        public string $title,
        public string $summary,
        public string $themeColor = '0078D4'
    ) {}

    public static function infoColor(): string
    {
        return '0078D4'; // Blue
    }

    public static function errorColor(): string
    {
        return 'DC3545'; // Red
    }

    public static function successColor(): string
    {
        return '28A745'; // Green
    }

    public static function warningColor(): string
    {
        return 'FFC107'; // Orange
    }

    public function addSection(string $activityTitle, string $activitySubtitle = null, string $activityText = null, array $facts = []): self
    {
        $section = [
            'activityTitle' => $activityTitle,
        ];

        if ($activitySubtitle) {
            $section['activitySubtitle'] = $activitySubtitle;
        }

        if ($activityText) {
            $section['activityText'] = $activityText;
        }

        if (!empty($facts)) {
            $section['facts'] = $facts;
        }

        $this->sections[] = $section;

        return $this;
    }

    public function addFact(string $name, string $value): self
    {
        if (empty($this->sections)) {
            $this->addSection($this->title);
        }

        $lastSectionIndex = count($this->sections) - 1;
        if (!isset($this->sections[$lastSectionIndex]['facts'])) {
            $this->sections[$lastSectionIndex]['facts'] = [];
        }

        $this->sections[$lastSectionIndex]['facts'][] = [
            'name' => $name,
            'value' => $value,
        ];

        return $this;
    }

    public function addAction(string $name, string $target): self
    {
        $this->potentialAction[] = [
            '@type' => 'OpenUri',
            'name' => $name,
            'targets' => [
                [
                    'os' => 'default',
                    'uri' => $target,
                ],
            ],
        ];

        return $this;
    }

    public function toArray(): array
    {
        $payload = [
            '@type' => 'MessageCard',
            '@context' => 'https://schema.org/extensions',
            'themeColor' => $this->themeColor,
            'summary' => $this->summary,
            'sections' => $this->sections,
        ];

        if (!empty($this->potentialAction)) {
            $payload['potentialAction'] = $this->potentialAction;
        }

        return $payload;
    }
}