<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings {
    public ?string $websiteTitle;
    public string $websiteDescription;

    public ?string $logo;
    public ?string $favicon;
    public ?string $headerTags;
    public ?bool   $contactPage;

    public ?array $links;
    public ?array $styles;
    public ?array $scripts;

    public ?string $customStyles;
    public ?string $gaId;

    public static function group(): string {
        return 'general';
    }
}