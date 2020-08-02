<?php
include("../vista/include/encabezado.php");
include("../vista/include/navegadorIzqui.php");
?>

<div class="row">
	<div class="column middle">
		<?php
        include("../modelo/revisaEstudiante.php");

        // si el cuestionario está configurado, avance
        $usuarioID = $_SESSION["usuarioID"];
        if (!isset($_GET["quiz"])) {
            header("Location: estudianteCurso.php");
        } else {
            $quizFile = $_GET["quiz"];
        }

        if (!isset($_GET["q1"])) {
            // si el cuestionario no se completa, se lo muestra al usuario
            $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
            $sql = "SELECT * FROM takenQuizzes WHERE nombreArchivo='$quizFile' AND usuarioID='$usuarioID';";
            $resource = mysqli_query($conn, $sql);
            $numRows = mysqli_num_rows($resource);

            if ($numRows > 0) {  // comprobar si se toma
                echo"¡YA TOMASTE ESTE EXAMEN!";
                echo "<p>Redirigiéndote a la página de cursos ...</p>";
                header("Refresh: 3; url=estudianteCurso.php");
                die();
                mysqli_close($conn);
            }

            $quiz = $_GET["quiz"];
            $quizLines = file("recursos/$quiz");
            $lineNum = 0;
            $qNum = 1;

            if (sizeof($quizLines) == 0) { 	// comprueba si existe un cuestionario
                header("Location: estudianteCurso.php");
            }

            echo "<form method='get' action='estudianteTomaCuest.php'>";
            echo "<input type='hidden' name='quiz' value='$quizFile'/>";
            // muestra líneas de prueba
            foreach ($quizLines as $line) {
                if ($lineNum % 6 == 0) {   // muestra preguntas
                    echo "<br><p>$line</p>";
                } elseif ($lineNum % 6 >=1 && $lineNum % 6 <=4) {  // muestra respuestas
                    $letter = ($lineNum % 6) + 96;
                    $letter = chr($letter);
                    echo "<input type='radio' name='q$qNum' value='$letter'/>";
                    echo "$line<br/>";
                } elseif ($lineNum % 6 == 5) {  // obtener la respuesta correcta del archivo de texto
                    $correctAnswer = trim($line);
                    echo "<input type='hidden' name='a$qNum' value='$correctAnswer'/>";
                    $qNum ++;
                }
                $lineNum++;
            }
            echo "<br><input type='submit' value='SUBMIT ANSWERS'/>";
            echo "</form>";
            mysqli_close($conn);
        } else {
            //adds quiz information to table
            $quiz = $_GET["quiz"];
            $quizLines = file("recursos/$quiz");
            $lineNum = 0;
            $qNum = 0;

            foreach ($quizLines as $line) {
                if ($lineNum % 6 == 0) {   //gets number of questions for functions later
                    $qNum++;
                }
                $lineNum++;
            }

            //store information in arrays for later comparison
            $correctAnswers = array();
            $theirAnswers = array();
            for ($i=1;$i<=$qNum;$i++) {
                $theirAnswers[] = trim($_GET["q$i"]);
                $correctAnswers[] = trim($_GET["a$i"]);
            }

            //show what questions where answered correctly/ incorrectly
            for ($i=1;$i<=$qNum;$i++) {
                $qIndex = $i-1;
                $text = "For Question $i, you answered $theirAnswers[$qIndex], and the correct answer was $correctAnswers[$qIndex].";
                if ($theirAnswers[$qIndex] == $correctAnswers[$qIndex]) {
                    echo "<p style='color:green'>$text</p>";
                } else {
                    echo "<p style='color:red'>$text</p>";
                }
                echo "<br>";
            }
            //tally correct answers
            $today = date('Y-m-d');
            $score = 0;
            for ($i=1;$i<=$qNum;$i++) {
                if ($theirAnswers[$i-1]== $correctAnswers[$i-1]) {
                    $score ++;
                }
            }
            //convert score into percentage and display it
            $finalScore = ($score / $qNum)*100;
            $finalScore = round($finalScore, 2);
            echo "<p style='font-size:20px; font-weight:bold'>You're final score is $score/$qNum : $finalScore% <br></p>";

            //get the cursoID to insert into takenQuiz table
            $conn = mysqli_connect("localhost", "root", "", "BDClaseVirtual");
            $sql = "SELECT cursoID, name FROM recursos WHERE nombreArchivo='$quiz' ";
            $resource = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($resource);
            $cursoID = $row['cursoID'];
            $name = $row['name'];
            $nombreArchivo = $_GET["quiz"];

            //insert quiz info into database
            $sql = "INSERT INTO takenQuizzes (name, nombreArchivo, usuarioID, score, questions, finalScore, cursoID, takenDate)
					VALUES('$name','$nombreArchivo','$usuarioID','$score','$qNum','$finalScore' ,'$cursoID','$today')";
            mysqli_query($conn, $sql) or die(mysqli_error($conn));
            mysqli_close($conn);

            echo "<a href='estudianteCurso.php'>Click here to return to Cursos page<a>";
        }
?>
	</div>
</div>
<?php
include("../vista/include/piePagina.php");
?>
