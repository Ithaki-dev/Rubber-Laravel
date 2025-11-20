<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Agregar Vehículo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('vehicles.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Plate -->
                            <div>
                                <x-input-label for="plate" value="Placa" />
                                <x-text-input id="plate" class="block mt-1 w-full" type="text" name="plate" :value="old('plate')" required />
                                <x-input-error :messages="$errors->get('plate')" class="mt-2" />
                            </div>

                            <!-- Brand -->
                            <div>
                                <x-input-label for="brand" value="Marca" />
                                <x-text-input id="brand" class="block mt-1 w-full" type="text" name="brand" :value="old('brand')" required />
                                <x-input-error :messages="$errors->get('brand')" class="mt-2" />
                            </div>

                            <!-- Model -->
                            <div>
                                <x-input-label for="model" value="Modelo" />
                                <x-text-input id="model" class="block mt-1 w-full" type="text" name="model" :value="old('model')" required />
                                <x-input-error :messages="$errors->get('model')" class="mt-2" />
                            </div>

                            <!-- Year -->
                            <div>
                                <x-input-label for="year" value="Año" />
                                <x-text-input id="year" class="block mt-1 w-full" type="number" name="year" :value="old('year')" required min="1900" :max="date('Y') + 1" />
                                <x-input-error :messages="$errors->get('year')" class="mt-2" />
                            </div>

                            <!-- Color -->
                            <div>
                                <x-input-label for="color" value="Color" />
                                <x-text-input id="color" class="block mt-1 w-full" type="text" name="color" :value="old('color')" required />
                                <x-input-error :messages="$errors->get('color')" class="mt-2" />
                            </div>

                            <!-- Capacity -->
                            <div>
                                <x-input-label for="capacity" value="Capacidad (personas)" />
                                <x-text-input id="capacity" class="block mt-1 w-full" type="number" name="capacity" :value="old('capacity')" required min="1" max="50" />
                                <x-input-error :messages="$errors->get('capacity')" class="mt-2" />
                            </div>

                            <!-- Photo -->
                            <div class="md:col-span-2">
                                <x-input-label for="photo" value="Fotografía del Vehículo" />
                                <input id="photo" class="block mt-1 w-full" type="file" name="photo" accept="image/*" />
                                <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4 gap-4">
                            <a href="{{ route('vehicles.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md">
                                Cancelar
                            </a>
                            <x-primary-button>
                                Guardar Vehículo
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
