<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "unsl";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");
// Verificar la conexión
if ($conn->connect_error) {
    // Muerte
    die("Conexión fallida: " . $conn->connect_error);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carreras <?php echo date("Y"); ?></title>
    <!-- Halfmoon CSS -->
    <link href="https://cdn.jsdelivr.net/npm/halfmoon@2.0.1/css/halfmoon.min.css" rel="stylesheet" integrity="sha256-SsJizWSIG9JT9Qxbiy8xnYJfjCAkhEQ0hihxRn7jt2M=" crossorigin="anonymous">
</head>

<body>
    <?php

    //Obviar conexión segura
    stream_context_set_default(
        array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
            ),
        )
    );
    $url = isset($_POST['url']) ? $_POST['url'] : "https://carreras.unsl.edu.ar/facultades/fcfmyn/1";
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
        
        $container_2 = $xpath->query('//h1[@class="text-white titulo-responsivo mb-2"]');

        $anios = $xpath->query('//div[@class="carrera-anos"]');

        if ($container_2->length > 0) {
            // Obtener el texto del título
            $facultad = $container_2->item(0)->textContent;
 /*no funca*/
            $anios = $anios->item(0)->textContent;
        } 

       /*no funca*/
    ?>
        <form method="post" action="" class="p-2">
            <label for="url">Selecciona una URL:</label>
            <select id="url" name="url" class="w-100" style="max-width: 150px;">
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
            <button type="submit">Obtener Contenido</button>
        </form>
        <div class="d-flex gap-2 flex-wrap justify-content-center cob">
            <?php/*no funca*/
            foreach ($containers as $container) {
                $containerContent = $dom->saveHTML($container);
                $doc = new DOMDocument();
                $doc->loadHTML(mb_convert_encoding($containerContent, 'HTML-ENTITIES', 'UTF-8'));
                $titleElement = $doc->getElementsByTagName('div')->item(1);
                $title = $titleElement->nodeValue;
                $textElement = $doc->getElementsByTagName('div')->item(2);
                $text = $textElement->nodeValue;

                $imgElement = $doc->getElementsByTagName('img')->item(0);
                $imgSrc = $imgElement->getAttribute('src');
                $nivel = "-";
                $sede = "-";
                $tipo = "-";
             

                // Consulta SQL de inserción
 




// Cerrar conexión a la base de datos




            ?>


                <div class="card">
                    <img src="<?php echo $imgSrc; ?>" class="card-img-top w-100 object-fit-cover specific-h-150" alt="...">
                    <div class="card-body p-2">
                        <!--h5 class="card-title fs-6"><?php echo $title; ?></h5-->
                        <p class="card-text"><?php echo $text; ?></p>
                        <!--a href="#" class="btn btn-primary">IR</a-->
                    </div>
                </div>
            <?php

$sql = "INSERT INTO carreras (carrera, facultad, anios, nivel, sede, tipo) 
VALUES ('$text', '$facultad', '$anios', '$nivel', '$sede', '$tipo')";
// Ejecutar consulta SQL
$conn->query($sql);
            }
          
            ?>


        </div>
    <?php
    }

    ?>

    <style>
        /*
        PRUEBAS
        */
        .card {
            width: 160px;
        }

        .cob {
            padding: 15px;
        }

        @media screen and (max-width:766px) {
            .cob {
                padding: 5px;
            }

            .card {
                width: 100%;
            }
        }

        body {

            margin: 0;
        }
    </style>
    <hr>
    <p>Pruebas de base de datos</p>


    <?php

    // Consulta SQL para obtener los datos de la tabla "carreras"
    $sql = "SELECT * FROM carreras";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table border='1' style='width:100%;'>";
        echo "<tr><th>ID</th><th>Carrera</th><th>Facultad</th><th>Años</th><th>Nivel</th><th>Sede</th><th>Tipo</th></tr>";
        // Imprimir los datos de cada fila
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["id"] . "</td><td>" . $row["carrera"] . "</td><td>" . $row["facultad"] . "</td><td>" . $row["anios"] . "</td><td>" . $row["nivel"] . "</td><td>" . $row["sede"] . "</td><td>" . $row["tipo"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "No se encontraron resultados.";
    }

    // Cerrar conexión
    $conn->close();
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</body>

</html>