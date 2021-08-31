<?php
/**
 * Created by PhpStorm.
 * User: goran
 * Date: 11.10.2019
 * Time: 13:51
 */

class user
{
    // database connection and table name
    private $conn;
    private $table_name = "users";

    // object properties
    public $id;
    public $firstname;
    public $lastname;
    public $email;
    public $contact_number;
    public $address;
    public $password;
    public $old_password;
    public $access_level;
    public $access_code;
    public $status;
    public $created;
    public $modified;
    public $plata;
    public $iznos_plate;
    public $color_prof;
    public $procentat_za_platu;
	public $procenat_za_platu;
    public $nacin_obracuna;
    public $fk_profesor;
    public $generete_date;
    public $end_date;

    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

    // check if given email exist in the database
    function emailExists()
    {

        // query to check if email exists
        $query = "SELECT id, firstname, lastname, access_level, password, status
            FROM " . $this->table_name . "
            WHERE email = ?
            LIMIT 0,1";

        // prepare the query
        $stmt = $this->conn->prepare( $query );

        // sanitize
        $this->email=htmlspecialchars(strip_tags($this->email));

        // bind given email value
        $stmt->bindParam(1, $this->email);

        // execute the query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        // if email exists, assign values to object properties for easy access and use for php sessions
        if($num>0){

            // get record details / values
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // assign values to object properties
            $this->id = $row['id'];
            $this->firstname = $row['firstname'];
            $this->lastname = $row['lastname'];
            $this->access_level = $row['access_level'];
            $this->password = $row['password'];
            $this->status = $row['status'];

            // return true because email exists in the database
            return true;
        }

        // return false if email does not exist in the database
        return false;
    }




    // create new user record
    function create(){

        // to get time stamp for 'created' field
        $this->created=date('Y-m-d H:i:s');

        // insert query
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                firstname = :firstname,
                lastname = :lastname,
                email = :email,
                password = :password,
                access_level = :access_level,
                status = :status,
                created = :created";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->firstname=htmlspecialchars(strip_tags($this->firstname));
        $this->lastname=htmlspecialchars(strip_tags($this->lastname));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->password=htmlspecialchars(strip_tags($this->password));
        $this->access_level=htmlspecialchars(strip_tags($this->access_level));
        $this->status=htmlspecialchars(strip_tags($this->status));

        // bind the values
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':lastname', $this->lastname);
        $stmt->bindParam(':email', $this->email);
        
       

