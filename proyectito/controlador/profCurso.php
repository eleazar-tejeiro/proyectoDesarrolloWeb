<?php
include("../vista/include/encabezado.php");
include("../vista/include/navegadorIzqui.php");
?>

<div class="row">
	<div class="column middle">
		<?php
        include("../modelo/revisaProfesor.php");

        $usuarioID=$_SESSION['usuarioID'];
        $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
        $sql = "SELECT * FROM recursos r, curso c
				WHERE r.propietario = c.cursoPropietario
				AND r.propietario = $usuarioID AND r.cursoID = c.cursoID";

        $resource= mysqli_query($conn, $sql);

        if (mysqli_num_rows($resource)<1) {  // verifica si el profesor ha subido algun recurso
            echo "No has subido ningún recurso a tus cursos impartidos.";
        } else {
            echo "<h2>Recursos subidos a tus cursos</h2>";
            echo "<table border='2'>";
            echo "<tr><th>Titulo</th><th>Enlace de descarga</th><th>Curso</th><th>Fecha de carga</th></tr>";
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
        }

        mysqli_close($conn);
        ?>
	</div>
</div>
<?php
include("../vista/include/piePagina.php");
?>
