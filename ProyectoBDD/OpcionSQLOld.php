<?php
include_once "Crimenes.lib.php";
conectar();
checa_seguridad();
encabezado();
?>

    <ul class="barra-de-opciones">
        <li><a href="prueba.php" name="MTLT">Mostrar Todas Las Tablas</a></li>
        <li><a href="Analisis.php" name="Analisis">Análisis </a></li>
    </ul>
<?php
pie();
?>
<style>
.barra-de-opciones {
    list-style: none;
    padding: 0;
    margin: 0;
    background-color: #333;
    display: flex;
    justify-content: center;
    align-items: center;
}

.barra-de-opciones li {
    margin: 0;
    padding: 0;
}

.barra-de-opciones a {
    display: block;
    color: #fff;
    text-decoration: none;
    padding: 10px 20px;
    transition: background-color 0.2s;
}

.barra-de-opciones a:hover {
    background-color: #555;
}

/* Estilos adicionales para hacerla visualmente atractiva */
.barra-de-opciones a {
    font-weight: bold;
    text-transform: uppercase;
}

.barra-de-opciones a::before {
    content: "\2022"; /* Círculo como separador */
    margin: 0 10px;
    color: #fff;
}

</style>
<?php
desconectar(); 
?>