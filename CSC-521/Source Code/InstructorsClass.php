<?php
ini_set('display_errors', 1);

require_once 'DatabaseLogin.php';
session_start();
?>


<!DOCTYPE html>
<html>
<title>Instructors Class</title>
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
        <h1>Welcome <?php echo $_SESSION['uname']; ?></h1>
    </div>
    <style>

        /* Box Around Student List */
        .boxed {
            border: 3px solid royalblue;
            padding: 15px 24px; /* Some padding */
            float:right;
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

<form action="upload.php" method="POST" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <label for="Type">Type:</label>

    <select name="Type">
        <option value="Multiple Choice">Multiple Choice</option>
        <option value="Short Answer">Short Answer</option>
    </select>
    <input type="text" placeholder="Enter Topic" name="topic">

    <input type="submit" value="Start Poll" name="submit">
</form>
<div class="boxed">
    <h4> Students </h4>
    <?php
    $query="SELECT Student.Fname, Student.Lname 
                FROM Student, Class, Student_takes_Class 
                    WHERE Student_takes_Class.SID = Student.SID AND Class.ClassID = Student_takes_Class.ClassID
                            AND Class.ClassID ='".$_SESSION['class']."'";
    $result = mysqli_query($connection, $query);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<br> ". $row["Fname"]. " "  .$row["Lname"]. "<br>";
        }
    } else {
        echo "No Students In Class";
    }
    ?>
</div>

</body>
</html>
