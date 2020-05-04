<?php
# Uncomment line below to show any errors
# ini_set('display_errors', 1);

require 'DatabaseLogin.php';
session_start();

?>
<!DOCTYPE html>
<html>
<body>
<title>Poll Results</title>
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
    <a href="InstructorHome.php" class="w3-bar-item w3-button">Home</a>
    <a href="#" class="w3-bar-item w3-button">Gradebook</a>
    <a href="#" class="w3-bar-item w3-button">Account Options</a>
    <a href="Logout.php" class="w3-bar-item w3-button">Logout</a>
</nav>

<!-- Header -->
<header class="w3-container w3-theme w3-padding" id="myHeader">
    <i onclick="w3_open()" class="fa fa-bars w3-xlarge w3-button w3-theme"></i>
    <div class="w3-center">

        <h3><img src="Images/img_salem_state_logo.png" alt="SSU_Logo" style="width:40%"></h3>
        <h1>Poll Results</h1>

    </div>
</header>

<style>
    .container {
        padding: 16px;
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

<?php

    # Retrieves PID
    $query = "SELECT Poll.PID FROM Poll WHERE Question = '".$_SESSION['target_file']."'";

    $result = mysqli_query($connection, $query);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $PID = $row['PID'];
        }
    }

    # Updates Polls Status
    $query = "UPDATE Poll SET Poll.Status ='Done' WHERE Poll.PID = '".$PID."'";
    $result = mysqli_query($connection, $query);

    # Retrieves all answers to the poll
    $query = "SELECT Student_takes_Poll.Choice, COUNT(*) AS total
                FROM Student_takes_Poll WHERE Student_takes_Poll.PID = '".$PID."' GROUP BY Choice";

    $result = mysqli_query($connection, $query);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<br> " . $row["Choice"] . " - " . $row["total"] . "<br>";
        }
    } else {
        echo "No Answers Available.";
    }

?>

<form method="POST" action="#">

    <div class="container">
        <label for="Answer"><b>Answer</b></label>
        <input type="text" placeholder="Enter Correct Answer" name="Answer" required>
        <button type="submit">Enter Answer</button>
    </div>
</form>

<?php

# Adds correct answer to Poll
if(isset($_POST['Answer'])){
   $query = "UPDATE Poll SET Poll.Answer ='".$_POST['Answer']."' WHERE Poll.PID =  '".$PID."'";
   $result = mysqli_query($connection, $query);
   echo "<script>window.close();</script>";
}
?>