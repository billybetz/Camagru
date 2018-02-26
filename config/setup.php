<?php
echo "test de commande php\n";
// connect to DATABASE
$connexion = mysqli_connect("localhost:8080", "root,", "rootroot");
if (!$connexion)
{
  echo ("fail to connect to database" . mysql_error());
}



// create database
  CREATE DATABASE if NOT EXISTS 'camagru'
  CREATE TABLE if NOT EXISTS `camagru`.`Users` (
    `id` INT NOT NULL AUTO_INCREMENT COMMENT 'numéro de l\'utilisateur' ,
    `pseudo` VARCHAR(64) NOT NULL COMMENT 'pseudo de l\'utilisateur' ,
    `email` VARCHAR(64) NOT NULL COMMENT 'email de l\'utilisateur' ,
    `passwd` VARCHAR(64) NOT NULL COMMENT 'mot de passe de l\'utilisateur' ,
    `is_active` BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'bool indiquant si le compte a ete activé ou non' ,
    `get_notif` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'bool indiquant si l\'utilisateur souhaite recevoir des notifications ou non' ,
    `rank` INT NOT NULL DEFAULT '0' COMMENT 'rang de l\'utilisateur (0 basic, 1 actif, 2 admin)' , PRIMARY KEY (`id`)) ENGINE = InnoDB;
  INSERT INTO 'Users' (pseudo, email, passwd, rank) VALUES ('billy', 'test', 'root', 2);
?>
