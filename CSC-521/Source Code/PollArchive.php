<?php
# Uncomment line below to show any errors
# ini_set('display_errors', 1);

require_once 'DatabaseLogin.php';
session_start();
?>

<!DOCTYPE html>
<html>
<title>Poll Archive</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css">
<body>

<!-- Side Navigation -->
<nav class="w3-sidebar w3-bar-block w3-card w3-animate-left w3-center" style="display:none" id="mySidebar">
    <h1 class="w3-xxxlarge w3-text-theme">Side Navigation</h1>
    <button class="w3-bar-item w3-button" onclick="w3_close()">Close <i class="fa fa-remove"></i></button>
    <a href="StudentHome.php" class="w3-bar-item w3-button">Home</a>
    <a href="StudentsClass.php" class="w3-bar-item w3-button">Back To Class</a>
    <a href="#" class="w3-bar-item w3-button">Gradebook</a>
    <a href="#" class="w3-bar-item w3-button">Account Options</a>
    <a href="Logout.php" class="w3-bar-item w3-button">Logout</a>
</nav>

<!-- Header -->
<header class="w3-container w3-theme w3-padding" id="myHeader">
    <i onclick="w3_open()" class="fa fa-bars w3-xlarge w3-button w3-theme"></i>
    <div class="w3-center">
        <h3><img src="Images/img_salem_state_logo.png" alt="SSU_Logo" style="width:40%"></h3>
    </div>
</header>

<script>
    // Side navigation
    function w3_open() {
        var x = document.getElementById("mySidebar");
        x.style.width = "100%";
        x.style.fontSize = "40px";
        x.style.paddingTop = "10%";
        x.style.display = "block";
    }
    function w3_close() {
        document.getElementById("mySidebar").style.display = "none";
    }
</script>

<style>
    input[type=text] {
        width: 95%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }
    button {
        background-color: #13a4fd;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 95%;
    }

    button:hover {
        opacity: 0.8;
    }
</style>

<br> <div style="text-align: center;">
<?php
    # Set Offset to row # in table - 1
    $Offset = $_SESSION['questionNumber'] - 1;

    # Returns 1 row with question that matches the button that was pressed
    $query = "SELECT Question 
                    FROM Poll, Class
                        WHERE Poll.Status = 'Done' AND Poll.ClassID = Class.ClassID AND Class.ClassID ='".$_SESSION['class']."' LIMIT 1 OFFSET $Offset";
    $result = mysqli_query($connection, $query);

    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $image = $row['Question'];
        echo "<img src='$image' style= \"max-width:600px; width:100%\"/>";
    }

    } else {
        echo "No Poll Is Available";
    }
?>
</div>

<br>
<div style="text-align: center;">

<?php

    # Get PID from selected image
    $query = "SELECT Poll.PID FROM Poll WHERE Question = '".$image."'";
    $result = mysqli_query($connection, $query);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $PID = $row['PID'];
        }
    }

    # Retrieve Student Answer and Correct Answer
    $query = "SELECT Poll.Answer, Student_takes_Poll.Choice 
                        FROM Poll, Student_takes_Poll, Student
                            WHERE Student_takes_Poll.SID = Student.SID AND Poll.PID = Student_takes_Poll.PID 
                                AND Student.Username = '".$_SESSION['uname']."' AND Poll.Question = '".$image."'";
    $result = mysqli_query($connection, $query);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $userAnswer = $row['Choice'];
            $correctAnswer = $row['Answer'];
            echo "<h2> Your Answer: ".$userAnswer." </h2>";
            echo "<br>";
            echo "<h2> Correct Answer: ".$correctAnswer." </h2>";;
        }
    }
    else {
        $query = "SELECT Poll.Answer
                        FROM Poll
                            WHERE Poll.Question = '".$image."'";
        $result = mysqli_query($connection, $query);

        if ($result->num_rows > 0) {
        // output data of each row
            while ($row = $result->fetch_assoc()) {
                $correctAnswer = $row['Answer'];
                echo "<h2>Your Answer: No Answer</h2>";
                echo "<br>";
                echo "<h2> Correct Answer: ".$correctAnswer." </h2>";;
            }

        }
    }
?>
</div>
</body>
</html>