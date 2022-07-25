<div class="max-w-[550px] w-full">
    <div class="w-full py-6">
        <div class="flex justify-center">
            <div class="w-1/4">
                <div class="relative mb-2">
                    <div class="w-10 h-10 mx-auto bg-indigo-500 rounded-full text-lg text-white flex items-center">
                        <span class="text-center text-white w-full">
                            <svg class="w-full fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                width="24" height="24">
                                <path class="heroicon-ui"
                                    d="M5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5c0-1.1.9-2 2-2zm14 8V5H5v6h14zm0 2H5v6h14v-6zM8 9a1 1 0 1 1 0-2 1 1 0 0 1 0 2zm0 8a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                            </svg>
                        </span>
                    </div>
                </div>
    
                <div class="text-xs text-center md:text-base">Requirements</div>
            </div>
    
            <div class="w-1/4">
                <div class="relative mb-2">
                    <div class="absolute flex align-center items-center align-middle content-center"
                        style="width: calc(100% - 2.5rem - 1rem); top: 50%; transform: translate(-50%, -50%)">
                        <div class="w-full bg-gray-200 rounded items-center align-middle align-center flex-1">
                            <div class="w-0 {{ $this->stage > 0 ? 'bg-indigo-300' : 'border-gray-200' }} py-1 rounded" style="width: 100%;"></div>
                        </div>
                    </div>
    
                    <div class="w-10 h-10 mx-auto {{ $this->stage > 0 ? 'bg-indigo-500' : 'bg-white border-2 border-gray-200' }} rounded-full text-lg text-white flex items-center">
                        <span class="text-center {{ $this->stage > 0 ? 'text-white' : 'text-gray-600' }} w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-full" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                            </svg>
                        </span>
                    </div>
                </div>
    
                <div class="text-xs text-center md:text-base">Database</div>
            </div>
    
            <div class="w-1/4">
                <div class="relative mb-2">
                    <div class="absolute flex align-center items-center align-middle content-center"
                        style="width: calc(100% - 2.5rem - 1rem); top: 50%; transform: translate(-50%, -50%)">
                        <div class="w-full bg-gray-200 rounded items-center align-middle align-center flex-1">
                            <div class="w-0 {{ $this->stage > 1 ? 'bg-indigo-300' : 'border-gray-200' }} py-1 rounded" style="width: 100%;"></div>
                        </div>
                    </div>
    
                    <div class="w-10 h-10 mx-auto {{ $this->stage > 1 ? 'bg-indigo-500' : 'bg-white border-2 border-gray-200' }} rounded-full text-lg text-white flex items-center">
                        <span class="text-center {{ $this->stage > 1 ? 'text-white' : 'text-gray-600' }} w-full">
                            <svg class="w-full fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                width="24" height="24">
                                <path class="heroicon-ui"
                                    d="M19 10h2a1 1 0 0 1 0 2h-2v2a1 1 0 0 1-2 0v-2h-2a1 1 0 0 1 0-2h2V8a1 1 0 0 1 2 0v2zM9 12A5 5 0 1 1 9 2a5 5 0 0 1 0 10zm0-2a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm8 11a1 1 0 0 1-2 0v-2a3 3 0 0 0-3-3H7a3 3 0 0 0-3 3v2a1 1 0 0 1-2 0v-2a5 5 0 0 1 5-5h5a5 5 0 0 1 5 5v2z" />
                            </svg>
                        </span>
                    </div>
                </div>
    
                <div class="text-xs text-center md:text-base">Admin Account</div>
            </div>
        </div>
    </div>
    <section class="w-full rounded bg-white shadow-md p-6">
        @if ($this->stage == 0)
            <div>
                <p>
                    <div class="flex flex-col gap-1">
                        @php
                            $first_ext = false;
                            $done      = false;
                        @endphp
                        
                        @foreach ($this->requirements() as $i => $requirement)
                            @php
                                $found = $requirement[1]();
                                $req   = $requirement[2];
                                $ext   = $requirement[3];
                                if($ext && !$first_ext && !$done) {
                                    $first_ext = true;
                                    $done      = true;
                                } else {
                                    $first_ext = false;
                                }
                                $last_ext  = $i == (count($this->requirements()) - 1);
                            @endphp

                            @if(!$ext)
                                <div class="w-full p-2 {{ $found ? 'bg-green-800 text-green-100' : ( $req ? 'bg-red-800 text-red-100' : 'bg-blue-800 text-blue-100' ) }} items-center leading-none lg:rounded-md flex lg:inline-flex" role="alert">
                                    <span class="flex rounded-md {{ $found ? 'bg-green-500' : ( $req ? 'bg-red-500' : 'bg-blue-500' ) }} uppercase px-2 py-1 text-xs font-bold mr-3">{{ $found ? 'Found' : ( $req ? 'Not Found' : 'Optional' ) }}</span>
                                    <span class="flex-auto mr-2 font-semibold text-left">{{ $requirement[0] }}</span>
                                </div>
                            @else
                                @if($first_ext)
                                <div>
                                    PHP Extensions
                                </div>
                            <div class="grid w-full grid-cols-2 gap-1">
                                @endif

                                    <div class="flex-1 w-full p-2 {{ $found ? 'bg-green-800 text-green-100' : ( $req ? 'bg-red-800 text-red-100' : 'bg-blue-800 text-blue-100' ) }} items-center leading-none lg:rounded-md inline-flex" role="alert">
                                        <span class="flex rounded-md {{ $found ? 'bg-green-500' : ( $req ? 'bg-red-500' : 'bg-blue-500' ) }} uppercase px-2 py-1 text-xs font-bold mr-3">{{ $found ? 'Found' : ( $req ? 'Not Found' : 'Optional' ) }}</span>
                                        <span class="flex-auto mr-2 font-semibold text-left">{{ $requirement[0] }}</span>
                                    </div>

                                @if($last_ext)
                            </div>
                                @endif
                            @endif
                        @endforeach
                    </div>
                </p>
            </div>

            <div class="mt-6 text-right">
                <hr />
                <button wire:loading.class="opacity-75" wire:click="submitRequirements" class="px-6 py-2 mt-6 text-white bg-indigo-600 rounded-sm cursor-pointer">Next</button>
            </div>
        @elseif ($this->stage == 1)
            <form wire:submit.prevent="submitDb">
                <div>
                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
                        <div class="flex">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                        <div>
                            <p class="font-bold">Link your MySQL Database.</p>
                            <p class="text-sm">
                                Fill in your Database Details to proceed with the installation.
                            </p>
                        </div>
                        </div>
                    </div>

                    @if($this->dbError !== false)
                        <div class="mt-3 w-full p-2 bg-red-800 text-red-100 items-center leading-none lg:rounded-full flex lg:inline-flex" role="alert">
                            <span class="flex rounded-full bg-red-500 uppercase px-2 py-1 text-xs font-bold mr-3">Error</span>
                            <span class="font-semibold mr-2 text-left flex-auto">{{ $this->dbError }}</span>
                        </div>
                    @endif
                    
                    @if(count($this->getErrorBag()))
                        <div class="mt-3 w-full p-2 bg-red-800 text-red-100 items-center leading-none lg:rounded-full flex lg:inline-flex" role="alert">
                            <span class="flex rounded-full bg-red-500 uppercase px-2 py-1 text-xs font-bold mr-3">Error</span>
                            <span class="font-semibold mr-2 text-left flex-auto">Please make sure all fields are filled in.</span>
                        </div>
                    @endif

                    <div class="flex gap-2">
                        <div class="w-1/2">
                            <label class="mt-3 block text-gray-700 text-sm font-bold mb-2" for="username">
                                Username
                            </label>
                            <input wire:model.defer="dbUsername" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="username" type="text" placeholder="Database Username">
                        </div>
                        <div class="w-1/2">
                            <label class="mt-3 block text-gray-700 text-sm font-bold mb-2" for="password">
                                Password
                            </label>
                            <input wire:model.defer="dbPassword" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password" type="password" placeholder="Database Password">
                        </div>
                    </div>

                    <div class="mt-2 flex gap-2">
                        <div class="w-1/2">
                            <label class="mt-3 block text-gray-700 text-sm font-bold mb-2" for="dbname">
                                Name
                            </label>
                            <input wire:model.defer="dbName" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="dbname" type="text" placeholder="Name of Database">
                        </div>
                        <div class="w-1/2">
                            <label class="mt-3 block text-gray-700 text-sm font-bold mb-2" for="port">
                                Port
                            </label>
                            <input wire:model.defer="dbPort" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="port" type="text" placeholder="Database Port" default="3306">
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="mt-3 block text-gray-700 text-sm font-bold mb-2" for="host">
                            Host
                        </label>
                        <input wire:model.defer="dbHost" default="localhost" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="host" type="text" placeholder="Database Host">
                    </div>

                </div>

                <div class="mt-6 text-right">
                    <hr />
                    <button wire:loading.class="opacity-75" class="mt-6 cursor-pointer bg-indigo-600 text-white rounded-sm py-2 px-6">Next</button>
                </div>
            </form>
        @elseif ($this->stage === 2)
            <form wire:submit.prevent="submitAdmin">
                <div>
                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
                        <div class="flex">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
                        <div>
                            <p class="font-bold">Create your Administrator User.</p>
                            <p class="text-sm">
                                Fill in the Login & Profile Details for the Admin.
                            </p>
                        </div>
                        </div>
                    </div>
                    
                    @if(count($this->getErrorBag()))
                        <div class="mt-3 w-full p-2 bg-red-800 text-red-100 items-center leading-none lg:rounded-full flex lg:inline-flex" role="alert">
                            <span class="flex rounded-full bg-red-500 uppercase px-2 py-1 text-xs font-bold mr-3">Error</span>
                            <span class="font-semibold mr-2 text-left flex-auto">Please make sure all fields are filled & your Password is atleast 8 characters and confirmation matches.</span>
                        </div>
                    @endif

                    <div class="mt-3">
                        <label class="mt-3 block text-gray-700 text-sm font-bold mb-2" for="admin-name">
                            Name
                        </label>
                        <input wire:model.defer="adminName" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="admin-name" type="text" placeholder="Specify Name">
                    </div>

                    <div class="mt-3">
                        <label class="mt-3 block text-gray-700 text-sm font-bold mb-2" for="admin-email">
                            E-Mail
                        </label>
                        <input wire:model.defer="adminEmail" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="admin-email" type="email" placeholder="Specify E-Mail">
                    </div>

                    <div class="flex gap-2">
                        <div class="w-1/2">
                            <label class="mt-3 block text-gray-700 text-sm font-bold mb-2" for="admin-password">
                                Password
                            </label>
                            <input wire:model.defer="adminPassword" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="admin-password" type="password" placeholder="Choose Password">
                        </div>
                        <div class="w-1/2">
                            <label class="mt-3 block text-gray-700 text-sm font-bold mb-2" for="password-confirmation">
                                Confirm
                            </label>
                            <input wire:model.defer="adminPassword_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="password-confirmation" type="password" placeholder="Confirm Password">
                        </div>
                    </div>

                    <hr>

                    <div class="mt-3">
                        <label class="mt-3 block text-gray-700 text-sm font-bold mb-2" for="web-url">
                            Website URL
                        </label>
                        <input wire:model.defer="webUrl" default="{{ url('/') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="web-url" type="text" placeholder="Specify your Complete Base URL">
                    </div>

                </div>

                <div class="mt-6 text-right">
                    <hr />
                    <button wire:loading.class="opacity-75" class="mt-6 cursor-pointer bg-indigo-600 text-white rounded-sm py-2 px-6">Finish</button>
                </div>
            </form>
            
        @endif
    </section>
    
</div>