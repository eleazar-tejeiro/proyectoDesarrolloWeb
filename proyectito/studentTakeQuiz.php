<?php
include("include/header.php");
include("include/leftNav.php");
?>

<div class="row">
	<div class="column middle">
		<?php
        include("studentCheck.php");

        //if quiz is set, move forward
        $userID = $_SESSION["userID"];
        if (!isset($_GET["quiz"])) {
            header("Location: studentCourses.php");
        } else {
            $quizFile = $_GET["quiz"];
        }

        if (!isset($_GET["q1"])) {
            //if quiz is not completed, display it to user
            $conn = mysqli_connect("localhost", "root", "", "classDatabase");
            $sql = "SELECT * FROM takenQuizzes WHERE fileName='$quizFile' AND userID='$userID';";
            $resource = mysqli_query($conn, $sql);
            $numRows = mysqli_num_rows($resource);

            if ($numRows > 0) {  //check if taken
                echo"YOU HAVE ALREADY TAKEN THIS QUIZ!";
                echo "<p>Redirecting you back to the courses page...</p>";
                header("Refresh: 3; url=studentCourses.php");
                die();
                mysqli_close($conn);
            }

            $quiz = $_GET["quiz"];
            $quizLines = file("resource_uploads/$quiz");
            $lineNum = 0;
            $qNum = 1;

            if (sizeof($quizLines) == 0) { 	//check if quiz exists
                header("Location: studentCourses.php");
            }

            echo "<form method='get' action='studentTakeQuiz.php'>";
            echo "<input type='hidden' name='quiz' value='$quizFile'/>";
            //display quiz lines
            foreach ($quizLines as $line) {
                if ($lineNum % 6 == 0) {   //display questions
                    echo "<br><p>$line</p>";
                } elseif ($lineNum % 6 >=1 && $lineNum % 6 <=4) {  //display answers
                    $letter = ($lineNum % 6) + 96;
                    $letter = chr($letter);
                    echo "<input type='radio' name='q$qNum' value='$letter'/>";
                    echo "$line<br/>";
                } elseif ($lineNum % 6 == 5) {  //get correct answer from text file
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
            $quizLines = file("resource_uploads/$quiz");
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

            //get the courseID to insert into takenQuiz table
            $conn = mysqli_connect("localhost", "root", "", "classDatabase");
            $sql = "SELECT courseID, name FROM resources WHERE filename='$quiz' ";
            $resource = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($resource);
            $courseID = $row['courseID'];
            $name = $row['name'];
            $fileName = $_GET["quiz"];

            //insert quiz info into database
            $sql = "INSERT INTO takenQuizzes (name, fileName, userID, score, questions, finalScore, courseID, takenDate)
					VALUES('$name','$fileName','$userID','$score','$qNum','$finalScore' ,'$courseID','$today')";
            mysqli_query($conn, $sql) or die(mysqli_error($conn));
            mysqli_close($conn);

            echo "<a href='studentCourses.php'>Click here to return to Courses page<a>";
        }
?>
	</div>
</div>
<?php
include("include/footer.php");
?>
