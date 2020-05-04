<?php
# Uncomment line below to show any errors
# ini_set('display_errors', 1);

require 'DatabaseLogin.php';
session_start();


?>
<!DOCTYPE html>
<html>
<body>
<title>Instructors Poll</title>
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

        <h3><img src="Images/img_salem_state_logo.png" alt="SSU_Logo" style="width:40%" height="auto"></h3>

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

<img src="<?php echo $_SESSION['target_file']; ?>"  />

<input type="text" id="txt">
<button onclick="stopPoll()">End Poll!</button>

<script>
    // set some variables
    var c = 0;
    var t;
    var timer_is_on = 0;
    timedPoll();

    // start timer
    function timedPoll() {
        document.getElementById("txt").value = c;
        c = c + 1;
        t = setTimeout(timedPoll, 1000);
    }

    // stop timer
    function stopPoll() {
        clearTimeout(t);
        timer_is_on = 0;
        window.location = "http://weblab.salemstate.edu/~studentpoll/StudentPoll/InstructorsClass.php";
        window.open("http://weblab.salemstate.edu/~studentpoll/StudentPoll/InstructorPollEnd.php");
    }
</script>

</body>
</html>
