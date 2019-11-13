<?php
/*  CSE 154 AA
 * Nathan Lee
 * 11/19/18
 * --------------------------------------
 * If sent a POST request, both parameters mypokemon and theirpokemon must be
 * passed with the respective pokemon name. If passed without both variables
 * will print 400 error msg.
 */
include("common.php");
if(isset($_POST["mypokemon"]) && isset($_POST["theirpokemon"])){
  trade($_POST["mypokemon"], $_POST["theirpokemon"]);
}else if(isset($_POST["mypokemon"]) || isset($_POST["theirpokemon"])){
  print_err("Missing mypokemon or theirpokemon parameter.");
}else{
  print_err("Missing mypokemon and theirpokemon parameter.");
}

/**
 * attemps to trade mypokemon with theirpokemon. prints error if you already
 * have $theirpokemon or if $yourpokemon is not in your pokedex, prints 400
 * error parsed in json format.
 * @param string $mypokemon - the pokemon that we want to trade
 * @param string $theirpokemon - pokemon we want to recieve.
 * @return void
 */
function trade($mypokemon, $theirpokemon){
  $mypokemonlower = strtolower($mypokemon);
  $theirpokemonlower = strtolower($theirpokemon);
  if(!have_pokemon($mypokemonlower)){
    print_err("Error: Pokemon $mypokemon not found in your Pokedex.");
  }else if(have_pokemon($theirpokemonlower)){
    print_err("Error: You have already found $theirpokemon.");
  }else{
    $query = "DELETE FROM Pokedex WHERE name=:name";
    $params = array("name" => $mypokemonlower);
    prepare_execute($query, $params);
    added_pokemon($theirpokemonlower, strtoupper($theirpokemon));
    print_array("Success! You have traded your {$mypokemon} for " .
                "{$theirpokemon}!");
  }
}
?>
