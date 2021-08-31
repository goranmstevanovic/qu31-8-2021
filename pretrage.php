<?php
include_once "config/core.php";
if(isset($_GET['pretraga']) ){
    $rec = $_GET['pretraga'];
  //  echo "Trazena rec je: ", $rec;
}


// core configuration
include_once "config/core.php";

// set page title
$page_title = "pretrage";

// include login checker

include_once "login_checker1.php";

// default to false
include_once "layout_head.php";

include_once "config/database.php";
    include_once "objects/user.php";

// get database connection
    $database = new Database();
    $db = $database->getConnection();

// initialize objects
    $user = new User($db); ?>
    <h4>Trazena rec je: <?=$rec ?></h4>
    <table class='tabel table bordered'>
    <tr>
    <th>Ime</th><th>prezime</th><th>Email</th>
    </tr>
    
    <?php 
    $stmt_user = $user->search($rec);


    while($row_user = $stmt_user->fetch(PDO::FETCH_ASSOC)){?>
        <tr>
        <td>
        <?=$row_user['firstname']  ?>
        </td>
        <td>
        <?=$row_user['lastname']  ?>
        </td>
        <td>
        <?=$row_user['email']  ?>
        </td>
        </tr>
    <?php    
    }
    ?>
   </table>
<?php
include_once "layout_foot.php";