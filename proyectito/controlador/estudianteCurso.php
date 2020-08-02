<?php
include("../vista/include/encabezado.php");
include("../vista/include/navegadorIzqui.php");
?>

<div class="row">
	<div class="column middle">
		<?php
        include("../modelo/revisaEstudiante.php");

        $usuarioID=$_SESSION['usuarioID'];
        $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
        $sql = "SELECT * FROM recursos r, curso c
				WHERE r.cursoID=c.cursoID AND nombreArchivo NOT LIKE '%.%'
				AND c.cursoID IN (SELECT cursoID FROM estudianteCurso WHERE usuarioID=$usuarioID)";

        $resource= mysqli_query($conn, $sql);

        if (mysqli_num_rows($resource)<1) {  // verifica si el estudiante está inscrito
            echo "Tampoco estás inscrito en ningún curso.
				<br>Si se ha inscrito en un curso, comuníquese con el profesor / administrador para autorizarlo en el curso";
        } else {
            echo "<h2>Recursos subidos</h2>";
            echo "<table border='2'>";
            echo "<tr><th>Nombre</th><th>Enlace de descarga</th><th>Curso</th><th>Fecha de carga</th></tr>";
            while ($row = mysqli_fetch_array($resource)) {
                $id = $row["id"];
                $name = $row["name"];
                $nombreArchivo = $row["nombreArchivo"];
                $curso = $row["cursoNombre"];
                $fechaSubida = $row["fechaSubida"];

                echo "<td>$name</td>";
                echo "<td><a href='recursos/$nombreArchivo'>$nombreArchivo</a></td>";
                echo "<td>$curso</td><td>$fechaSubida</td>";
                echo "</tr>";
            }
            echo "</table><br>";

            // $sql = "SELECT * FROM recursos r, curso c, usuarios u
			// 		WHERE r.cursoID=c.cursoID AND r.propietario=u.usuarioID AND nombreArchivo LIKE '%.txt'
			// 		AND r.cursoID IN (SELECT cursoID FROM estudianteCurso WHERE usuarioID=$usuarioID) ";
            // $resource = mysqli_query($conn, $sql);
        }

        mysqli_close($conn);
        ?>
	</div>
</div>
<?php
include("../vista/include/piePagina.php");
?>
