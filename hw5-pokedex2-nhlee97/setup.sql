-- CSE 154 SECTION AA
-- CP5 11/28/18

-- This table holds values for a pokedex that stores the data for our Pokemon
-- game. It holds the pokemon name, the nickname the user wants to give the
-- pokemon(the name in all caps if a nickname isn't set. Retrieves the current
-- date and time and sets the datefound for the pokemon to be the current date
-- time that the user caught the pokemon. 
DROP TABLE IF EXISTS Pokedex;
CREATE TABLE Pokedex(
  name  VARCHAR(255) NOT NULL,
  nickname   VARCHAR(255),
  datefound  DATETIME,
  PRIMARY KEY (name)
);
