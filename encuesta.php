<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>EvaluacionDocente</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/Highlight-Clean.css">
    <link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
    <link rel="stylesheet" href="assets/css/Navigation-Clean.css">
    <link rel="stylesheet" href="assets/css/styles.css">
</head>

<body class="text-center text-sm-center text-md-center text-lg-center text-xl-center" style="margin-top: 0px;">
    <nav class="navbar navbar-light navbar-expand-md navigation-clean" style="background-color: #0066ff;height: 78px;">
        <div class="container"><a class="navbar-brand" href="#" style="color: rgb(255,255,255);width: 330.547px;height: 40px;margin: 1px;margin-top: 4;margin-right: 0;margin-bottom: 0;margin-left: 0;padding: 0;padding-top: 0;padding-right: 0;padding-bottom: 0;padding-left: 0;font-size: 34px;font-weight: normal;"><strong>Evaluacion Docente</strong><br><br></a>
            <button
                data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav ml-auto">
                        <li class="nav-item" role="presentation"></li>
                        <li class="nav-item" role="presentation"></li>
                    </ul>
                </div><img src="assets/img/SEP_TI.png" style="width: 169px;margin: -6px;"><img src="assets/img/SEP.png" style="width: 200px;height: 63px;margin: -19px;padding: -18px;"></div>   
    </nav>
    <?php 

        session_start();

        $num_pregunta = 0;
        $num_maestro = 0;
        $maestro = array();
        $pregunta = array("¿Consideras que la clase impartida por el profesor era interesante?", "Pregunta 2", "Pregunta 3", "Pregunta 4", "Pregunta 5", "Pregunta 6","Pregunta 7","Pregunta 8", "Pregunta 9","Pregunta 10");
        $respuesta = array();
        $grupo = array();
        $respuestaCadena = "";
        $materias = array();
        $n_ctrl = $_SESSION['usuario'];
        $nombre_completo = "";
        $row;
        $respuestaBidi = array_fill(0, count($pregunta), array_fill(0, count($materias), 0));

        if($num_pregunta>=count($pregunta)){
            $num_pregunta = 0;
            $_SESSION = array();
        }

        if(isset($_SESSION['num_pregunta']) && $num_pregunta<=count($pregunta)){
            $num_pregunta = $_SESSION['num_pregunta'];
        }

        $pregunta = array_values($pregunta);
        
        $mysqli = mysqli_connect('localhost', 'root', '', 'evaluaciondocente');
        if (!$mysqli) {
            die("Conexion fallida: " . mysqli_connect_error());
        }

        $preguntaCont = 0;

    $countMaestro = count($maestro);
    
        
        //$maestro = consultar_unir($mysqli, $n_ctrl, 'apellidos_empleado', 'nombre_empleado', $maestro);

        $qry = "SELECT
            seleccion_materias.materia,
            seleccion_materias.no_de_control,
            grupos_personal.grupo,
            nombre_empleado,
            apellidos_empleado,
            nombre_abreviado_materia,
            nombre_alumno,
            apellido_paterno,
            apellido_materno
        FROM
            seleccion_materias
        JOIN grupos_personal ON seleccion_materias.materia = grupos_personal.materia
        JOIN alumnos ON seleccion_materias.no_de_control = alumnos.no_de_control
        WHERE
            seleccion_materias.no_de_control = ".$n_ctrl;
        $res = mysqli_query($mysqli, $qry);

        if (mysqli_num_rows($res) > 0) {
            
            while($row = mysqli_fetch_assoc($res)) {
                array_push($maestro, $row['nombre_empleado'] . " " . $row['apellidos_empleado']);
                array_push($materias, $row['nombre_abreviado_materia']);
                $nombre_completo = $row['nombre_alumno'] . " " . $row['apellido_paterno'] . " " . $row['apellido_materno'];
                array_push($grupo, $row['grupo']);
            }  
        } 
        else {
                echo "Sin resultados";
        }
        

        

        if(isset($_POST['submit'])){

            
            
            $_SESSION['datosRespuesta'] = isset($_SESSION['datosRespuesta']) ? ($respuestaBidi = $_SESSION['datosRespuesta']) : $_SESSION['datosRespuesta'] = $respuestaBidi;
            $_SESSION['i'] = isset($_SESSION['i']) ? ++$_SESSION['i'] : 0;
            echo $_SESSION['i'];
            $preguntaCont = $_SESSION['i'];
            if($preguntaCont>count($pregunta))$_SESSION['i']=0;
    
            //$respuestaBidi = array_values($respuestaBidi);
                for($p = 0; $p<count($materias);$p++){
                        //$respuestaCadena .= ",".$_POST['i'.$p];
                        if(isset($_POST['i'.$p])){
                            $respuestaBidi[$preguntaCont][$p] = $_POST['i'.$p];      
                        }
                }
                $num_pregunta++;
                $_SESSION['datosRespuesta'] = $respuestaBidi;
        }
       
            echo  
    '<h3 class="text-center text-sm-center text-md-center text-lg-center text-xl-center" style="height: 40px;width: 1199px;padding-top: 12px;margin-left: 0px;">'.$nombre_completo.'</h3>
    <h4 class="text-center text-sm-center text-md-center text-lg-center text-xl-center text-white border rounded" style="background-color: #0066ff;width: 212px;margin-top: 15px;height: 34px;margin-left: 494px;">Pregunta No.&nbsp'.(($preguntaCont+1)%10).'</h4>
    <h4 class="text-center text-sm-center text-md-center text-lg-center text-xl-center" style="margin-top: 1px;">'.$pregunta[$preguntaCont%10].'</h4>
    <header class="text-center text-sm-center text-md-center text-lg-center text-xl-center" style="background-color: #9c9c9c;width: 715px;height: 1px;margin-left: 247px;margin-top: -1px;"></header>
    <h6 class="text-center text-sm-center text-md-center text-lg-center text-xl-center" style="width: 1200px;margin-top: -12px;"><br>5)Totalmente de acuerdo &nbsp 4)De acuerdo &nbsp 3)Indiferente &nbsp 2)En desacuerdo &nbsp 1)Altamente en desacuerdo<br><br></h6>
    <div class="table-responsive table-borderless text-left" style="width: 890px;margin: 0px;margin-top: 11px;margin-right: 0px;margin-left: 178px;">
        <table class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th style="width: 239px;">Materia</th>
                    <th style="width: 95px;">Maestro</th>
                    <th class="text-center text-sm-center text-md-center text-lg-center text-xl-center" style="width: 185px;">Calificacion</th>
                </tr>
            </thead>
            <tbody>
                <form method = "POST" action = "encuesta.php">';
                for($i = 0;$i<count($materias);$i++){
                    echo 
                    '<tr>
                        <td style="width: 197px;">'.$materias[$i].'</td>
                        <td style="width: 291px;">'.$maestro[$i].'</td>
                        <td class="text-center text-sm-center text-md-center text-lg-center text-xl-center">
                            <div class="form-check form-check-inline text-center text-sm-center text-md-center text-lg-center text-xl-center"><input class="form-check-input" type="radio" id="i'.$i.'" name="i'.$i.'" value = "1"><label class="form-check-label" for="i'.$i.'">1</label></div>
                            <div class="form-check form-check-inline text-center text-sm-center text-md-center text-lg-center text-xl-center"><input class="form-check-input" type="radio" id="i'.$i.'" name="i'.$i.'" value = "2"><label class="form-check-label" for="i'.$i.'">2</label></div>
                            <div class="form-check form-check-inline text-center"><input class="form-check-input" type="radio" id="i'.$i.'" name="i'.$i.'"checked value = "3"><label class="form-check-label" for="i'.$i.'">3</label></div>
                            <div class="form-check form-check-inline text-center text-sm-center text-md-center text-lg-center text-xl-center"><input class="form-check-input" type="radio" id="i'.$i.'" name="i'.$i.'" value = "4"><label class="form-check-label" for="i'.$i.'">4</label></div>
                            <div class="form-check form-check-inline text-center text-sm-center text-md-center text-lg-center text-xl-center"><input class="form-check-input" type="radio" id="i'.$i.'" name="i'.$i.'" value = "5"><label class="form-check-label" for="i'.$i.'">5</label></div>

                        </td>';
                       
                }
                    echo
                '</tr><button class="btn btn-primary text-right text-sm-right text-md-right text-lg-right text-xl-right border rounded shadow-sm" style="margin: 0px;margin-right: 0px;margin-bottom: 0px;margin-left: 732px;" type ="submit" name = "submit" value = "data">Siguiente<img src="assets/img/icons8-más-de-50.png" style="width: 22px;height: 23px;margin: 0px;margin-right: -9px;margin-top: 0px;margin-left: 6px;"></button>    
                </form>
        </tbody>
        </table>
    </div>';

    

    
    

    function insertar($conn, $pregunta, $materias, $grupo, $respuesta, $respuestaBidi, $respuestaCadena){
        $preguntaQuery = "";
        $preguntaInsert = "";
        $respuestaQuery = "";
        $respuestaCadena = "";
        $resAux = array(count($respuesta));
        $respuestaBidi = array_values($respuestaBidi);
        for($k = 0;$k<count($pregunta);$k++){
            $preguntaQuery .= "p".$k." INT(18),";
            $preguntaInsert .= ",p".$k;
            
        }
        $insertQuery = "INSERT INTO registros(grupos,nombre_empleado".$preguntaInsert.")VALUES";
        for($m = 0; $m<count($materias);$m++){
            for($c = 0;$c<count($pregunta);$c++){
                $respuestaCadena .= ",". $respuestaBidi[$c][$m];  
            }
            
                $insertQuery .= "(000,'".$materias[$m]."'".$respuestaCadena."),";
            
            $respuestaCadena = "";
        }
        $preguntaQuery .= "PRIMARY KEY (id)";
        $qry = "CREATE TABLE IF NOT EXISTS registros(
            id INT(11),
            grupos INT(3),
            nombre_empleado VARCHAR(65),".
            $preguntaQuery
        .");". $insertQuery;
        $qry = rtrim($qry, ",");
        $qry .= ";";
        echo $qry;
        $res = mysqli_multi_query($conn, $qry);
        
    }


    if(isset($_POST['submit'])){
        $_SESSION['num_pregunta'] = $num_pregunta;
        
        if($num_pregunta>count($pregunta)){
            $_SESSION = array();
            insertar($mysqli, $pregunta, $materias, $grupo, $respuesta, $respuestaBidi, $respuestaCadena);
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            unset($_SESSION);
            
        }
    session_destroy();
    echo "<script>location.replace('index.php');</script>";
        }
        
    } 

    mysqli_close($mysqli); 
   
    ?>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>