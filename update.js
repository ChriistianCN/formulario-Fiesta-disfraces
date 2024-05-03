document.addEventListener('DOMContentLoaded', function() {
    const formulario = document.getElementById('formulario');
    const selectPersonaje = document.getElementById('personaje');

    // Cargar lista de personajes disponibles desde JSON
    fetch('personajes.json')
        .then(response => response.json())
        .then(data => {
            data.forEach(personaje => {
                if (personaje.disponible) {
                    const option = document.createElement('option');
                    option.value = personaje.personaje;
                    option.textContent = personaje.personaje;
                    selectPersonaje.appendChild(option);
                }
            });
        });

    // Manejar envío del formulario
    formulario.addEventListener('submit', function(event) {
        event.preventDefault();

        const nombre = document.getElementById('nombre').value;
        const correo = document.getElementById('correo').value;
        const personaje = selectPersonaje.value;

        // Enviar datos al servidor para procesar
        fetch('procesar_formulario.php', {  
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                nombre: nombre,
                correo: correo,
                personaje: personaje
            })
        })
        .then(response => response.text())
        .then(data => {
            // Manejar respuesta del servidor si es necesario
            console.log(data);
            // Redirigir o mostrar mensaje de éxito
        })
        .catch(error => {
            console.error('Error:', error);
            // Mostrar mensaje de error al usuario si es necesario
        });
    });
});
