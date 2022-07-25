<?php

namespace App\Filament\Pages;

use App\Filament\Extensions\BitflanSettingsPage;
use App\Settings\GeneralSettings;
use Filament\Forms\Components;

class ManageGeneralSettings extends BitflanSettingsPage
{
    protected static ?string $navigationLabel = 'General Settings';
    protected static ?string $navigationIcon  = 'heroicon-o-cog';
    protected static ?string $navigationGroup = 'Administration';

    protected static string $settings = GeneralSettings::class;

    protected function getFormSchema(): array
    {
        return [
            Components\Card::make([
                Components\TextInput::make('websiteTitle')->placeholder('Title of your Website')->helperText('This is appended to the title of every page.')->required()->columnSpan(2),
                Components\Textarea::make('websiteDescription')->placeholder('The Meta Description of your Website.')->helperText('This may be used as the Meta-description of your home-page.')->required()->rows(4)->columnSpan(2),
                Components\FileUpload::make('logo')->image()->columnSpan(2),
                Components\FileUpload::make('favicon')->image()->columnSpan(2),
                Components\Toggle::make('contactPage')->columnSpan(2)->label('Enable the Contact Page on your Website.')->helperText('You can edit your E-mail sending credentials from the `.env` file at the Root of your website.')
            ])->columns(2),

            Components\Card::make([
                Components\Repeater::make('links')->helperText('Add static links to the Header / Footer of your website.')->schema([
                    Components\TextInput::make('label')->label('Label')->required(),
                    Components\TextInput::make('url')->label('URL')->required(),
                    Components\Select::make('location')->required()->options([
                        'header' => 'Header',
                        'footer' => 'Footer',
                        'both'   => 'Both'
                    ]),
                    Components\Toggle::make('newTab')->label('Open in New Tab')
                ])
            ]),

            Components\Card::make([
                Components\TextInput::make('gaId')->label('Google Analytics ID')->columnSpan(2),

                Components\Textarea::make('customStyles')->label('Custom CSS')->rows(4)->columnSpan(1),
                Components\Textarea::make('headerTags')->label('Custom Header Tags')->rows(4)->columnSpan(1),

                Components\Repeater::make('styles')->label('Custom Stylesheets')->schema([
                    Components\TextInput::make('url')->label('URL')->required()
                ])->columnSpan(1),

                Components\Repeater::make('scripts')->label('Custom Scripts')->schema([
                    Components\TextInput::make('url')->label('URL')->required(),
                    Components\Select::make('location')->required()->options([
                        'header' => 'Header',
                        'footer' => 'Footer'
                    ])
                ])->columnSpan(1),
            ])->columns(2)
        ];
    }
}
