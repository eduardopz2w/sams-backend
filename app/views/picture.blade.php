<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <style>
    .contenedor{ width: 350px; float: left;}
    .titulo{ font-size: 12pt; font-weight: bold;}
    #camara, #foto{
      width: 320px;
      min-height: 240px;
      border: 1px solid #008000;
    }
  </style>
</head>
<body>

<div id='botonera'>
    <input id='botonIniciar' type='button' value = 'Iniciar'></input>
    <input id='botonDetener' type='button' value = 'Detener'></input>
    <input id='botonFoto' type='button' value = 'Foto'></input>
</div>
<div class="contenedor">
    <div class="titulo">Cámara</div>
    <video id="camara" autoplay controls></video>
</div>
<div class="contenedor">
    <div class="titulo">Foto</div>
    <canvas id="foto" ></canvas>
</div> 

{{HTML::script('js/jquery-1.11.3.min.js')}}
<script>
                      //Nos aseguramos que estén definidas
//algunas funciones básicas
console.log(window.URL);

window.URL = window.URL || window.webkitURL;



navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia ||
function() {
    alert('Su navegador no soporta navigator.getUserMedia().');
};


console.log(navigator.getUserMedia);
//Este objeto guardará algunos datos sobre la cámara
window.datosVideo = {
    'StreamVideo': null,
    'url': null
}

jQuery('#botonIniciar').on('click', function(e) {

    //Pedimos al navegador que nos da acceso a 
    //algún dispositivo de video (la webcam)
    navigator.getUserMedia({
        'audio': false,
        'video': true
    }, function(streamVideo) {
        console.log(streamVideo);
        
        datosVideo.StreamVideo = streamVideo;
        datosVideo.url = window.URL.createObjectURL(streamVideo);
        jQuery('#camara').attr('src', datosVideo.url);

    }, function() {
        alert('No fue posible obtener acceso a la cámara.');
    });



});

jQuery('#botonDetener').on('click', function(e) {

    if (datosVideo.StreamVideo) {
        datosVideo.StreamVideo.stop();
        window.URL.revokeObjectURL(datosVideo.url);
    }

});

jQuery('#botonFoto').on('click', function(e) {
    var oCamara, oFoto, oContexto, w, h;

    oCamara = jQuery('#camara');
    oFoto = jQuery('#foto');
    w = oCamara.width();
    h = oCamara.height();
    oFoto.attr({
        'width': w,
        'height': h
    });
    oContexto = oFoto[0].getContext('2d');
    oContexto.drawImage(oCamara[0], 0, 0, w, h);

});
</script>
</body>
</html>


