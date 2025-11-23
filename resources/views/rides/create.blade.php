<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Ride') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('rides.store') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Name -->
                            <div class="md:col-span-2">
                                <x-input-label for="name" value="Nombre del Ride" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Vehicle -->
                            <div class="md:col-span-2">
                                <x-input-label for="vehicle_id" value="Vehículo" />
                                <select id="vehicle_id" name="vehicle_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Seleccione un vehículo</option>
                                    @foreach($vehicles as $vehicle)
                                        <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                            {{ $vehicle->brand }} {{ $vehicle->model }} - {{ $vehicle->plate }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('vehicle_id')" class="mt-2" />
                            </div>

                            <!-- Origin -->
                            <div>
                                <x-input-label for="origin" value="Origen" />
                                <x-text-input id="origin" class="block mt-1 w-full" type="text" name="origin" :value="old('origin')" required />
                                <x-input-error :messages="$errors->get('origin')" class="mt-2" />
                            </div>

                            <!-- Destination -->
                            <div>
                                <x-input-label for="destination" value="Destino" />
                                <x-text-input id="destination" class="block mt-1 w-full" type="text" name="destination" :value="old('destination')" required />
                                <x-input-error :messages="$errors->get('destination')" class="mt-2" />
                            </div>

                            <!-- Departure Time -->
                            <div>
                                <x-input-label for="departure_time" value="Fecha y Hora de Salida" />
                                <x-text-input id="departure_time" class="block mt-1 w-full" type="datetime-local" name="departure_time" :value="old('departure_time')" required />
                                <x-input-error :messages="$errors->get('departure_time')" class="mt-2" />
                            </div>

                            <!-- Cost -->
                            <div>
                                <x-input-label for="cost" value="Costo por Espacio (₡)" />
                                <x-text-input id="cost" class="block mt-1 w-full" type="number" step="0.01" name="cost" :value="old('cost')" required min="0" />
                                <x-input-error :messages="$errors->get('cost')" class="mt-2" />
                            </div>

                            <!-- Seats -->
                        <div>
                            <x-input-label for="seats" value="Asientos Disponibles" />
                            <x-text-input id="seats" class="block mt-1 w-full" type="number" name="seats" :value="old('seats')" required min="1" />
                            <p class="text-sm text-gray-500 mt-1">Máximo: capacidad del vehículo - 1 (chofer)</p>
                            <x-input-error :messages="$errors->get('seats')" class="mt-2" />
                        </div>
                        </div>

                        <div class="flex items-center justify-end mt-4 gap-4">
                            <a href="{{ route('rides.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md">
                                Cancelar
                            </a>
                            <x-primary-button>
                                Crear Ride
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
