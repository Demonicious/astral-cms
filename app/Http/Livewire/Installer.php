<?php

namespace App\Http\Livewire;

use App\Bitflan;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Livewire\Component;

class Installer extends Component
{
    public $name, $version, $activate_link;

    /*
     * 0 = Requirements
     * 1 = License
     * 2 = Database
     * 3 = Admin Login
     */

    public $stage = 0;

    public $licenseKey   = '';
    public $licenseError = false;

    public $dbUsername   = '';
    public $dbPassword   = '';
    public $dbName       = '';
    public $dbPort       = '3306';
    public $dbHost       = '127.0.0.1';
    public $dbError      = false;

    public $adminName                  = '';
    public $adminPassword              = '';
    public $adminPassword_confirmation = '';
    public $adminEmail                 = '';
    public $webUrl                     = '';

    public function requirements() {
        $extensions = get_loaded_extensions();
        /*
            [
                'LABEL',
                Function that returns true or false based on found or not.
                True or False if REQUIRED
            ]
        */
        return [
            [
                'Minimum PHP 8.x.',
                fn() => version_compare(phpversion(), '8.0.0') >= 0,
                true,
                false
            ],
            [
                'Storage & Public Directories writable.',
                fn() => File::isWritable(storage_path()) && File::isWritable(public_path()),
                true,
                false
            ],
            [
                'BCMath',
                fn() => in_array('bcmath', $extensions),
                true,
                true
            ],
            [
                'Ctype',
                fn() => in_array('ctype', $extensions),
                true,
                true
            ],
            [
                'Fileinfo',
                fn() => in_array('fileinfo', $extensions),
                true,
                true
            ],
            [
                'JSON',
                fn() => in_array('json', $extensions),
                true,
                true
            ],
            [
                'Mbstring',
                fn() => in_array('mbstring', $extensions),
                true,
                true
            ],
            [
                'OpenSSL',
                fn() => in_array('openssl', $extensions),
                true,
                true
            ],
            [
                'PDO MySQL',
                fn() => in_array('pdo_mysql', $extensions),
                true,
                true
            ],
            [
                'Tokenizer',
                fn() => in_array('tokenizer', $extensions),
                true,
                true
            ],
            [
                'XML',
                fn() => in_array('xml', $extensions),
                true,
                true
            ],
            [
                'cURL',
                fn() => in_array('curl', $extensions),
                true,
                true
            ],
            [
                'ZIP',
                fn() => in_array('zip', $extensions),
                false,
                true
            ]
        ];
    }

    private function confirmRequirements() {
        $return = true;

        foreach($this->requirements() as $requirement) {
            if($requirement[2] == true) {
                if($requirement[1]() != true) {
                    $return = false;
                }
            }
        }

        return $return;
    }

    public function submitRequirements() {
        if( $this->confirmRequirements() ) {
            File::put( storage_path('bitflan/requirements.stp'), 'true' );

            $this->stage = 1;
        }
    }

    public function submitDb() {
        $this->validate([
            'dbUsername' => 'required',
            'dbName' => 'required',
            'dbPort' => 'required|numeric',
            'dbHost' => 'required'
        ]);

        Config::set("database.connections.mysql.host", $this->dbHost);
        Config::set("database.connections.mysql.database", $this->dbName);
        Config::set("database.connections.mysql.username", $this->dbUsername);
        Config::set("database.connections.mysql.password", $this->dbPassword);
        Config::set("database.connections.mysql.port", $this->dbPort);

        try {
            DB::connection('mysql');

            $env = File::get( base_path( '.env' ) );

            $env = str_replace( [
                'DB_USERNAME=root',
                'DB_PASSWORD=db',
                'DB_DATABASE=filesflan',
                'DB_PORT=3306',
                'DB_HOST=127.0.0.1'
            ], [
                'DB_USERNAME=' . $this->dbUsername,
                'DB_PASSWORD=' . $this->dbPassword,
                'DB_DATABASE=' . $this->dbName,
                'DB_PORT=' . $this->dbPort,
                'DB_HOST=' . $this->dbHost
            ], $env );

            Artisan::call('migrate --force --database=mysql');

            File::put( base_path( '.env' ), $env );
            
            File::put( storage_path( 'bitflan/database.stp' ), 'true' );

            $this->stage = 2;
        } catch (\Exception $e) {
            dd($e);
            $this->dbError = 'No connection to the database with these details.';
        }
    }

    public function submitAdmin() {
        $this->validate([
            'adminName' => 'required',
            'adminEmail' => 'required|email',
            'adminPassword' => 'required|min:8|confirmed',
            'webUrl' => 'required|url'
        ]);

        $user = new User();

        $user->name  = $this->adminName;
        $user->email = $this->adminEmail;
        $user->email_verified_at = now(); 
        $user->password = bcrypt($this->adminPassword);
        $user->admin = true;
        $user->super_admin = true;
        $user->avatar = '';
        
        $user->save();

        File::put( storage_path( 'bitflan/admin.stp' ), 'true' );
        File::put( storage_path( 'bitflan/installed.stp' ), 'true' );

        $env = File::get( base_path( '.env' ) );

        $env = str_replace( ['APP_URL=http://localhost', 'APP_ENV=local'], ['APP_URL=' . trim($this->webUrl, ' \\/'), 'APP_ENV=production'], $env );

        File::put( base_path( '.env' ), $env );

        Filament::notify('success', 'Installation Successful!', true);

        redirect( route('filament.auth.login') );
    }

    public function mount() {
        $this->webUrl = url('/');

        if( env('APP_KEY') == 'base64:oOvONYryAnjXFKlC/aSEr6yRYOVSNxoUp6YTyKQDTtg=' ) {
            Artisan::call('key:generate');
            Artisan::call('storage:link');
            return redirect( request()->url() );
        }

        $this->name          = Bitflan::Name;
        $this->version       = Bitflan::Version;

        $stage = 0;

        if( File::exists( storage_path( 'bitflan/requirements.stp' ) ) )
            $stage = 1;

        if( File::exists( storage_path( 'bitflan/database.stp' ) ) )
            $stage = 2;

        if( File::exists( storage_path( 'bitflan/admin.stp' ) ) ) {
            File::put( storage_path( 'bitflan/installed.stp' ), 'true' );

            return redirect('/');
        }

        $this->stage = $stage;
    }
    
    public function render()
    {
        return view('install.livewire');
    }
}
