<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Usuario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Name -->
                            <div>
                                <x-input-label for="name" value="Nombre" />
                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- Surname -->
                            <div>
                                <x-input-label for="surname" value="Apellido" />
                                <x-text-input id="surname" class="block mt-1 w-full" type="text" name="surname" :value="old('surname', $user->surname)" required />
                                <x-input-error :messages="$errors->get('surname')" class="mt-2" />
                            </div>

                            <!-- Cedula -->
                            <div>
                                <x-input-label for="cedula" value="Cédula" />
                                <x-text-input id="cedula" class="block mt-1 w-full" type="text" name="cedula" :value="old('cedula', $user->cedula)" required />
                                <x-input-error :messages="$errors->get('cedula')" class="mt-2" />
                            </div>

                            <!-- Birthdate -->
                            <div>
                                <x-input-label for="birthdate" value="Fecha de Nacimiento" />
                                <x-text-input id="birthdate" class="block mt-1 w-full" type="date" name="birthdate" :value="old('birthdate', $user->birthdate->format('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('birthdate')" class="mt-2" />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-input-label for="email" value="Email" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Phone -->
                            <div>
                                <x-input-label for="phone" value="Teléfono" />
                                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone', $user->phone)" required />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>

                            <!-- Role -->
                            <div>
                                <x-input-label for="role" value="Rol" />
                                <select id="role" name="role" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrador</option>
                                    <option value="driver" {{ old('role', $user->role) === 'driver' ? 'selected' : '' }}>Chofer</option>
                                    <option value="passenger" {{ old('role', $user->role) === 'passenger' ? 'selected' : '' }}>Pasajero</option>
                                </select>
                                <x-input-error :messages="$errors->get('role')" class="mt-2" />
                            </div>

                            <!-- Status -->
                            <div>
                                <x-input-label for="status" value="Estado" />
                                <select id="status" name="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Activo</option>
                                    <option value="pending" {{ old('status', $user->status) === 'pending' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Inactivo</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <!-- Current Photo -->
                            @if($user->photo)
                                <div class="md:col-span-2">
                                    <x-input-label value="Foto Actual" />
                                    <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}" class="mt-2 w-32 h-32 object-cover rounded">
                                </div>
                            @endif

                            <!-- Photo -->
                            <div class="md:col-span-2">
                                <x-input-label for="photo" value="Nueva Fotografía (opcional)" />
                                <input id="photo" class="block mt-1 w-full" type="file" name="photo" accept="image/*" />
                                <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div>
                                <x-input-label for="password" value="Nueva Contraseña (opcional)" />
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Password Confirmation -->
                            <div>
                                <x-input-label for="password_confirmation" value="Confirmar Contraseña" />
                                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4 gap-4">
                            <a href="{{ route('admin.users') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md">
                                Cancelar
                            </a>
                            <x-primary-button>
                                Actualizar Usuario
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
