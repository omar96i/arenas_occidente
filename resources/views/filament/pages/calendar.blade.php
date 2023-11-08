<x-filament-panels::page>
    <x-filament::modal width="7xl" :close-by-clicking-away="false" :close-button="false">
        <x-slot name="trigger">
            <x-filament::button>
                Crear un nuevo turno
            </x-filament::button>
        </x-slot>
        <x-slot name="heading">
            Crear un nuevo turno
        </x-slot>
        <form>
            <div>
                <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                    Selecciona un contrato<sup class="text-danger-600 dark:text-danger-400 font-medium">*</sup>
                </span>
                <x-filament::input.wrapper :valid="! $errors->has('entity_form')">
                    <x-filament::input.select wire:model="entity_form" wire:change="getData()">
                        <option value="">Selecciona un contrato</option>
                        @foreach ($entities as $entity)
                            <option value="{{ $entity->id }}">{{ $entity->name }}</option>
                        @endforeach
                    </x-filament::input.select>
                </x-filament::input.wrapper>
            </div>
            <div>
                <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                    Selecciona un segmento<sup class="text-danger-600 dark:text-danger-400 font-medium">*</sup>
                </span>
                <x-filament::input.wrapper :valid="! $errors->has('segment_form')">
                    <x-filament::input.select wire:model="segment_form">
                        <option value="">Selecciona un segmento</option>
                        @foreach ($segments as $segment)
                            <option value="{{ $segment->id }}">{{ $segment->name }}</option>
                        @endforeach
                    </x-filament::input.select>
                </x-filament::input.wrapper>
            </div>

            <div>
                <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                    Selecciona una medida<sup class="text-danger-600 dark:text-danger-400 font-medium">*</sup>
                </span>
                <x-filament::input.wrapper :valid="! $errors->has('measure_form')">
                    <x-filament::input.select wire:model="measure_form">
                        <option value="">Selecciona una medida</option>
                        @foreach ($measures as $measure)
                            <option value="{{ $measure->id }}">{{ $measure->name }}</option>
                        @endforeach
                    </x-filament::input.select>
                </x-filament::input.wrapper>
            </div>

            <div>
                <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                    Selecciona un usuario<sup class="text-danger-600 dark:text-danger-400 font-medium">*</sup>
                </span>
                <x-filament::input.wrapper :valid="! $errors->has('user_form')">
                    <x-filament::input.select wire:model="user_form">
                        <option value="">Selecciona un usuario</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </x-filament::input.select>
                </x-filament::input.wrapper>
            </div>
            <div>
                <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                    Selecciona una fecha<sup class="text-danger-600 dark:text-danger-400 font-medium">*</sup>
                </span>
                <x-filament::input.wrapper :valid="! $errors->has('date_form')">
                    <x-filament::input
                        type="date"
                        wire:model="date_form"
                    />
                </x-filament::input.wrapper>
            </div>
        </form>

        <div>
            <x-filament::button wire:click="storeShift()">
                Crear
            </x-filament::button>
            <x-filament::button color="gray" wire:click="closeModal">
                Cerrar
            </x-filament::button>
        </div>
    </x-filament::modal>

    <x-filament::section>
        <x-slot name="heading">
            Filtros
        </x-slot>
        <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
            Selecciona un contrato a buscar<sup class="text-danger-600 dark:text-danger-400 font-medium">*</sup>
        </span>
        <x-filament::input.wrapper>
            <x-filament::input.select wire:model="entity_selected">
                <option value="">Selecciona un contrato</option>
                @foreach ($entities as $entity)
                    <option value="{{ $entity->id }}">{{ $entity->name }}</option>
                @endforeach
            </x-filament::input.select>
        </x-filament::input.wrapper>
        <div>
            <x-filament::button
                icon="heroicon-m-magnifying-glass"
                icon-position="before"
                class="mt-3"
                wire:click="searchBy()"
            >
                Buscar
            </x-filament::button>
        </div>


    </x-filament::section>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            const shifts = @json($shifts);
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: shifts.map(shift => ({
                    title: shift.user.name + " - " + shift.measure.name, // Puedes cambiar esto por el título que quieras para el evento
                    start: shift.date,
                    allDay: true
                }))
            });
            setTimeout(() => {
                calendar.render();
            }, 1000);

        });

    </script>
    <x-filament::section>
        <x-slot name="heading">
            Calendario
        </x-slot>
        <div id='calendar' style="height: 300px;"></div>
    </x-filament::section>


</x-filament-panels::page>
