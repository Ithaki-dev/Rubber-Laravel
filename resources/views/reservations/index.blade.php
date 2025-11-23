<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Reservas') }}
        </h2>
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
                    @if($reservations->count() > 0)
                        <div class="space-y-4">
                            @foreach($reservations as $reservation)
                                <div class="border rounded-lg p-4 {{ $reservation->status === 'pending' ? 'bg-yellow-50' : '' }}">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-bold">{{ $reservation->ride->name }}</h3>
                                            <p class="text-gray-600 mt-2">
                                                <span class="font-semibold">Ruta:</span> {{ $reservation->ride->origin }} → {{ $reservation->ride->destination }}
                                            </p>
                                            <p class="text-gray-600">
                                                <span class="font-semibold">Salida:</span> {{ $reservation->ride->departure_time->format('d/m/Y H:i') }}
                                            </p>
                                            <p class="text-gray-600">
                                                <span class="font-semibold">Costo:</span> ₡{{ number_format($reservation->ride->cost, 2) }}
                                            </p>
                                            
                                            @if(Auth::user()->role === 'passenger')
                                                <p class="text-gray-600">
                                                    <span class="font-semibold">Chofer:</span> {{ $reservation->ride->user->name }} {{ $reservation->ride->user->surname }}
                                                </p>
                                                <p class="text-gray-600">
                                                    <span class="font-semibold">Vehículo:</span> {{ $reservation->ride->vehicle->brand }} {{ $reservation->ride->vehicle->model }} ({{ $reservation->ride->vehicle->plate }})
                                                </p>
                                            @else
                                                <p class="text-gray-600">
                                                    <span class="font-semibold">Pasajero:</span> {{ $reservation->passenger->name }} {{ $reservation->passenger->surname }}
                                                </p>
                                                <p class="text-gray-600">
                                                    <span class="font-semibold">Contacto:</span> {{ $reservation->passenger->phone }}
                                                </p>
                                            @endif
                                            
                                            <p class="text-sm text-gray-500 mt-2">
                                                Solicitado: {{ $reservation->created_at->format('d/m/Y H:i') }}
                                            </p>
                                            <p class="text-sm mt-1">
                                                <span class="px-2 py-1 rounded text-white
                                                    {{ $reservation->status === 'pending' ? 'bg-yellow-500' : '' }}
                                                    {{ $reservation->status === 'accepted' ? 'bg-green-500' : '' }}
                                                    {{ $reservation->status === 'rejected' ? 'bg-red-500' : '' }}
                                                    {{ $reservation->status === 'cancelled' ? 'bg-gray-500' : '' }}">
                                                    {{ ucfirst($reservation->status) }}
                                                </span>
                                            </p>
                                        </div>
                                        
                                        @if(Auth::user()->role === 'passenger' && in_array($reservation->status, ['pending', 'accepted']))
                                            <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" onsubmit="return confirm('¿Estás seguro de cancelar esta reserva?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm">
                                                    Cancelar Reserva
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if(Auth::user()->role === 'driver' && $reservation->status === 'pending')
                                            <div class="flex gap-2">
                                                <form action="{{ route('reservations.accept', $reservation) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                                                        Aceptar
                                                    </button>
                                                </form>
                                                <form action="{{ route('reservations.reject', $reservation) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm">
                                                        Rechazar
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600">No tienes reservas. 
                            @if(Auth::user()->role === 'passenger')
                                <a href="{{ route('rides.search') }}" class="text-blue-500 hover:underline">Busca rides disponibles</a>.
                            @endif
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