        // hash the password before saving to database
        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);

        $stmt->bindParam(':access_level', $this->access_level);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':created', $this->created);
       


        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }else{
            $this->showError($stmt);
            return false;
        }

    }
    public function showError($stmt){
        echo "<pre>";
        print_r($stmt->errorInfo());
        echo "</pre>";
    }

    // read all user records
   
    // used for paging users
    public function countAll(){

        // query to select all user records
        $query = "SELECT id FROM " . $this->table_name . "  WHERE status = TRUE ";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();

        // get number of rows
        $num = $stmt->rowCount();

        // return row count
        return $num;
    }

    

    function read_one($idd)
    {
        //select all data
        $query = "SELECT
                    *
                FROM
                    " . $this->table_name . "
                WHERE
				`id` = '$idd'
				";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        return $stmt;
    }

    function update($idd){

        // to get time stamp for 'created' field
        $this->created=date('Y-m-d H:i:s');

        // insert query
        $query = "UPDATE
                " . $this->table_name . "
            SET
                firstname = :firstname,
                lastname = :lastname,
                email = :email,
                contact_number = :contact_number,
                address = :address,
                procentat_za_platu = :procentat_za_platu,
                nacin_obracuna = :nacin_obracuna,
                color_prof = :color_prof,
                plata = :plata,
                iznos_plate = :iznos_plate,
                status = :status
             WHERE id = :idd   
               ";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->firstname=htmlspecialchars(strip_tags($this->firstname));
        $this->lastname=htmlspecialchars(strip_tags($this->lastname));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->contact_number=htmlspecialchars(strip_tags($this->contact_number));
        $this->address=htmlspecialchars(strip_tags($this->address));
        $this->status=htmlspecialchars(strip_tags($this->status));
        $this->color_prof=htmlspecialchars(strip_tags($this->color_prof));


        // bind the values
        $stmt->bindParam(':firstname', $this->firstname);
        $stmt->bindParam(':lastname', $this->lastname);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':contact_number', $this->contact_number);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':procentat_za_platu', $this->procentat_za_platu);
        $stmt->bindParam(':color_prof', $this->color_prof);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':plata', $this->plata);
        $stmt->bindParam(':iznos_plate', $this->iznos_plate);
        $stmt->bindParam(':nacin_obracuna', $this->nacin_obracuna);
        $stmt->bindParam(':idd', $idd);
        // hash the password before saving to database

        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }else{
            $this->showError($stmt);
            return false;
        }

    }

    function update_pass($idd){

        // insert query
        $query = "UPDATE
                " . $this->table_name . "
            SET
                password = :password
               
             WHERE id = :idd   
               ";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->password = htmlspecialchars(strip_tags($this->password));

        $password_hash = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password_hash);
        $stmt->bindParam(':idd', $idd);

        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }else{
            $this->showError($stmt);
            return false;
        }

    }

    public function search ($rec){
       $query=" SELECT
                    *
                FROM
                    " . $this->table_name . "
                WHERE
				`firstname` LIKE '%$rec%' or `lastname` LIKE '%$rec%' or `email` LIKE '%$rec%'
				
				";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        return $stmt;

    }

    public function insert_procenat( $fk_profesor , $procentat_za_platu )
    {

        // to get time stamp for 'created' field
        $this->generete_date=date('Y-m-d');
       // $this->end_date = null;
        $this->fk_profesor = $fk_profesor;

        // insert query
        $query = "
            INSERT INTO `vremenski_intervali_procenat_plata`
            SET
                fk_profesor = :fk_profesor,
                procenat_za_platu = :procenat_za_platu,
                generete_date = :generete_date
             /*   end_date = :end_date */
                ";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->fk_profesor=htmlspecialchars(strip_tags($this->fk_profesor));
        $this->procenat_za_platu=htmlspecialchars(strip_tags($this->procenat_za_platu));
        $this->generete_date=htmlspecialchars(strip_tags($this->generete_date));
     //   $this->end_date=htmlspecialchars(strip_tags($this->end_date));

        // bind the values
        $stmt->bindParam(':fk_profesor', $this->fk_profesor);
        $stmt->bindParam(':procenat_za_platu', $this->procenat_za_platu);
        $stmt->bindParam(':generete_date', $this->generete_date);
      //  $stmt->bindParam(':end_date', $this->end_date);

        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }else{
            $this->showError($stmt);
            return false;
        }

    }

    public function insert_nacin_obracuna( $fk_profesor , $nacin_obracuna )
    {

        // to get time stamp for 'created' field
        $this->generete_date=date('Y-m-d');
        // $this->end_date = null;
        $this->fk_profesor = $fk_profesor;

        // insert query
        $query = "
            INSERT INTO `vremenski_intervali_vrsta_obracuna`
            SET
                fk_profesor = :fk_profesor,
                nacin_obracuna = :nacin_obracuna,
                generete_date = :generete_date
             /*   end_date = :end_date */
                ";

        // prepare the query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->fk_profesor=htmlspecialchars(strip_tags($this->fk_profesor));
        $this->nacin_obracuna=htmlspecialchars(strip_tags($this->nacin_obracuna));
        $this->generete_date=htmlspecialchars(strip_tags($this->generete_date));
        //   $this->end_date=htmlspecialchars(strip_tags($this->end_date));

        // bind the values
        $stmt->bindParam(':fk_profesor', $this->fk_profesor);
        $stmt->bindParam(':nacin_obracuna', $this->nacin_obracuna);
        $stmt->bindParam(':generete_date', $this->generete_date);
        //  $stmt->bindParam(':end_date', $this->end_date);

        // execute the query, also check if query was successful
        if($stmt->execute()){
            return true;
        }else{
            $this->showError($stmt);
            return false;
        }

    }

    public function read_all_promene_procenat_jedan_profesor($id_prof,$table_name)
    {
        //select all data
        $query = "SELECT
                    *
                FROM
                    " . $table_name . "
                WHERE
				fk_profesor = '$id_prof'
				order by generete_date asc
				";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        return $stmt;
    }

    public function read_all_promene_nacin_obracuna_jedan_profesor($id_prof,$table_name)
    {
        //select all data
        $query = "SELECT
                    *
                FROM
                    " . $table_name . "
                WHERE
				fk_profesor = '$id_prof'
				order by generete_date asc
				";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        return $stmt;
    }



}