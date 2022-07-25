<x-filament::widget class="filament-account-widget">
    <x-filament::card>
        <div class="h-12 flex items-center space-x-4 rtl:space-x-reverse">
            <div class="w-10 h-10 rounded-lg bg-indigo-500 bg-contain bg-center font-bold flex justify-center items-center text-white text-md">{{ $this->version }}</div>

            <div>
                <h2 class="text-lg sm:text-xl font-bold tracking-tight">
                    {{ $this->name }}
                </h2>

                <p class="text-sm">
                    <a href="{{ $this->vendor_url }}" class="text-gray-600 hover:text-primary-500 focus:outline-none focus:underline">{{ $this->vendor }}</span>
                </p>
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
