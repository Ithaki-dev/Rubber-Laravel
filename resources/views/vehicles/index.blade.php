<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mis Vehículos') }}
            </h2>
            <a href="{{ route('vehicles.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Agregar Vehículo
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($vehicles->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($vehicles as $vehicle)
                                <div class="border rounded-lg p-4 hover:shadow-lg transition">
                                    @if($vehicle->photo)
                                        <img src="{{ asset('storage/' . $vehicle->photo) }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}" class="w-full h-48 object-cover rounded mb-4">
                                    @else
                                        <div class="w-full h-48 bg-gray-200 rounded mb-4 flex items-center justify-center">
                                            <span class="text-gray-400">Sin foto</span>
                                        </div>
                                    @endif
                                    
                                    <h3 class="text-lg font-bold">{{ $vehicle->brand }} {{ $vehicle->model }}</h3>
                                    <p class="text-gray-600">Placa: {{ $vehicle->plate }}</p>
                                    <p class="text-gray-600">Año: {{ $vehicle->year }}</p>
                                    <p class="text-gray-600">Color: {{ $vehicle->color }}</p>
                                    <p class="text-gray-600">Capacidad: {{ $vehicle->capacity }} personas</p>
                                    
                                    <div class="mt-4 flex gap-2">
                                        <a href="{{ route('vehicles.edit', $vehicle) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded text-sm">
                                            Editar
                                        </a>
                                        <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este vehículo?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600">No tienes vehículos registrados. <a href="{{ route('vehicles.create') }}" class="text-blue-500 hover:underline">Agrega uno ahora</a>.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
