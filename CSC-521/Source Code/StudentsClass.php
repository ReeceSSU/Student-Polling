<?php
# Uncomment line below to show any errors
# ini_set('display_errors', 1);

require_once 'DatabaseLogin.php';
session_start();
?>

<!DOCTYPE html>
<html>
<title>Students Class</title>
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

    <style>

        /* Box Around Student List */
        .boxed {
            border: 3px solid royalblue;
            padding: 15px 24px; /* Some padding */
            float:right;
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
<br>
<div style="text-align: center;"> <h2>
        <?php
        $query="SELECT Course.CourseID, Course.CourseName 
                    FROM Course, Class 
                        WHERE Course.CourseID = Class.CourseID
                            AND Class.ClassID ='".$_SESSION['class']."'";
        $result = mysqli_query($connection, $query);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "Welcome to " .$row["CourseID"]." - " .$row["CourseName"];
            }
        }
        ?>
    </h2></div>

<div style="text-align: center;"> <h3>
    <?php
    $query="SELECT Instructor.Lname 
                FROM Instructor, Class 
                    WHERE Instructor.TID = Class.TID
                            AND Class.ClassID ='".$_SESSION['class']."'";
    $result = mysqli_query($connection, $query);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "This class is run by Professor ".$row["Lname"]. "<br>";
        }
    } else {
        echo "No Professor In Class";
    }
    ?>
    </h3>
</div>
<hr>
<div style="text-align: center;">
    <h3>Active Polls</h3>
    <?php
    $query="SELECT Question FROM Poll, Class
                    WHERE Poll.Status = 'In-Progress' AND Poll.ClassID = Class.ClassID
                        AND Class.ClassID ='".$_SESSION['class']."'";
    $result = mysqli_query($connection, $query);
    $active_row_num = 1;

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $image = $row['Question'];

            echo "<form method='POST'>";
            echo "<input type='submit' name='Active_Question_Button' value='Question:$active_row_num'/>";
            echo "</form>";

            echo "<br>";
            echo "<img src='$image' style= \"max-width:600px; width:100%\"/>";
            echo "<br>";

            if ($active_row_num != $result->num_rows) {
                $active_row_num = $active_row_num + 1;
            }
        }

    } else {
        echo "No Polls Are Available";
    }
    ?>

    <?php
    if(isset($_POST['Active_Question_Button'])) {

            $buttonValue = $_POST['Active_Question_Button'];
            $l = strlen($buttonValue);
            $p = stripos($buttonValue, ":");

            $_SESSION['questionNumber'] = substr($buttonValue, $p + 1, $l - $p + 1);

            echo '<script type="text/javascript">
                        window.location = "ActivePoll.php"
                  </script>';
    }
    ?>
</div>

<br><hr><br>
<div style="text-align: center;">
    <h3>Completed Polls</h3>
    <?php
    $query="SELECT Question FROM Poll, Class
                    WHERE Poll.Status = 'Done' AND Poll.ClassID = Class.ClassID
                        AND Class.ClassID ='".$_SESSION['class']."'";
    $result = mysqli_query($connection, $query);
    $row_num = 1;

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $image = $row['Question'];

            echo "<form method='POST'>";
                echo "<input type='submit' name='Question_Button' value='Question:$row_num'/>";
            echo "</form>";

            echo "<br>";
            echo "<img src='$image' style= \"max-width:600px; width:100%\"/>";
            echo "<br>";

            if ($row_num != $result->num_rows) {
                $row_num = $row_num + 1;
            }
        }

    } else {
        echo "No Polls Are Available";
    }
    ?>

    <?php
    if(isset($_POST['Question_Button'])) {

            $buttonValue = $_POST['Question_Button'];
            $l = strlen($buttonValue);
            $p = stripos($buttonValue, ":");

            $_SESSION['questionNumber'] = substr($buttonValue, $p + 1, $l - $p + 1);

            echo '<script type="text/javascript">
                        window.location = "PollArchive.php"
                  </script>';

    }
    ?>
</div>
</body>
</html>

