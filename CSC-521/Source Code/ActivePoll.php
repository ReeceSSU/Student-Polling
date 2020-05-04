<?php
# Uncomment line below to show any errors
# ini_set('display_errors', 1);

require_once 'DatabaseLogin.php';
session_start();
?>

<!DOCTYPE html>
<html>
<title>Active Poll</title>
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
    .btn-group button {
        background-color: #449baf; /* Blue background */
        border: 1px solid #3d578e; /* Blue border */
        color: white; /* White text */

        cursor: pointer; /* Pointer/hand icon */

        float:left; /* Float the buttons side by side */
        padding: 10px 24px; /* Some padding */

    }

    /* Clear floats (clearfix hack) */
    .btn-group:after {
        content: "";
        clear: both;
        display: table;
    }

    .btn-group button:not(:last-child) {
        border-right: none; /* Prevent double borders */
    }

    /* Add a background color on hover */
    .btn-group button:hover {
        background-color: #2b7080;
    }

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
    $query = "SELECT Poll.Question, Poll.Type 
                    FROM Poll, Class
                        WHERE Poll.ClassID = Class.ClassID AND Poll.Status = 'In-Progress' AND Class.ClassID ='".$_SESSION['class']."' LIMIT 1 OFFSET $Offset";
    $result = mysqli_query($connection, $query);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $type = $row['Type'];
            $image = $row['Question'];
            echo "<img src='$image' style= \"max-width:600px; width:100%\"/>";
        }

    } else {
        echo "No Poll Is Available";
    }

    # Get PID of Question
    $query = "SELECT Poll.PID FROM Poll WHERE Question = '".$image."'";
    $result = mysqli_query($connection, $query);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $PID = $row['PID'];
        }
    }

    # Get users SID
    $query = "SELECT SID FROM Student WHERE Student.Username = '".$_SESSION['uname']."'";
    $result = mysqli_query($connection, $query);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $SID = $row['SID'];
        }
    }
?>
</div>

<br>

<div style="text-align: center;">
<?php

    # PHP Block only runs if the question type is multiple choice
    if ($type == 'Multiple Choice') {
        echo "<h3>".$type."</h3>";
        echo "<form method='POST'>";
            echo "<div class='btn-group' style='width:100%'>";
            echo "<button name = 'Choice' value = 'A' style ='width:20%'>A</button>";
            echo "<button name = 'Choice' value = 'B' style ='width:20%'>B</button>";
            echo "<button name = 'Choice' value = 'C' style ='width:20%'>C</button>";
            echo "<button name = 'Choice' value = 'D' style ='width:20%'>D</button>";
            echo "<button name = 'Choice' value = 'E' style ='width:20%'>E</button>";
            echo "</div>";
        echo "</form>";

        if (isset($_POST['Choice'])) {

            $Choice = $_POST['Choice'];

            # Retrieves Students Answer if it exists
            $query = "SELECT Choice FROM Student_takes_Poll WHERE PID = '" . $PID . "' AND SID = '" . $SID . "' ";
            $result = mysqli_query($connection, $query);

            # Students Answer exists
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $Choice = $row['Choice'];
                    echo "You Have Already Answered: " . $Choice;
                    echo "<br>";
                    echo "It Is Safe To Close This Window Or Go Back To Class";
                }
            # Students Answer does not exist
            } else {
                $query = "INSERT INTO `Student_takes_Poll` (`SID`, `PID`, `Choice`) VALUES ('" . $SID . "', '" . $PID . "', '" . $Choice . "')";
                $result = mysqli_query($connection, $query);
                }
            }

        }
?>
</div>

<div style="text-align: center;">
<?php

    # PHP Block only runs if the question type is short answer
    if ($type == 'Short Answer') {
        echo "<h3>".$type."</h3>";
        echo "<form method='POST' action='#'>";
            echo "<div class='container'>";
            echo "<label for='ShortAnswer'></label>";
            echo "<input type='text' placeholder='Enter Answer' name='ShortAnswer' required>";
            echo "<button type='submit'>Enter Answer</button>";
            echo "</div>";
        echo "</form>";

        if (isset($_POST['ShortAnswer'])) {
            $Choice = $_POST['ShortAnswer'];

            # Retrieves Students Answer if it exists
            $query = "SELECT Choice FROM Student_takes_Poll WHERE PID = '" . $PID . "' AND SID = '" . $SID . "' ";
            $result = mysqli_query($connection, $query);

            # Students Answer exists
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $Choice = $row['Choice'];
                    echo "You Have Already Answered: " . $Choice;
                    echo "<br>";
                    echo "It Is Safe To Close This Window Or Go Back To Class";
                }
                # Students Answer does not exist
            } else {
                $query = "INSERT INTO `Student_takes_Poll` (`SID`, `PID`, `Choice`) VALUES ('" . $SID . "', '" . $PID . "', '" . $Choice . "')";
                $result = mysqli_query($connection, $query);
            }
        }
    }
?>
</div>

</body>
</html>
