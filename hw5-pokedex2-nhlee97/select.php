<?php
/*  CSE 154 AA
 * Nathan Lee
 * 11/19/18
 * Select.php sends a query to the database connection and creates an array
 * to store our name, nickname, datefound for every instance of pokemon we
 * have and echos the array in json format.
 */
include("common.php");
$sql = 'SELECT name, nickname, datefound FROM Pokedex';
$result = send_query($sql);
$pokemon["pokemon"] = [];
foreach ($result as $row){
  array_push($pokemon["pokemon"], array("name" => $row["name"],
    "nickname" => $row["nickname"], "datefound" => $row["datefound"]));
}
print_msg($pokemon);
?>
