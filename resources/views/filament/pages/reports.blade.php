<x-filament-panels::page>
    <x-filament::section>
        <div id="app">
            <reports :entities="{{$entities}}" :segments="{{$segments}}"></reports>
        </div>
    </x-filament::section>

    @vite('resources/js/app.js')
</x-filament-panels::page>