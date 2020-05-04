<!DOCTYPE html>
<html>
<title>HomePage</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css">
<body>


<!-- Header -->
<header class="w3-container w3-theme w3-padding" id="myHeader">
    <div class="w3-center">
        <h3><img src="Images/img_salem_state_logo.png" alt="SSU_Logo" style="width:40%"></h3>
        <h1>Welcome To The Student Polling App</h1>
        <h2>Please Select A Login Type</h2>
    </div>
</header>

<style>
    {
        box-sizing: border-box;
    }

    .column {
        float: left;
        width: 33.33%;
        padding: 5px;
    }

    /* Clearfix (clear floats) */
    .row::after {
        content: "";
        clear: both;
        display: table;
    }
</style>
</body>
<body>
<div class="row">
    <div class="column">
        <a href="StudentLogin.php">
            <img src="Images/img_student.png" alt="Student" style="width:80%">
            <h3>Student</h3>
    </div>
    <div class="column">
        <a href="InstructorLogin.php">
            <img src="Images/img_instructor.png" alt="Instructor" style="width:80%">
            <h3>Instructor</h3>
    </div>
    <div class="column">
        <a href="AdminLogin.php">
            <img src="Images/img_admin.png" alt="Admin" style="width:80%">
            <h3>Admin</h3>
    </div>
</div>

</body>
</html>