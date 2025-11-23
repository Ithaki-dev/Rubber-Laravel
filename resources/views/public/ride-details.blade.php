<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $ride->name }} - Aventones</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Navigation -->
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <a href="{{ route('rides.search') }}" class="text-xl font-bold">Aventones</a>
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

        <!-- Ride Details -->
        <div class="py-12">
            <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                <div class="mb-4">
                    <a href="{{ route('rides.search') }}" class="text-blue-600 hover:text-blue-800">
                        ← Volver a la búsqueda
                    </a>
                </div>

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
                    <div class="p-6">
                        <h1 class="text-3xl font-bold mb-6">{{ $ride->name }}</h1>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Ride Information -->
                            <div class="space-y-4">
                                <h2 class="text-xl font-semibold mb-4">Información del Viaje</h2>
                                
                                <div class="flex items-start">
                                    <svg class="w-6 h-6 mr-3 text-green-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-semibold">Origen</p>
                                        <p class="text-gray-600">{{ $ride->origin }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start">
                                    <svg class="w-6 h-6 mr-3 text-red-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-semibold">Destino</p>
                                        <p class="text-gray-600">{{ $ride->destination }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start">
                                    <svg class="w-6 h-6 mr-3 text-blue-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-semibold">Fecha y Hora de Salida</p>
                                        <p class="text-gray-600">{{ $ride->departure_time->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start">
                                    <svg class="w-6 h-6 mr-3 text-purple-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-semibold">Asientos Disponibles</p>
                                        <p class="text-gray-600">{{ $ride->availableSeats() }} de {{ $ride->seats }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Vehicle and Price -->
                            <div class="space-y-4">
                                <h2 class="text-xl font-semibold mb-4">Vehículo y Precio</h2>
                                
                                <div class="flex items-start">
                                    <svg class="w-6 h-6 mr-3 text-gray-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"></path>
                                    </svg>
                                    <div>
                                        <p class="font-semibold">Vehículo</p>
                                        <p class="text-gray-600">{{ $ride->vehicle->brand }} {{ $ride->vehicle->model }}</p>
                                        <p class="text-sm text-gray-500">{{ $ride->vehicle->color }} - {{ $ride->vehicle->year }}</p>
                                        <p class="text-sm text-gray-500">Placa: {{ $ride->vehicle->plate }}</p>
                                        <p class="text-sm text-gray-500">Capacidad: {{ $ride->vehicle->capacity }} personas</p>
                                    </div>
                                </div>

                                <div class="flex items-start">
                                    <svg class="w-6 h-6 mr-3 text-yellow-600 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-semibold">Costo por Persona</p>
                                        <p class="text-3xl font-bold text-green-600">₡{{ number_format($ride->cost, 2) }}</p>
                                    </div>
                                </div>

                                <!-- Reservation Button -->
                                <div class="mt-6 pt-6 border-t">
                                    @if($canReserve)
                                        @if($hasReservation)
                                            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                                                Ya tienes una reserva para este ride.
                                            </div>
                                        @elseif($ride->availableSeats() > 0)
                                            <form action="{{ route('reservations.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="ride_id" value="{{ $ride->id }}">
                                                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded text-lg">
                                                    Reservar Ahora
                                                </button>
                                            </form>
                                        @else
                                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                                No hay asientos disponibles.
                                            </div>
                                        @endif
                                    @elseif(auth()->check())
                                        <div class="bg-gray-100 border border-gray-400 text-gray-700 px-4 py-3 rounded">
                                            Solo los pasajeros pueden reservar rides.
                                        </div>
                                    @else
                                        <a href="{{ route('login') }}" class="block w-full bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-4 rounded text-center text-lg">
                                            Inicia sesión para reservar
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
