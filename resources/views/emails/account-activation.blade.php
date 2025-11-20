<!DOCTYPE html>
<html>
<head>
    <title>Activación de Cuenta - Aventones</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
        <h2 style="color: #4CAF50;">¡Bienvenido a Aventones!</h2>
        
        <p>Hola {{ $user->name }} {{ $user->surname }},</p>
        
        <p>Gracias por registrarte en Aventones. Para activar tu cuenta, por favor haz clic en el siguiente enlace:</p>
        
        <p style="text-align: center; margin: 30px 0;">
            <a href="{{ url('/activate/' . $activationToken) }}" 
               style="background-color: #4CAF50; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block;">
                Activar Cuenta
            </a>
        </p>
        
        <p>O copia y pega el siguiente enlace en tu navegador:</p>
        <p style="word-break: break-all; color: #666;">{{ url('/activate/' . $activationToken) }}</p>
        
        <p style="margin-top: 30px; font-size: 12px; color: #999;">
            Este enlace expirará en 24 horas. Si no solicitaste esta cuenta, puedes ignorar este correo.
        </p>
    </div>
</body>
</html>
