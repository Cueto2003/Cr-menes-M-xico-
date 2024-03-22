<?php
define("BDserver","127.0.0.1");
define("DataBase","CrimenesMéxico");
define("BDusr"	 ,"admin");
define("BDpass"	 ,"Adm1n");


//*************
function conectar()
{

$enlace=mysqli_connect(BDserver,BDusr,BDpass,DataBase);
if (!$enlace) {
    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
    die();
}
$GLOBALS['MyBD'] = $enlace;
}

//*************
function desconectar()
{
mysqli_close($GLOBALS['MyBD']);
}

//*************
function query( $sql, $muestra = false )
{
if ( $muestra ) print( "<br><b>$sql</b><br>" );
$res=mysqli_query($GLOBALS['MyBD'],$sql) or die("\n<br><b>$sql</b><br>\n".mysqli_error($GLOBALS['MyBD']));
return ($res);
}

//*************
function getvar($s)
{
if (isset($_POST[$s])) return ($_POST[$s]);
else if (isset($_GET[$s])) return ($_GET[$s]);
return ("");
}
//************* */
function checa_seguridad()
{
$id_cookie = $_COOKIE["id_cookie"];
$sql="select IdUsuario 
    from sesion  
        where Llave='$id_cookie'";  
$res=query("$sql"); 
if (mysqli_num_rows($res)==0) { 
    header( "location:".$ruta."index.php?error=5" );	// Error 5: Sesión finalizada 
	desconectar();
    die("Error verifica"); 
}  
}

//*************
function encabezado()
{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crimenes de M&eacute;xico</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="lib/materialize/css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="lib/materialize/css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <script src="lib/jquery-3.2.1.js" type="text/javascript"></script>
    <script src="lib/materialize/js/materialize.js"></script>


</head>
<body>
<?php
}
//*************** */
function pie()
{
?>
</body>
</html>
<?php
}
?>