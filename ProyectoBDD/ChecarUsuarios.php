<?php
include ("Crimenes.lib.php");
conectar();
$name = getvar("username");
$pass = getvar("password");

$sql="select IdUsuario
from Usuarios
	where Usuario='$name'
	and Contrasenia like binary '$pass'";
$res=query($sql);
if ($linea=mysqli_fetch_array($res)) {
    $IdUsuario= $linea["IdUsuario"];
//Creacion de la sesion.
    srand((double)microtime()*1000000);
    $sesion_cookie=md5(uniqid(rand()));
//borra alguna session en el momento del usuario (usuario unico)
    query("delete from Sesion where IdUsuario=$IdUsuario");
//inserta el numero de la sesion en la tabla
    query("insert into Sesion (IdUsuario, Llave)
    values($IdUsuario,'$sesion_cookie')");
    setcookie("id_cookie",$sesion_cookie,time()+(24*60*60),"/"); 
    desconectar();
	header("location:OpcionSQL.php");
}
else {
desconectar();
header("location:./?error=1"); //  Error en el usuario.
}

?>
