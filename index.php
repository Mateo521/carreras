<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carreras <?php echo date("Y"); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/halfmoon@2.0.2/css/halfmoon.min.css" rel="stylesheet" integrity="sha256-RjeFzczeuZHCyS+Gvz+kleETzBF/o84ZRHukze/yv6o=" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');

        .montserrat-p {
            font-family: "Montserrat", sans-serif;
            font-optical-sizing: auto;
            font-weight: bold;
            font-style: normal;
        }
    </style>
</head>

<body style="background-image: url('franja-01.png'); background-size:contain;">
    <div class="container montserrat-p">
        <?php
        stream_context_set_default(
            array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ),
            )
        );

        $url = isset($_GET['url']) ? $_GET['url'] : "https://carreras.unsl.edu.ar/facultades/fcfmyn/1";
        $tipoCarrera = isset($_GET['tipoCarrera']) ? $_GET['tipoCarrera'] : '';
        $content = file_get_contents($url);
        if ($content === false) {
            echo "Error al obtener el contenido de la URL";
        } else {
            $dom = new DOMDocument;
            libxml_use_internal_errors(true);
            $dom->loadHTML($content);
            libxml_clear_errors();
            $xpath = new DOMXPath($dom);
            $containers = $xpath->query('//div[@class="col-md-6 col-sm-6 col-lg-6 col-12"]');
        ?>
            <form method="get" action="" class="p-2" id="carreraForm">
                <label for="url">Facultad:</label>
                <div class="d-flex">
                    <select id="url" name="url" class="w-100" style="max-width: max-content;" onchange="saveSelectionAndSubmit()">
                        <option value="https://carreras.unsl.edu.ar/carreras/?limit=100" <?php if ($url === "https://carreras.unsl.edu.ar/carreras/?limit=100") echo "selected"; ?>>Todas</option>
                        <option value="https://carreras.unsl.edu.ar/facultades/fcfmyn/1" <?php if ($url === "https://carreras.unsl.edu.ar/facultades/fcfmyn/1") echo "selected"; ?>>Facultad de Ciencias Físicas, Matemáticas y Naturales</option>
                        <option value="https://carreras.unsl.edu.ar/facultades/fqbyf/1" <?php if ($url === "https://carreras.unsl.edu.ar/facultades/fqbyf/1") echo "selected"; ?>>Facultad de Química, Bioquímica y Farmacia</option>
                        <option value="https://carreras.unsl.edu.ar/facultades/fica/1" <?php if ($url === "https://carreras.unsl.edu.ar/facultades/fica/1") echo "selected"; ?>>Facultad de Ingeniería y Ciencias Agropecuarias</option>
                        <option value="https://carreras.unsl.edu.ar/facultades/fcejs/1" <?php if ($url === "https://carreras.unsl.edu.ar/facultades/fcejs/1") echo "selected"; ?>>Facultad de Ciencias Económicas, Jurídicas y Sociales</option>
                        <option value="https://carreras.unsl.edu.ar/facultades/fch/1" <?php if ($url === "https://carreras.unsl.edu.ar/facultades/fch/1") echo "selected"; ?>>Facultad de Ciencias Humanas</option>
                        <option value="https://carreras.unsl.edu.ar/facultades/fapsi/1" <?php if ($url === "https://carreras.unsl.edu.ar/facultades/fapsi/1") echo "selected"; ?>>Facultad de Psicología</option>
                        <option value="https://carreras.unsl.edu.ar/facultades/fcs/1" <?php if ($url === "https://carreras.unsl.edu.ar/facultades/fcs/1") echo "selected"; ?>>Facultad de Ciencias de la Salud</option>
                        <option value="https://carreras.unsl.edu.ar/facultades/ftu/1" <?php if ($url === "https://carreras.unsl.edu.ar/facultades/ftu/1") echo "selected"; ?>>Facultad de Turismo y Urbanismo</option>
                        <option value="https://carreras.unsl.edu.ar/facultades/ipau/1" <?php if ($url === "https://carreras.unsl.edu.ar/facultades/ipau/1") echo "selected"; ?>>Instituto Politécnico y Artístico Universitario</option>
                    </select>

                    <!--label for="tipoCarrera">Tipo de Carrera:</label-->
                    <select id="tipoCarrera" name="tipoCarrera" class="w-100" style="max-width: max-content;" onchange="saveSelectionAndSubmit()">

                        <option value="">-- Todas --</option>
                        <option value="pregrado" <?php if ($tipoCarrera === "pregrado") echo "selected"; ?>>Pregrado</option>
                        <option value="grado" <?php if ($tipoCarrera === "grado") echo "selected"; ?>>Grado</option>

                    </select>

                </div>

                <button type="submit" style="display:none;">Obtener Contenido</button>
            </form>







            <div class="d-flex gap-2 flex-wrap justify-content-center cob">


                <?php

                ?>

            <?php
        }
            ?>

            </div>
            <?php
            /*
        }
        */
            ?>
            <div class="container">
                <div class="position-relative w-100" style="height:45px;">
                    <div class="position-absolute w-100 h-100" style="background-image: url('folleto3.jpg'); background-size:cover; background-repeat:no-repeat;  z-index:-1;"></div>
                    <a href="#" class=" w-100 h-100 px-3 py-2 text-decoration-none focus-ring focus-ring-warning  border-0 d-flex justify-content-center align-items-center">
                    </a>
                </div>
                <div class="masonry-grid py-4 px-2">
                    <?php
                    $url = isset($_GET['url']) ? $_GET['url'] : '';
                    foreach ($containers as $container) {
                        $containerContent = $dom->saveHTML($container);
                        $doc = new DOMDocument();
                        $doc->loadHTML(mb_convert_encoding($containerContent, 'HTML-ENTITIES', 'UTF-8'));
                        $titleElement = $doc->getElementsByTagName('div')->item(1);
                        $title = $titleElement ? $titleElement->nodeValue : '';
                        $textElement = $doc->getElementsByTagName('div')->item(2);
                        $text = $textElement ? $textElement->nodeValue : '';
                        $imgElement = $doc->getElementsByTagName('img')->item(0);
                        $imgSrc = $imgElement ? $imgElement->getAttribute('src') : '';
                        $linkElement = $doc->getElementsByTagName('a')->item(0);
                        $linkHref = $linkElement ? $linkElement->getAttribute('href') : '';

                        $anosElement = $doc->getElementsByTagName('div')->item(3); // Ajusta el índice según la estructura HTML
                        $anosText = $anosElement ? $anosElement->nodeValue : '';
                        /*
                        $facuElement = $doc->getElementsByTagName('div')->item(4); 
                        $facuText = $facuElement ? $facuElement->nodeValue : '';


                        */
                        preg_match('/\s*(\d+)\s*años/i', $anosText, $matches);

                        $anos = isset($matches[1]) ? (int)$matches[1] : 5;

                        // Aplicar filtro basado en el tipo de carrera seleccionado

                        if ($tipoCarrera === 'pregrado' && $anos > 3) {
                            continue; // Saltar si es "Pregrado" y la carrera dura más de 2 años
                        } elseif ($tipoCarrera === 'grado' && $anos <= 3) {
                            continue; // Saltar si es "Grado" y la carrera dura 2 años o menos
                        }

                    ?>
                        <div class="masonry-item">
                            <div class="card">
                                <a target="_blank" href="https:carreras.unsl.edu.ar<?php echo $linkHref; ?>">
                                    <img src="https://carreras.unsl.edu.ar<?php echo $imgSrc; ?>" class="w-100 tarjeta-img object-fit-cover specific-h-150" alt="<?php echo trim($text); ?>">
                                    <div class="card-body p-2 position-relative w-100">
                                        <div class="position-absolute w-100 h-100" style="background-image: url('folleto3.jpg'); background-size:cover; background-position:<?php echo rand(-100, 0) ?>px 0px; background-repeat:no-repeat; opacity:0.25;left:0; top:0; z-index:-1;"></div>
                                        <div class="d-flex gap-1 align-items-center justify-content-center">
                                            <!--img width="30" height="30" src="https://carreras.unsl.edu.ar/static/facultades/fqbyf.png" alt=""  style="border-radius: 50%;" -->

                                            <p class="card-text text-center"><?php echo trim($text); ?></p>

                                        </div>
                                        <!--p>años: <?php echo $anos ?></p-->
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="position-relative w-100" style="height:45px;">
                    <div class="position-absolute w-100 h-100" style="  -moz-transform: scaleX(-1);
    -o-transform: scaleX(-1);
    -webkit-transform: scaleX(-1);
    transform: scaleX(-1);background-image: url('folleto3.jpg'); background-size:cover; background-repeat:no-repeat;  z-index:-1;"></div>
                    <a href="#" class=" w-100 h-100 px-3 py-2 text-decoration-none focus-ring focus-ring-warning  border-0 d-flex justify-content-center align-items-center">
                    </a>
                </div>
            </div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.2/masonry.pkgd.min.js"></script>
            <script src="https://unpkg.com/imagesloaded@4/imagesloaded.pkgd.min.js"></script>
            <script>
                var msnry;
                var grid = document.querySelector('.masonry-grid');
                imagesLoaded(grid, function() {
                    msnry = new Masonry(grid, {
                        itemSelector: '.masonry-item',
                        columnWidth: '.masonry-item',
                        gutter: 16,
                        fitWidth: true
                    });
                });
            </script>

            <style>
                body {
                    height: 100vh;
                }

                .masonry-grid {
                    margin: 0 auto;
                }

                .masonry-item {
                    max-width: 300px;
                    width: 100%;
                    margin-bottom: 16px;
                }

                .tarjeta-img {
                    display: block;
                    width: 100%;
                    height: auto;
                    object-fit: cover;
                    border-radius: 0;
                }

                .card {
                    transition: box-shadow 0.3s ease, transform 0.3s ease;
                    /* Agrega la transición */
                    background-color: #ffffff00;
                    border-radius: 0;
                    overflow: hidden;
                    width: 100%;

                }

                .card a {
                    color: inherit;
                    text-decoration: none;
                }

                .card:hover {
                    cursor: pointer;
                    transform: scale(1.1);
                    z-index: 99;
                    animation: box-move-anim 1s infinite alternate-reverse;
                }

                form {
                    position: relative;
                    z-index: 100;
                }
            </style>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
            <script>
                // Función para guardar la selección y enviar el formulario
                function saveSelectionAndSubmit() {
                    var selectUrl = document.getElementById('url').value;
                    var selectTipoCarrera = document.getElementById('tipoCarrera').value;

                    localStorage.setItem('selectedUrl', selectUrl);
                    localStorage.setItem('selectedTipoCarrera', selectTipoCarrera);

                    document.getElementById('carreraForm').submit();
                }

                document.addEventListener('DOMContentLoaded', function() {
                    // Restaurar valores al cargar la página
                    var savedUrl = localStorage.getItem('selectedUrl');
                    var savedTipoCarrera = localStorage.getItem('selectedTipoCarrera');

                    if (savedUrl) {
                        document.getElementById('url').value = savedUrl;
                        $(".selectLabel").text($("#url option[value='" + savedUrl + "']").text()); // Actualiza el label
                    }

                    if (savedTipoCarrera) {
                        document.getElementById('tipoCarrera').value = savedTipoCarrera;
                        $(".selectLabelTipoCarrera").text($("#tipoCarrera option[value='" + savedTipoCarrera + "']").text()); // Actualiza el label
                    }

                    // Código jQuery para personalizar el select y manejar clics en opciones
                    $(function() {
                        var defaultselectbox = $("#url");
                        var numOfOptions = $("#url").children("option").length;

                        // Ocultar el select original
                        defaultselectbox.addClass("s-hidden");

                        // Envolver el select dentro de un contenedor personalizado
                        defaultselectbox.wrap('<div class="cusSelBlock"></div>');

                        // Crear el div que actuará como el label del select
                        defaultselectbox.after('<div class="selectLabel"></div>');

                        // Asignar el valor inicial del label
                        $(".selectLabel").text(defaultselectbox.children("option:selected").text());

                        // Crear el menú de opciones personalizado
                        var cusList = $("<ul/>", {
                            class: "options"
                        }).insertAfter($(".selectLabel"));

                        // Generar las opciones del menú personalizado
                        for (var i = 0; i < numOfOptions; i++) {
                            $("<li/>", {
                                text: defaultselectbox.children("option").eq(i).text(),
                                rel: defaultselectbox.children("option").eq(i).val()
                            }).appendTo(cusList);
                        }

                        // Funciones para abrir y cerrar el menú
                        function openList() {
                            for (var i = 0; i < numOfOptions; i++) {
                                $(".options")
                                    .children("li")
                                    .eq(i)
                                    .attr("tabindex", i)
                                    .css("transform", "translateY(" + (i * 100 + 100) + "%)")
                                    .css("transition-delay", i * 30 + "ms");
                            }
                        }

                        function closeList() {
                            for (var i = 0; i < numOfOptions; i++) {
                                $(".options")
                                    .children("li")
                                    .eq(i)
                                    .css("transform", "translateY(" + i * 0 + "px)")
                                    .css("transition-delay", i * 0 + "ms");
                            }
                            $(".options")
                                .children("li")
                                .eq(1)
                                .css("transform", "translateY(" + 2 + "px)");
                            $(".options")
                                .children("li")
                                .eq(2)
                                .css("transform", "translateY(" + 4 + "px)");
                        }

                        // Evento para abrir y cerrar el menú al hacer clic en el label
                        $(".selectLabel").click(function() {
                            $(this).toggleClass("active");
                            if ($(this).hasClass("active")) {
                                openList();
                                focusItems();
                            } else {
                                closeList();
                            }
                        });

                        // Evento para seleccionar una opción del menú personalizado
                        $(".options li").on("keypress click", function(e) {
                            e.preventDefault();
                            $(".options li").siblings().removeClass();
                            closeList();
                            $(".selectLabel").removeClass("active");

                            // Actualizar el texto del label con el texto de la opción seleccionada
                            $(".selectLabel").text($(this).text()); // Cambia aquí

                            // Actualizar el valor del select original
                            defaultselectbox.val($(this).attr("rel"));

                            // Enviar el formulario
                            saveSelectionAndSubmit();
                        });

                    });
                });

                // Función para manejar el enfoque de las opciones
                function focusItems() {
                    $(".options")
                        .on("focus", "li", function() {
                            $(this).addClass("active").siblings().removeClass();
                        })
                        .on("keydown", "li", function(e) {
                            if (e.keyCode == 40) { // Flecha hacia abajo
                                $(this).next().focus();
                                return false;
                            } else if (e.keyCode == 38) { // Flecha hacia arriba
                                $(this).prev().focus();
                                return false;
                            }
                        })
                        .find("li")
                        .first()
                        .focus();
                }


                const colors = [
                    'rgba(67,155,214,255)',
                    'rgba(226,41,124,255)',
                    'rgba(234,96,31,255)',
                    'rgba(46,44,130,255)',
                    'rgba(234,96,31,255)',
                    'rgba(253,214,6,255)',
                    'rgba(46,44,130,255)'
                ];

                function getRandomColor() {
                    return colors[Math.floor(Math.random() * colors.length)];
                }
                const cards = document.querySelectorAll('.card');

                cards.forEach(card => {
                    card.addEventListener('mouseenter', () => {
                        const randomColor = getRandomColor();
                        card.style.boxShadow = `1px 0px 44px 15px ${randomColor}`;
                    });
                    card.addEventListener('mouseleave', () => {
                        card.style.boxShadow = '';
                    });
                });
            </script>


            <style>
                /* custom select style */
                .cusSelBlock {
                    height: 50px;
                    min-width: 250px;
                    width: 100%;

                }

                #cusSelectbox {
                    height: 100%;
                    width: 100%;
                }

                .s-hidden {
                    visibility: hidden;
                }

                .cusSelBlock {
                    display: inline-block;
                    position: relative;
                    perspective: 800px;
                }

                .selectLabel {
                    position: absolute;
                    left: 0;
                    top: 0;
                    z-index: 9999;
                    background-color: #fff;
                    border: 1px solid #333;
                    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
                    color: #333;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    height: auto;
                    width: 100%;
                    min-height: 50px;
                    letter-spacing: 2px;
                    /*
                    line-height: 50px;
                    */
                    padding: 0 50px 0 20px;
                    text-align: left;
                    transform-style: preserve-3d;
                    transform-origin: 50% 0%;
                    transition: transform 300ms;
                    -webkit-backface-visibility: hidden;
                    -webkit-touch-callout: none;
                    -webkit-user-select: none;
                    -moz-user-select: none;
                    -ms-user-select: none;
                    user-select: none;
                }

                .selectLabel:after {
                    content: '\25BC';
                    border-left: 1px solid #333;
                    color: #333;
                    font-size: 12px;
                    line-height: 17px;
                    padding: 10px;
                    text-align: center;
                    position: absolute;
                    right: 0px;
                    top: 15%;
                    height: 70%;
                    width: 50px;
                }

                .selectLabel:active {
                    transform: rotateX(30deg);
                }

                .selectLabel:active:after {
                    content: '\25B2';
                }

                .selectLabel.active:after {
                    content: '\25B2';
                }

                /*
                ::-webkit-scrollbar {
                    display: none;
                }*/

                .options {
                    position: absolute;
                    top: 50px;
                    height: 1px;
                    width: 100%;
                }

                .options li {
                    height: 100%;
                    background-color: #ffffff;
                    border-left: 1px solid 33;
                    border-right: 1px solid #333;
                    border-bottom: 1px solid #333;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    /*
                     line-height: 50px;
                  */
                    list-style: none;
                    opacity: 1;
                    padding: 0 50px 0 20px;
                    text-align: left;
                    transition: transform 300ms ease;
                    position: absolute;
                    color: black;
                    top: -50px;
                    left: 0;
                    z-index: 0;
                    height: -webkit-fill-available;
                    width: 100%;
                }

                .options li:hover {
                    /*
                    background-color: #e61c69;
*/
                    color: #fff;
                }

                .options li:nth-child(1) {
                    transform: translateY(2px);
                    z-index: 6;
                }

                .options li:nth-child(2) {
                    transform: translateY(4px);
                    z-index: 5;
                }

                .options li:nth-child(3) {
                    z-index: 4;
                }

                .options li:nth-child(4) {
                    z-index: 3;
                }

                .options li:nth-child(5) {
                    z-index: 2;
                }

                .options li:nth-child(6) {
                    z-index: 1;
                }

                /**/
                .feaBlock {
                    margin: 20px 0;
                    text-align: left;
                }
            </style>
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const options = document.querySelectorAll('.options li');

                    options.forEach(option => {
                        option.addEventListener('mouseover', () => {
                            const randomColor = colors[Math.floor(Math.random() * colors.length)];
                            option.style.backgroundColor = randomColor;
                        });

                        option.addEventListener('mouseout', () => {

                            option.style.backgroundColor = '';
                        });

                        option.addEventListener('click', () => {
                            const randomColor = colors[Math.floor(Math.random() * colors.length)];
                            option.style.backgroundColor = randomColor;
                        });
                    });
                });
            </script>
</body>

</html>