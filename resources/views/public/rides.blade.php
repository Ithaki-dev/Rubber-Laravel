<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buscar Rides - Aventones</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Navigation -->
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-xl font-bold">Aventones</h1>
                    </div>
                    <div class="flex items-center gap-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-gray-900">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900">Iniciar Sesión</a>
                            <a href="{{ route('register') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Registrarse
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Search Form -->
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold mb-4">Buscar Rides</h2>
                        <form method="GET" action="{{ route('rides.search') }}">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <label for="origin" class="block text-sm font-medium text-gray-700">Origen</label>
                                    <input type="text" name="origin" id="origin" value="{{ request('origin') }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="destination" class="block text-sm font-medium text-gray-700">Destino</label>
                                    <input type="text" name="destination" id="destination" value="{{ request('destination') }}" 
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="sort" class="block text-sm font-medium text-gray-700">Ordenar por</label>
                                    <select name="sort" id="sort" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="departure_time" {{ request('sort') === 'departure_time' ? 'selected' : '' }}>Fecha</option>
                                        <option value="origin" {{ request('sort') === 'origin' ? 'selected' : '' }}>Origen</option>
                                        <option value="destination" {{ request('sort') === 'destination' ? 'selected' : '' }}>Destino</option>
                                        <option value="cost" {{ request('sort') === 'cost' ? 'selected' : '' }}>Costo</option>
                                    </select>
                                </div>
                                <div class="flex items-end">
                                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                        Buscar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Results -->
                @if($rides->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($rides as $ride)
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-lg transition">
                                <div class="p-6">
                                    <h3 class="text-lg font-bold mb-2">{{ $ride->name }}</h3>
                                    <p class="text-gray-600 mb-2">
                                        <span class="font-semibold">{{ $ride->origin }}</span> → <span class="font-semibold">{{ $ride->destination }}</span>
                                    </p>
                                    <p class="text-gray-600 text-sm">{{ $ride->departure_time->format('d/m/Y H:i') }}</p>
                                    <p class="text-gray-600 text-sm">Vehículo: {{ $ride->vehicle->brand }} {{ $ride->vehicle->model }}</p>
                                    <p class="text-lg font-bold text-green-600 mt-2">₡{{ number_format($ride->cost, 2) }}</p>
                                    <p class="text-sm text-gray-500">{{ $ride->availableSeats() }} espacios disponibles</p>
                                    
                                    <div class="mt-4">
                                        @auth
                                            @if(Auth::user()->role === 'passenger')
                                                <form action="{{ route('reservations.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="ride_id" value="{{ $ride->id }}">
                                                    <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                        Reservar
                                                    </button>
                                                </form>
                                            @else
                                                <p class="text-sm text-gray-500 text-center">Solo pasajeros pueden reservar</p>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" class="block w-full bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded text-center">
                                                Inicia sesión para reservar
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $rides->links() }}
                    </div>
                @else
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 text-center">
                            <p>No se encontraron rides disponibles.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
