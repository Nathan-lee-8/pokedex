<?php
  /*
   * Week 9 Section: PHP and SQL
   * Configuration/common file for the Bricker and Morter Store API
   */

  # These two statements are needed to properly set strict error-reporting on MAMP servers
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  /**
   * Returns a PDO object connected to the bmstore database. Throws
   * a PDOException if an error occurs when connecting to database.
   * @return {PDO}
   */
  function get_PDO() {
    $host =  "localhost";
    $port = "8889";
    $user = "root";
    $password = "root";
    $dbname = "hw5";
    $ds = "mysql:host={$host}:{$port};dbname={$dbname};charset=utf8";
    try {
      $db = new PDO($ds, $user, $password);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $db;
    } catch (PDOException $ex) {
      handle_error(array("error" => "A database error occurred." .
                         "Please try again another time."));
    }
  }

  /**
   * Returns the ouput that the given sql query would return in sql.
   * @param string query to send to database connection.
   * @return PDOStatement|boolean
   */
  function send_query($qry){
    $db = get_PDO();
    $result = $db->query($qry);
    return $result;
  }

  /**
   * A helper function for other php files to prepare and execute a query with
   * a database connection. Returns boolean for if the result executed or not.
   * Catches PDOException if execute fails to load.
   * @param string $qry to prepare and execute with db connection
   * @param array $param to set param for the db connection
   * @return PDOException|boolean
   */
  function prepare_execute($qry, $param){
    $db = get_PDO();
    $result = $db->prepare($qry);
    try{
      $result->execute($param);
      return $result;
    }catch(PDOException $ex){
      return FALSE;
    }
  }

  /**
   * Helper function to check if database table has the pokemon name in the
   * table. Returns true if pokemon is in our table and returns false if
   * pokemon isn't in the datatable.
   * @param $name the pokemon that we want to look for in our table.
   * @return boolean
   */
  function have_pokemon($name){
    $success = FALSE;
    $qry = "SELECT name FROM Pokedex WHERE name='{$name}'";
    $result = send_query($qry);
    foreach ($result as $row){
      if($row["name"] === $name){
        $success = TRUE;
      }
    }
    return $success;
  }

  /**
   * Helper function to add values to our datatable. Returns boolean based on
   * if the prepare and execute helper functions execute.
   * @param string $name - the given name of the pokemon
   * @param string $nickname - the nickname that the user wants to give the
   * pokemon. the pokemon name in all caps if the nickname isn't passed.
   * @return boolean
   */
  function added_pokemon($name, $nickname){
    $query = 'INSERT INTO Pokedex (name, nickname, datefound)
            VALUES (:name, :nickname, :datefound);';
    date_default_timezone_set('America/Los_Angeles');
    $datefound = date('y-m-d H:i:s');
    $param = array("name" => $name, "nickname" => $nickname,
                    "datefound" => $datefound);
    return prepare_execute($query, $param);
  }

  /**
   * Prints out an application/json message of the given $msg. If given a
   * @param $msg {array} - application/json message to output
   * @return void
   */
  function print_msg($msg) {
    header("Content-type: application/json");
    echo json_encode($msg);
  }

  function print_array($msg){
    print_msg(array("success" => $msg));
  }


  /**
 * Prints out a plain text 400 error message given $msg. If given a second
 * (optional) argument as an PDOException, prints details about the cause of
 * the exception.
 * @param $msg {array} - Plain text 400 message to output
 * @param $ex {PDOException} - (optional) Exception object with additional
 * exception details to print
 */
  function print_err($msg, $ex=NULL){
    $error = array("error" => $msg);
    header("HTTP/1.1 400 Invalid Request");
    header("Content-type: application/json");
    echo json_encode($error);
    if ($ex) {
      echo ("Error details: $ex \n");
      die();
    }
  }

?>
