<?php
    # Uncomment line below to show any errors
    # ini_set('display_errors', 1);

    require_once 'DatabaseLogin.php';
    session_start();

    # Directory for image storage
    $target_dir = "uploads/";

    # Retrieves timestamp
    $t=time();

    # Retrieves uploaded files names and adds directory and timestamp
    $_SESSION['target_file'] = $target_dir .$t. basename($_FILES["fileToUpload"]["name"]);

    $uploadOk = 1;

    # Retrieves image file type
    $imageFileType = strtolower(pathinfo($_SESSION['target_file'],PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        echo "Sorry, only JPG, JPEG, & PNG  files are allowed.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($_SESSION['target_file'])) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $_SESSION['target_file'])) {
            echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

            # Uploads Poll Details
            $query = "INSERT INTO `Poll` (`ClassID`, `Type`, `Topic`, `Question`) VALUES ('".$_SESSION['class']."', '".$_POST['Type']."', '".$_POST['topic']."','".$_SESSION['target_file']."')";

            if(mysqli_query($connection, $query)){
                echo "Records inserted successfully.";
                header("Location: InstructorPollStart.php");
            } else {
                echo "ERROR: Could not able to execute $query. " . mysqli_error($connection);
            }

        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
?>

<?php
    # Retrieves PID
   $query = "SELECT PID FROM Poll WHERE Question = '".$_SESSION['target_file']."'";
   $result = mysqli_query($connection, $query);

   if ($result->num_rows > 0) {
       // output data of each row
       while ($row = $result->fetch_assoc()) {
           $_SESSION['PID'] = $row["PID"];
       }
   }
?>

