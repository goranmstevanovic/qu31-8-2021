<html>
<head>
    
</head>
<body>
<?php
// core configuration
include_once "config/core.php";

// set page title
$page_title = "Molim vas da se registrujete";

// include login checker
//include_once "login_checker.php";

// include classes
include_once 'config/database.php';
include_once 'objects/user.php';


// include page header HTML
include_once "layout_head.php";

echo "<div class='col-md-12'>";

// registration form HTML
// code when form was submitted
// if form was posted
if($_POST){

    // get database connection
    $database = new Database();
    $db = $database->getConnection();

    // initialize objects
    $user = new User($db);
    

    // set user email to detect if it already exists
    $user->email=$_POST['email'];

    // check if email already exists
    if($user->emailExists()){
        echo "<div class='alert alert-danger'>";
        echo "The email adresu koju ste naveli vec je registrovana u sistemu pa Vas molimo da navedete drugu  <a href='{$home_url}register'>Pokusajte ponovo</a>";
        echo "</div>";
    }

    else{
        // create user
        // set values to object properties
        $user->firstname=$_POST['firstname'];
        $user->lastname=$_POST['lastname'];
        $user->password=$_POST['password'];
        $user->access_level='Customer';
        $user->status=1;
        if($_POST['password_r'] == $user->password ){
             // create the user
                if($user->create()){

                    
                    echo "<div class='alert alert-info'>";
                    echo "Uspesno ste generisali novog saradnika. <b><a href='{$home_url}login'>Molim Vas da se logujete</a>.</b>";
                    echo "</div>";
                
                    // empty posted values
                    $_POST=array();
                

                }else{
                    echo "<div class='alert alert-danger' role='alert'> Neuspešna registracija. Molimo Vas da pokušate ponovo. </div>";
                }

        }else{
            echo "<div class='alert alert-danger' role='alert'> Neuspešna registracija. Ne slazu se osnovni i ponovljeni password. </div>";
        }
       
    }
}
?>
    <form action='register.php' method='post' id='register'>

        <table class='table table-responsive'>

            <tr>
                <td class='width-30-percent'>Ime:</td>
                <td><input type='text' name='firstname' class='form-control' required value="<?php echo isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname'], ENT_QUOTES) : "";  ?>" /></td>
            </tr>

            <tr>
                <td>Prezime:</td>
                <td><input type='text' name='lastname' class='form-control' required value="<?php echo isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname'], ENT_QUOTES) : "";  ?>" /></td>
            </tr>

            
            <tr>
                <td>Email:</td>
                <td><input type='email' name='email' class='form-control' required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES) : "";  ?>" /></td>
            </tr>

            <tr>
                <td>Password (Min 8 znakova):</td>
                <td><input type='password' name='password' class='form-control' required id='passwordInput'></td>
            </tr>
            <tr>
                <td>Ponovite password :</td>
                <td><input type='password' name='password_r' class='form-control' required id='passwordInput_r'></td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <button type="submit" class="btn btn-primary">
                        <span class="glyphicon glyphicon-plus"></span> Register
                    </button>
                </td>
            </tr>

        </table>
    </form>
<?php

echo "</div>";

// include page footer HTML
include_once "layout_foot.php";
?>
</body>
</html>
