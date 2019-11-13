<?php
/*  CSE 154 AA
 * Nathan Lee
 * 11/19/18
 * --------------------------------------
 * If sent a POST request, either parameter 'mode' or parameter 'name' is
 * required to be passed. name must be passed with pokemon name and optional
 * second parameter 'nickname'. Mode must be passed with mode removeall. if
 * nickname isn't passed, enters name in all caps as nickname. prints msg
 * if successful and error msg if not.
 */
include("common.php");
if(isset($_POST["name"])){
  remove($_POST["name"]);
}else if(isset($_POST["mode"])){
  if($_POST["mode"] === "removeall"){
    remove_all();
  }else{
    print_err("Error: Unknown mode {$_POST["mode"]}.");
  }
}else{
  print_err("Missing name or mode parameter.");
}

/**
 * Adds the pokemon to our datatable and prints an error if the pokemon is
 * already in our table. Prints success msg if add pokemon is successful.
 * @param string $pokmeon - The name of the pokemon to remove from our table
 * @return void
 */
function remove($pokemon){
  $name = strtolower($pokemon);
  if(have_pokemon($name)){
    $query = "DELETE FROM Pokedex WHERE name=:name";
    $params = array("name" => $name);
    prepare_execute($query, $params);
    print_array("Success! {$pokemon} removed from your Pokedex!");
  }else{
    print_err("Error: Pokemon {$pokemon} not found in your Pokedex.");
  }
}

/**
 * A function to remove all pokemon from our table in a query. Prints Output
 * msg if successful.
 * @return void
 */
function remove_all(){
  $qry = "DELETE FROM Pokedex";
  send_query($qry);
  print_array("Success! All Pokemon removed from your Pokedex!");
}
?>
