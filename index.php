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

<body style="width: 1187px;">
    
    <nav class="navbar navbar-light navbar-expand-md navigation-clean" style="background-color: #0066FF;height: 78px;width: 1200px;">
        <div class="container"><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button><a class="navbar-brand" href="#" style="font-size: 34px;color: #ffffff;padding: -8px;margin: -8px;height: 47px;opacity: 1;width: 330.547px;margin-top: -8px;margin-right: -8px;margin-bottom: -8px;margin-left: -8px;font-weight: 700;font-style: normal;">Evaluacion Docente</a>
            <div
                class="collapse navbar-collapse" id="navcol-1"></div><img src="assets/img/SEP_TI.png" style="width: 169px;height: 78px;margin: -6px;"><img src="assets/img/SEP.png" style="width: 200px;height: 63px;margin: -19px;padding: -18px;"></div>
    </nav>
    <div class="text-center text-sm-center text-md-center text-lg-center text-xl-center login-clean" style="background-color: rgb(255,255,255);">
        <form class="border rounded shadow" method="post" style="width: 374px;" action="" method="post">
            <h2 class="sr-only">Login Form</h2>
            <div class="illustration">
                <div class="card">
                    <div class="card-header border rounded shadow-sm" style="width: 319px;height: 55px;margin: -41px;padding: 12px;color: rgb(71,130,244);background-color: #0066FF;">
                        <h5 class="mb-0" style="color: rgb(255,255,255);">Ingresar</h5>
                    </div>
                </div>
            </div>
            <div class="form-group"><textarea class="form-control" style="margin: 16px;margin-right: 0;margin-bottom: 0;margin-left: 0;padding: 0;padding-top: 6px;padding-right: 12px;" placeholder="Usuario" name="usuario"></textarea></div>
            <div class="form-group"><input class="border rounded shadow-sm form-control" type="password" name="password" placeholder="Password" style="margin-top: 16px;"></div>
            <div class="form-group"><button class="btn btn-primary btn-block border rounded shadow" type="submit" style="margin-top: 38px;width: 237px;height: 55px;background-color: #0066FF;">Ingresar</button></div>
        </form>
        <?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "evaluaciondocente";
    
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    
if (!$conn)
{
    die("SERVIDOR NO CONECTADO: ".mysqli_error());
}
    if(isset($_POST['usuario']) && isset($_POST['password'])){  
        $nombre = $_POST["usuario"];
        $pass = $_POST["password"];
    
 
$query = mysqli_query($conn, "SELECT * FROM carreras WHERE Usuario = '".$nombre."' and Contraseña = '".$pass."'");
$nr = mysqli_num_rows($query);
    

if($nr == 1)
{
    session_start();
    $_SESSION["usuario"] = $nombre;
    $_SESSION["password"] = $pass;
    header('location: http://localhost/Evaluacion/encuesta.php');
    echo "Bienvenido: " .$nombre;
}else if($nr == 0)
{
    echo "No has ingresado";
}
    }
?>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>