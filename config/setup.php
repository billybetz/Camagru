<?php
include "libft_php/sql_rqt.php";
//mysql server data
$servername = "localhost";
$user = "billy";
$passwd = "";

// connect to DATABASE
$con = new mysqli($servername, $user, $passwd);
//check if error
if ($con->connect_error)
{
  echo ("fail to connect to database" . mysqli_connect_error ());
}

//requete sql
$sql = "CREATE DATABASE if NOT EXISTS camagru";
ft_exe_sql_rqt("create db", $con, $sql);

$sql = "
	CREATE TABLE if NOT EXISTS `camagru`.`Users` (
    `id` INT NOT NULL AUTO_INCREMENT COMMENT 'numéro de l\'utilisateur' ,
    `pseudo` VARCHAR(64) NOT NULL COMMENT 'pseudo de l\'utilisateur' ,
    `email` VARCHAR(64) NOT NULL COMMENT 'email de l\'utilisateur' ,
    `passwd` VARCHAR(64) NOT NULL COMMENT 'mot de passe de l\'utilisateur' ,
    `is_active` BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'bool indiquant si le compte a ete activé ou non' ,
    `get_notif` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'bool indiquant si l\'utilisateur souhaite recevoir des notifications ou non' ,
    `rank` INT NOT NULL DEFAULT '0' COMMENT 'rang de l\'utilisateur (0 basic, 1 actif, 2 admin)' , PRIMARY KEY (`id`)) ENGINE = InnoDB;
		";
ft_exe_sql_rqt("create user table", $con, $sql);

$sql = "
	INSERT INTO 'Users' (pseudo, email, passwd, rank) 
	VALUES ('billy', 'test', 'root', 2);
	";
ft_exe_sql_rqt("insert billy", $con, $sql);
		

// create database
  //CREATE DATABASE if NOT EXISTS 'camagru';
  /*CREATE TABLE if NOT EXISTS `camagru`.`Users` (
    `id` INT NOT NULL AUTO_INCREMENT COMMENT 'numéro de l\'utilisateur' ,
    `pseudo` VARCHAR(64) NOT NULL COMMENT 'pseudo de l\'utilisateur' ,
    `email` VARCHAR(64) NOT NULL COMMENT 'email de l\'utilisateur' ,
    `passwd` VARCHAR(64) NOT NULL COMMENT 'mot de passe de l\'utilisateur' ,
    `is_active` BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'bool indiquant si le compte a ete activé ou non' ,
    `get_notif` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'bool indiquant si l\'utilisateur souhaite recevoir des notifications ou non' ,
    `rank` INT NOT NULL DEFAULT '0' COMMENT 'rang de l\'utilisateur (0 basic, 1 actif, 2 admin)' , PRIMARY KEY (`id`)) ENGINE = InnoDB;
  INSERT INTO 'Users' (pseudo, email, passwd, rank) VALUES ('billy', 'test', 'root', 2);
*/
  ?>
