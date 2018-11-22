<?php 

$path = "../download/";
 
if (isset($_GET['username']) && isset($_GET['card_id'])) {
    // $dbhost = "127.0.0.1";
    $dbhost = "localhost";
    // $dbuser = "qrcodes";
    $dbuser = "id6027434_qradmin";
    $dbpass = "Ce03081989";
    // $dbname = "qrcodes";
    $dbname = "id6027434_qrcodes";
    $db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    $user = $_GET['username'];
    $card = $_GET['card_id'];

    // echo "all good <br>";
    // echo "user ", $user, "<br>";
    // echo "card ", $card, "<br>";


    // $fileId = $db->real_escape_string($_GET['fid']);

    $stmt = "";

    if(!($stmt = $db->prepare("SELECT username, hasSuscription FROM users WHERE username = ?"))){
        die( "Error1 preparing: (" .$db->errno . ") " . $db->error);
    }

    if(!($stmt->bind_param("s", $user))){
        die( "Error1 binding: (" .$db->errno . ") " . $db->error);
    }
    $stmt->execute();
    $stmt->bind_result($res_username, $res_status);
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        // echo "user exists! <br>";
        $stmt->fetch();
        $stmt->close();
        if ($res_status == "1"){
            // echo "suscription active <br>";

            if(!($stmt = $db->prepare("SELECT filename FROM cards WHERE user = ? AND id = ?"))){
                die( "Error preparing: (" .$db->errno . ") " . $db->error);
            }

            if(!($stmt->bind_param("si", $user, $card))){
                die( "Error binding: (" .$db->errno . ") " . $db->error);
            }
            if(!($stmt->execute())){
                die( "Error executing: (" .$db->errno . ") " . $db->error);
            }
            $stmt->bind_result($filename);
            $stmt->store_result();

            if ($stmt->num_rows != 1){
                die("Wrong username/card_id combination");
            }

            $stmt->fetch();
            $stmt->close();

            $fullPath = $path.$filename;

            // echo "Filename fetched", $fullPath;

            $quoted = sprintf('"%s"', addcslashes(basename($filename), '"\\'));
            // echo "<br>quoted", $quoted;
            $size   = filesize($fullPath);

            //To Download:

             header('Content-Description: File Transfer');
             header('Content-Type: application/octet-stream');
             header('Content-Disposition: attachment; filename=' . $quoted); 
             header('Content-Transfer-Encoding: binary');
             header('Connection: Keep-Alive');
             header('Expires: 0');
             header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
             header('Pragma: public');
             header('Content-Length: ' . $size);

             ob_clean();
             flush(); // Flush system output buffer
             while (@ob_end_clean());
             readfile($fullPath);
             exit;

            //To display:

            //header('Content-Type: image/jpg');
            //$image= file_get_contents($fullPath);
            //echo $image;
        }
        else{
            echo "Suscription inactive";
        }
    } else {
        echo "Username ",$user," does not exist";
    }
} else {
    echo "Bad Url";
}

?>