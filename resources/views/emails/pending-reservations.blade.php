<!DOCTYPE html>
<html>
<head>
    <title>Reservas Pendientes - Aventones</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
        <h2 style="color: #FF9800;">Tienes Reservas Pendientes</h2>
        
        <p>Hola {{ $driver->name }},</p>
        
        <p>Tienes <strong>{{ $reservations->count() }}</strong> reserva(s) pendiente(s) que requieren tu atención:</p>
        
        <div style="background-color: #f9f9f9; padding: 15px; border-radius: 5px; margin: 20px 0;">
            @foreach($reservations as $reservation)
                <div style="margin-bottom: 15px; padding-bottom: 15px; border-bottom: 1px solid #ddd;">
                    <h3 style="margin: 0 0 10px 0; color: #333;">{{ $reservation->ride->name }}</h3>
                    <p style="margin: 5px 0;">
                        <strong>Pasajero:</strong> {{ $reservation->passenger->name }} {{ $reservation->passenger->surname }}<br>
                        <strong>Ruta:</strong> {{ $reservation->ride->origin }} → {{ $reservation->ride->destination }}<br>
                        <strong>Fecha de solicitud:</strong> {{ $reservation->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            @endforeach
        </div>
        
        <p style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/reservations') }}" 
               style="background-color: #FF9800; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block;">
                Ver Reservas
            </a>
        </p>
        
        <p style="margin-top: 30px; font-size: 12px; color: #999;">
            Este es un recordatorio automático. Por favor, acepta o rechaza las reservas lo antes posible.
        </p>
    </div>
</body>
</html>
