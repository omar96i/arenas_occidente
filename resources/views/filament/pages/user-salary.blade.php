<x-filament-panels::page>
    @vite(['resources/js/app.js'])
    <div id="app">
        <user-summary :entities="{{$entities}}" :segments="{{$segments}}"></user-summary>
    </div>
</x-filament-panels::page>
