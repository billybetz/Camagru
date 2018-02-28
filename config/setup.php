<?php
require_once("libft_php/sql_rqt.php");
//mysql server data
$servername = "localhost";
$user = "billy";
$passwd = "";

// connect to DATABASE
$bdd = new mysqli($servername, $user, $passwd);
//check if error
if ($bdd->connect_error)
{
  echo ("fail to connect to database" . mysqli_connect_error ());
}

//requete sql
$sql = "CREATE DATABASE if NOT EXISTS camagru";
ft_exe_sql_rqt("create db", $bdd, $sql);

//creation de la table user
$sql = "
	CREATE TABLE if NOT EXISTS `camagru`.`Users` (
    `id` INT NOT NULL AUTO_INCREMENT COMMENT 'numéro de l\'utilisateur' ,
    `pseudo` VARCHAR(64) NOT NULL COMMENT 'pseudo de l\'utilisateur' ,
    `email` VARCHAR(64) NOT NULL COMMENT 'email de l\'utilisateur' ,
    `passwd` VARCHAR(64) NOT NULL COMMENT 'mot de passe de l\'utilisateur' ,
    `is_active` BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'bool indiquant si le compte a ete activé ou non' ,
    `get_notif` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'bool indiquant si l\'utilisateur souhaite recevoir des notifications ou non' ,
    `rank` INT NOT NULL DEFAULT '1' COMMENT 'rang de l\'utilisateur (1 basic, 2 actif, 3 admin)' , PRIMARY KEY (`id`)) ENGINE = InnoDB;
		";
ft_exe_sql_rqt("create user table", $bdd, $sql);

// création du user
//$sql = "
//	INSERT INTO camagru.Users (pseudo, email, passwd, rank) 
//	VALUES ('billy', 'test', 'root', 0);
//	";
//ft_exe_sql_rqt("insert billy", $con, $sql);

  ?>
