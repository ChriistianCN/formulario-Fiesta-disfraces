<?php

// Recibir datos del formulario
$data = json_decode(file_get_contents('php://input'), true);

$nombre = $data['nombre'];
$correo = $data['correo'];
$personaje = $data['personaje'];

// Actualizar base de datos (JSON)
$personajes = json_decode(file_get_contents('personajes.json'), true);
foreach ($personajes as &$p) {
    if ($p['personaje'] === $personaje) {
        $p['disponible'] = false;
        break;
    }
}
file_put_contents('personajes.json', json_encode($personajes));

// Configurar datos de la cuenta de Gmail
$smtp_username = 'proyectospruebadev@gmail.com';
$smtp_password = '0djf*g&053891f*#';

// Configurar datos del destinatario y del mensaje
$para = $correo;
$asunto = 'Confirmación de participación en la Fiesta de Disfraces';
$mensaje = 'Hola ' . $nombre . ',<br><br>';
$mensaje .= 'Gracias por participar en nuestra Fiesta de Disfraces inspirada en Shrek. Tu personaje elegido es: ' . $personaje . '.<br><br>';
$mensaje .= '¡Esperamos verte en la fiesta y que te diviertas muchísimo!<br><br>';

// Configurar servidor SMTP de Gmail
$smtp_host = 'smtp.gmail.com';
$smtp_port = 587; // Puerto SSL

// Configurar el mensaje del correo
$headers = "From: $smtp_username\r\n";
$headers .= "Reply-To: $smtp_username\r\n";
$headers .= "Content-type: text/html\r\n";

// Configurar autenticación SMTP
$smtp = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);

// Enviar el correo utilizando la función mail de PHP
$mail = mail($para, $asunto, $mensaje, $headers);

// Verificar si el correo se envió correctamente y mostrar mensaje
if ($mail) {
    echo '¡Formulario enviado con éxito!';
} else {
    echo 'Error al enviar el formulario. Por favor, inténtalo de nuevo más tarde.';
}

?>

