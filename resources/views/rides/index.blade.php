<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mis Rides') }}
            </h2>
            <a href="{{ route('rides.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Crear Ride
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

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($rides->count() > 0)
                        <div class="space-y-4">
                            @foreach($rides as $ride)
                                <div class="border rounded-lg p-4 hover:shadow-lg transition">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-bold">{{ $ride->name }}</h3>
                                            <p class="text-gray-600 mt-2">
                                                <span class="font-semibold">Ruta:</span> {{ $ride->origin }} → {{ $ride->destination }}
                                            </p>
                                            <p class="text-gray-600">
                                                <span class="font-semibold">Vehículo:</span> {{ $ride->vehicle->brand }} {{ $ride->vehicle->model }} ({{ $ride->vehicle->plate }})
                                            </p>
                                            <p class="text-gray-600">
                                                <span class="font-semibold">Salida:</span> {{ $ride->departure_time->format('d/m/Y H:i') }}
                                            </p>
                                            <p class="text-gray-600">
                                                <span class="font-semibold">Costo:</span> ₡{{ number_format($ride->cost, 2) }}
                                            </p>
                                            <p class="text-gray-600">
                                                <span class="font-semibold">Espacios:</span> {{ $ride->availableSeats() }}/{{ $ride->seats }} disponibles
                                            </p>
                                            <p class="text-sm text-gray-500 mt-2">
                                                Reservas: {{ $ride->reservations->count() }} 
                                                ({{ $ride->reservations->where('status', 'pending')->count() }} pendientes)
                                            </p>
                                        </div>
                                        <div class="flex flex-col gap-2 ml-4">
                                            <a href="{{ route('rides.show', $ride) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm text-center">
                                                Ver
                                            </a>
                                            <a href="{{ route('rides.edit', $ride) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded text-sm text-center">
                                                Editar
                                            </a>
                                            <form action="{{ route('rides.destroy', $ride) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este ride?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600">No tienes rides registrados. <a href="{{ route('rides.create') }}" class="text-blue-500 hover:underline">Crea uno ahora</a>.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
