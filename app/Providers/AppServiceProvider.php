<?php

namespace App\Providers;

use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use Filament\Forms\Components;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use RyanChandler\FilamentTools\Tools;
use RyanChandler\FilamentTools\Tool;
use RyanChandler\FilamentTools\ToolInput;
use ZipArchive;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Config::set('filament.path', config('astral-cms.admin-path'));

        Filament::registerPages([
            \App\Filament\Pages\Profile::class
        ]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Filament::serving(function(): void {
            Filament::registerTheme(mix('css/theme.css'));
        });

        Filament::registerNavigationGroups([
            'Administration',
            'Content',
            'Settings',
        ]);

        Tools::can(function (User $user): bool {
            return ($user->admin || $user->super_admin);
        });

        Tools::navigationIcon('heroicon-o-scissors');
        Tools::navigationGroup('Administration');

        Tools::register(function (Tool $tool): Tool {
            return $tool->label('Destroy')->schema([
                Components\Select::make('objects')->label('Objects to Destroy')->options([
                    'cache'        => 'Cache',
                    'view-cache'   => 'Views Cache',
                    'config-cache' => 'Config Cache'
                ])->required()
            ])->onSubmit(function(ToolInput $input) {
                if( $input->get('objects') == 'cache' ) {
                    cache()->flush();

                    $input->notify('success', 'Successfully destroyed cache.');
                }
            });
        });

        Tools::register(function (Tool $tool): Tool {
            return $tool->label('Updater')->schema([
                Components\View::make('filament.tools.updater'),
                Components\Select::make('confirm')->label('Confirm the Update')->options([
                    'ready' => 'I\'m ready to Update',
                ])->required()
            ])->onSubmit(function(ToolInput $input) {                
                if($input->get('confirm')) {
                    if(File::exists( base_path('upload.zip') )) {
                        if( class_exists( 'ZipArchive' ) ) {
                            $zip = new ZipArchive();
                            $res = $zip->open(base_path('upload.zip'));
    
                            if($res === TRUE) {
                                $env = File::get(base_path('.env'));
                                $zip->extractTo(base_path());
                                $zip->close();
    
                                File::put(base_path('.env'), $env);
    
                                Artisan::call('migrate --force --database=mysql');
                                File::delete(base_path('upload.zip'));
    
                                $input->notify('success', 'Updated script to the newer version successfully!');
                            }
                        } else
                            $input->notify('danger', 'Zip Archive Extension not installed or Enabled. Please extract manually and run migrations using the command line.');
                    } else
                        $input->notify('danger', 'File "upload.zip" not found in the root of the website.');
                } else
                    $input->notify('danger', 'Please confirm the update.');
            });
        });
    }
}
