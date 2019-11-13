<?php
/*  CSE 154 AA
 * Nathan Lee
 * 11/19/18
 * if sent POST request, takes name and nickname parameter are changed and if
 * nickname isn't passed, sets nickname to the name in upper case and passes if
 * to fuction to update the nickname of the pokemon to be the nickname. Prints
 * msg if successful and error message if pokemon isn't in the datatable.
 */
include("common.php");
if(isset($_POST["name"])){
  $name = $_POST["name"];
  if(isset($_POST["nickname"])){
    update_pokemon($name, $_POST["nickname"]);
  }else{
    $nickname = strtoupper($name);
    update_pokemon($name, $nickname);
  }
}else{
  print_err("Missing name parameter.");
}

/**
 * finds the pokemon that has the same name as the given name and updates its
 * nickname to be the given nickname. If nickname isn't passed, the nickname
 * is the uppercase of the name. Prints error if the pokemon isn't in your
 * pokedex and prints success if the pokemon is successfully removed.
 * @param string $name is the name of the pokemon we want to remove.
 * @param string $nickname is the nickname that the user wants to pass.
 * nickname is name in upper case if nickname isn't passed.
 * @return void
 */
function update_pokemon($name, $nickname){
  $pokemon = strtolower($name);
  $qry = "UPDATE Pokedex SET name=:name, nickname=:nickname
          WHERE name='{$name}'";
  $data = ['name' => $pokemon, 'nickname' => $nickname];
  prepare_execute($qry, $data);
  $success = have_pokemon($pokemon);
  if($success){
    print_array("Success! Your {$name} is now named {$nickname}!");
  }else{
    print_err("Error: Pokemon {$name} not found in your Pokedex.");
  }
}
?>
