<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $ride->name }}
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

            <!-- Ride Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Detalles del Ride</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600"><span class="font-semibold">Ruta:</span> {{ $ride->origin }} → {{ $ride->destination }}</p>
                            <p class="text-gray-600"><span class="font-semibold">Salida:</span> {{ $ride->departure_time->format('d/m/Y H:i') }}</p>
                            <p class="text-gray-600"><span class="font-semibold">Costo:</span> ₡{{ number_format($ride->cost, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600"><span class="font-semibold">Vehículo:</span> {{ $ride->vehicle->brand }} {{ $ride->vehicle->model }}</p>
                            <p class="text-gray-600"><span class="font-semibold">Placa:</span> {{ $ride->vehicle->plate }}</p>
                            <p class="text-gray-600"><span class="font-semibold">Espacios:</span> {{ $ride->availableSeats() }}/{{ $ride->seats }} disponibles</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reservations -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Reservas ({{ $ride->reservations->count() }})</h3>
                    
                    @if($ride->reservations->count() > 0)
                        <div class="space-y-4">
                            @foreach($ride->reservations as $reservation)
                                <div class="border rounded-lg p-4 {{ $reservation->status === 'pending' ? 'bg-yellow-50' : '' }}">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-semibold">{{ $reservation->passenger->name }} {{ $reservation->passenger->surname }}</p>
                                            <p class="text-sm text-gray-600">{{ $reservation->passenger->email }}</p>
                                            <p class="text-sm text-gray-600">{{ $reservation->passenger->phone }}</p>
                                            <p class="text-sm text-gray-500 mt-2">Solicitado: {{ $reservation->created_at->format('d/m/Y H:i') }}</p>
                                            <p class="text-sm">
                                                <span class="px-2 py-1 rounded text-white
                                                    {{ $reservation->status === 'pending' ? 'bg-yellow-500' : '' }}
                                                    {{ $reservation->status === 'accepted' ? 'bg-green-500' : '' }}
                                                    {{ $reservation->status === 'rejected' ? 'bg-red-500' : '' }}
                                                    {{ $reservation->status === 'cancelled' ? 'bg-gray-500' : '' }}">
                                                    {{ ucfirst($reservation->status) }}
                                                </span>
                                            </p>
                                        </div>
                                        
                                        @if($reservation->status === 'pending')
                                            <div class="flex gap-2">
                                                <form action="{{ route('reservations.accept', $reservation) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">
                                                        Aceptar
                                                    </button>
                                                </form>
                                                <form action="{{ route('reservations.reject', $reservation) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
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
                        <p class="text-gray-600">No hay reservas para este ride.</p>
                    @endif
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('rides.index') }}" class="text-blue-500 hover:underline">← Volver a mis rides</a>
            </div>
        </div>
    </div>
</x-app-layout>
