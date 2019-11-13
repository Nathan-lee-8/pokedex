<?php
/*  CSE 154 AA
 * Nathan Lee
 * 11/19/18
 * --------------------------------------
 * If sent a POST request, parameter 'name' is required to be passed with
 * pokemon name and optional second parameter 'nickname'. if nickname isn't
 * passed, enters name in all caps as nickname. prints msg if successful and
 * prints error msg if not.
 */
include("common.php");
if(isset($_POST["name"])){
  $name = $_POST["name"];
  $nickname;
  if(isset($_POST["nickname"])){
    $nickname = $_POST["nickname"];
  }else{
    $nickname = strtoupper($name);
  }
  add_pokemon($name, $nickname);
}else{
  print_err("Missing name parameter.");
}

/**
 * Adds the pokemon to our datatable and prints an error if the pokemon is
 * already in our table. Prints success msg if add pokemon is successful.
 * @param string $name - The name to add to our pokemon
 * @param string $nickname - the nickname to give our pokemon. Inserts name in
 * all caps if the nickname isn't passed.
 * @return void
 */
function add_pokemon($name, $nickname){
  $pokemon = strtolower($name);
  if(!have_pokemon($pokemon)){
    added_pokemon($pokemon, $nickname);
    print_array("Success! {$name} added to your Pokedex!");
  }else{
    print_err("Error: Pokemon {$name} already found.");
  }
}
?>
