<?php
include_once "crimenes.lib.php";
conectar();
checa_seguridad();
encabezado();
$tabla = getvar("tablas");
?>
<div>
    <ul class="barra-de-opciones">
        <li><a href="OpcionSQL.php" name="OpcionSQL">Mostrar Todas Las Tablas</a></li>
        <li><a href="Analisis.php" name="Analisis">Análisis </a></li>
    </ul>
</div>
<form method="GET">
<div class="input-field col s12">
    <select name="tablas" onchange="this.form.submit()">
    <option value="ActividadPolicial" <?php echo ($tabla == "ActividadPolicia"?"selected":"")?>>ActividadPolicia</option>
    <option value="Armas" <?php echo ($tabla == "Armas"?"selected":"")?>>Armas</option> 
    <option value="Casos" <?php echo ($tabla == "Casos"?"selected":"")?>>Casos</option>
    <option value="Criminales" <?php echo ($tabla == "Criminales"?"selected":"")?>>Criminales</option>
    <option value="Delitos" <?php echo ($tabla == "Delitos"?"selected":"")?>>Delitos</option> 
    <option value="Departamentos" <?php echo ($tabla == "Departamentos"?"selected":"")?>>Departamentos</option>
    <option value="DetallesArmas" <?php echo ($tabla == "DetallesArmas"?"selected":"")?>>DetallesArmas</option>
    <option value="DetallesDelito" <?php echo ($tabla == "DetallesDelito"?"selected":"")?>>DetallesDelito</option> 
    <option value="Jueces" <?php echo ($tabla == "Jueces"?"selected":"")?>>Jueces</option>
    <option value="Policías" <?php echo ($tabla == "Policías"?"selected":"")?>>Policías</option> 
    <option value="Sentencia" <?php echo ($tabla == "Sentencia"?"selected":"")?>>Sentencia</option>
    <option value="Victimas" <?php echo ($tabla == "Victimas"?"selected":"")?>>Victimas</option>
    
    </select>
    <label>Tablas</label>
</div>
</form>
<?php
if ($tabla == "") $tabla = "Armas";
echo "<table>
    <theader>";
$sql = "SHOW COLUMNS FROM $tabla";
$result = query($sql);
echo "<tr>";
while ($row = mysqli_fetch_array($result)) {
    $nombre = $row['Field'];
    echo "<th>$nombre</th>";
}
echo "</tr>
    </theader>
    <tbody>";
$sql = "select * from $tabla limit 50";
$result = query($sql);
while ($row = mysqli_fetch_array($result)){
    echo "<tr>";
    $numero = (int)(count($row)/2);
    for ($i=0;$i<$numero;$i++) {
        echo "<td> ".$row[$i]." </td>";
    }
    echo "</tr>";
}
echo "</table>";
desconectar();
pie();
?>
<script>
    $(document).ready(function(){
    $('select').formSelect();
}); 
</script>
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

