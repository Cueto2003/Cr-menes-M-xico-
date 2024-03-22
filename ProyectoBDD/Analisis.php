<?php
include_once "crimenes.lib.php";
conectar();
checa_seguridad();
encabezado();
$tabla = getvar("Análisis");
if($tabla == ""){
    $tabla = "1";
}
?>
<div>
    <ul class="barra-de-opciones">
        <li><a href="OpcionSQL.php" name="OpcionSQL">Mostrar Todas Las Tablas</a></li>
        <li><a href="Analisis.php" name="Analisis">Análisis </a></li>
    </ul>
</div>
<form method="GET">
<div class="input-field col s12">
    <select name="Análisis" onchange="this.form.submit()">
    <option value="1" <?php echo ($tabla == "1"?"selected":"")?>>Departamentos Con Más Arrestos</option>
    <option value="2" <?php echo ($tabla == "2"?"selected":"")?>>Criminales Con Más Años De Sentencia</option>
    <option value="3" <?php echo ($tabla == "3"?"selected":"")?>>Mes Con Más Delitos</option>
    <option value="4" <?php echo ($tabla == "4"?"selected":"")?>>Criminal Con Más Víctimas</option>
    <option value="5" <?php echo ($tabla == "5"?"selected":"")?>>Cantidad De Polícias Que Comparten Armas</option>
    <option value="6" <?php echo ($tabla == "6"?"selected":"")?>>Sentencias Más Largas</option>
    <option value="7" <?php echo ($tabla == "7"?"selected":"")?>>Estados Con Más Víctimas</option>
    <option value="8" <?php echo ($tabla == "8"?"selected":"")?>>Delito Que Más Veces Se Ha Cometido</option>
    <option value="9" <?php echo ($tabla == "9"?"selected":"")?>>Porcentaje De Mujeres / Hombres Criminales</option>
    <option value="10" <?php echo ($tabla == "10"?"selected":"")?>>Armas Utilizadas En Más Casos</option>
    </select>
    <label>Análisis</label>
</div>
</form>
<?php
switch($tabla){
    case "":
        $sql = "select A.Id as idDepartamento, sum(A.Cantidad) as cantidad
        from (
        select Departamentos.Id, count(*) as Cantidad
        from Policías, ActividadPolicial, Departamentos
        where
            Departamentos.Id = Policías.IdDepartamento
            AND
            Policías.Id = ActividadPolicial.IdPolicía
        group by Departamentos.id, ActividadPolicial.Id
        ) A
        group by idDepartamento order by cantidad DESC;";
        $titulos = "<tr><th> idDepartamento</th><th>Cantidad</th></tr>";
        break;
    case "1":
        $sql = "select A.Id as idDepartamento, sum(A.Cantidad) as cantidad
        from (
        select Departamentos.Id, count(*) as Cantidad
        from Policías, ActividadPolicial, Departamentos
        where
            Departamentos.Id = Policías.IdDepartamento
            AND
            Policías.Id = ActividadPolicial.IdPolicía
        group by Departamentos.id, ActividadPolicial.Id
        ) A
        group by idDepartamento order by cantidad DESC;";
        $titulos = "<tr><th> idDepartamento</th><th>Cantidad</th></tr>";
        break;
    case "2":
        $sql = "select Criminales.RFC, SUM(Sentencia.Tiempo)AS Total_Sentencia FROM Criminales,DetallesDelito, Sentencia 
        WHERE 
            Criminales.RFC = DetallesDelito.IdCriminal AND
            DetallesDelito.IdSentencia = Sentencia.Id
        GROUP BY Criminales.RFC
        ORDER BY Total_Sentencia DESC;";
        $titulos = "<tr><th> RFC</th><th>Total Sentencia</th></tr>";
        break;
    case "3":
        $sql = "select MONTHNAME(DetallesDelito.Fecha)AS Mes,COUNT(DetallesDelito.IdDelito) AS Cantidad_Delitos 
        FROM DetallesDelito
        GROUP BY Mes 
        ORDER BY Cantidad_Delitos DESC;";
        $titulos = "<tr><th> Mes</th><th>Cantidad de Delitos</th></tr>";
        break;
    case "4":
        $sql = "select Criminales.RFC , COUNT(Casos.RFCVictima) AS NumeroDeVictimas FROM Casos, DetallesDelito, Criminales 
        WHERE
            Casos.IdDetallesDelito = DetallesDelito.Id AND
            DetallesDelito.IdCriminal = Criminales.RFC
            GROUP BY Criminales.RFC ORDER BY NumeroDeVictimas DESC;";
        $titulos = "<tr><th> RFC</th><th>NumeroDeVictimas</th></tr>";
        break;
    case "5":
        $sql = "select COUNT(*) FROM detallesarmas
        WHERE
        detallesarmas.IdArma IN (
            SELECT detallesarmas.IdArma FROM detallesarmas
                GROUP BY detallesarmas.IdArma
                HAVING COUNT(*)>1
            );";
        $titulos = "<tr><th>Armas </th></tr>";
        break;
    case "6":
        $sql = "select sentencia.Tiempo
        FROM sentencia
        ORDER BY Tiempo DESC;";
        $titulos = "<tr><th>Tiempo</th></tr>";
        break;
    case "7":
        $sql = "select victimas.Estado, COUNT(*) as num_repeticiones 
        FROM victimas
            GROUP BY victimas.Estado
            HAVING COUNT(*)>1
            ORDER BY num_repeticiones DESC;";
        $titulos = "<tr><th>Estado</th><th>Repeticiones</th></tr>";
        break;
    case "8":
        $sql = "select DetallesDelito.IdDelito, Delitos.Descripción, COUNT(*) as 'N Veces'
        FROM DetallesDelito INNER JOIN Delitos
        ON DetallesDelito.IdDelito = Delitos.Id
        GROUP BY DetallesDelito.IdDelito
        ORDER BY COUNT(*) DESC;";
        $titulos = "<tr><th>Id Delitos</th><th>Descripción</th><th>Número de Veces</th></tr>";
        break;
    case "9":   
        $sql = "select Criminales.Sexo as 'Género', COUNT(*) / (SELECT COUNT(*)FROM Criminales) * 100 as 'Porcentaje'
        FROM Criminales
        GROUP BY Criminales.Sexo;";
        $titulos = "<tr><th>Género</th><th>Porcentaje</th></tr>";
        break;
    case "10":
        $sql = "select Armas.Id, Armas.Nombre, COUNT(*)  'Detenciones'
        FROM Armas, DetallesArmas, Policías,ActividadPolicial, DetallesDelito
        WHERE 
            Armas.Id = DetallesArmas.IdArma
            AND
            DetallesArmas.IdPolicía = Policías.Id
            AND
            Policías.Id = ActividadPolicial.IdPolicía
            AND 
            ActividadPolicial.IdDelito = DetallesDelito.Id
        GROUP BY Armas.Id
        ORDER BY 'Detenciones';";
        $titulos = "<tr><th>IdArmas</th><th>Nombre</th><th>Número de Detenciones</th></tr>";
        break;
}
$result = query($sql);
echo "<table>";
echo "$titulos";
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
