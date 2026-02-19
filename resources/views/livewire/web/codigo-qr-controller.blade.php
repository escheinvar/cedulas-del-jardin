<div>
    <div class="container">
        <h1>Página desde QR</h1>
        <h2> {{ $titulo }}</h2>

        <p> !Hola!, escaneaste el código QR "{{ $qr }}", que te envió a esta página web que se encuentra
            bajo la URL: 'http://45.90.223.160:8000/qr/{{ $qr }}'
            ojo: la url 45.90.223.160 es donde está el servidor de pruebas del jardín.
            El servidor productivo (al público) va a estar en https://www.jardinoaxaca/qr/</p>
        <br>
        <p>Como podrás ver, el contenido de esta página aún no existe,
            lo único que existe es un código QR en una placa en un jardín y la liga URL
            para llegar a esta página.</p>
        <p>El texto y el título (y en un futuro, las imágenes y demás) se generan de manera
            automática a partir del título de la URL, pues están resguardados
            dentro de una base de datos, lo cual nos da mucha versatilidad en el manejo de la
            información</p>
        <br>
    </div>

</div>
