<?php
require_once("libft_php/sql_rqt.php");
require_once("config/database.php");
//mysql server data
$servername = $DB_SERVERNAME;
$user = $DB_USER;
$passwd = $DB_PASSWORD;

// connect to DATABASE
$bdd = new mysqli($servername, $user, $passwd);
//check if error
if ($bdd->connect_error)
{
  echo ("fail to connect to database" . mysqli_connect_error ());
}


// creation de la base de donnée nomée camagru

$sql = "CREATE DATABASE if NOT EXISTS camagru";
ft_exe_sql_rqt("create db", $bdd, $sql);


//creation de la table user

$sql = "
	CREATE TABLE if NOT EXISTS `camagru`.`Users` 
  (
    `id` INT NOT NULL AUTO_INCREMENT COMMENT 'numéro de l\'utilisateur' ,
    `pseudo` VARCHAR(64) NOT NULL COMMENT 'pseudo de l\'utilisateur' ,
    `email` VARCHAR(64) NOT NULL COMMENT 'email de l\'utilisateur' ,
    `passwd` VARCHAR(1024) NOT NULL COMMENT 'mot de passe de l\'utilisateur' ,
    `is_active` BOOLEAN NOT NULL DEFAULT FALSE COMMENT 'bool indiquant si le compte a ete activé ou non' ,
    `get_notif` BOOLEAN NOT NULL DEFAULT TRUE COMMENT 'bool indiquant si l\'utilisateur souhaite recevoir des notifications ou non' ,
    `rank` INT NOT NULL DEFAULT '1' COMMENT 'rang de l\'utilisateur (1 basic, 2 actif, 3 admin)' , PRIMARY KEY (`id`)
  ) ENGINE = InnoDB;
		";
ft_exe_sql_rqt("create users table", $bdd, $sql);


// creation de la table des photos clients

$sql = "
  CREATE TABLE if NOT EXISTS `camagru`.`pictures` 
  ( `id` INT NOT NULL AUTO_INCREMENT COMMENT 'id de la photo' , `user_id` INT NOT NULL COMMENT 'utilsateur a qui appartient la photo' , `name` VARCHAR(1024) NOT NULL COMMENT 'nom de la photo permettant de retrouver son emplacement' , `timestamp` BIGINT(20) NOT NULL COMMENT 'date de publication de la photo (precision ms)' , PRIMARY KEY (`id`)
  ) ENGINE = InnoDB;
  ";
ft_exe_sql_rqt("create photos table", $bdd, $sql);


// creation de la table des commentaires

$sql = "
CREATE TABLE `camagru`.`comments` 
( `id` INT NOT NULL AUTO_INCREMENT , `user_id` INT NOT NULL COMMENT 'id de l\'utilsateur qui a posté le commentaire' , `photo_id` INT NOT NULL COMMENT 'id de la photo sur laquelle le commentaire est posté' , `comment` TEXT NOT NULL COMMENT 'commentaire de l\'utilisateur' , `timestamp` BIGINT(20) NOT NULL COMMENT 'heure à l\'aquelle le commentaire a été posté (precision ms)' , PRIMARY KEY (`id`)
) ENGINE = InnoDB;
";
ft_exe_sql_rqt("create comments table", $bdd, $sql);


// creation de la table des Likes

$sql = "
CREATE TABLE `camagru`.`likes` 
( `id` INT NOT NULL AUTO_INCREMENT , `user_id` INT NOT NULL COMMENT 'id de l\'utilisateur qui a aimé le dommentaire ou la photo' , `photo_id` INT NULL DEFAULT NULL COMMENT 'photo a laquelle fait référence le like si c\'est une photo qui est like' , `comment_id` INT NULL DEFAULT NULL COMMENT 'commentaire auquel fait référence le like si c\'est un commentaire qui est like' , PRIMARY KEY (`id`)
) ENGINE = InnoDB;
";
ft_exe_sql_rqt("create likes table", $bdd, $sql);


// creation de la table des filtres

$sql = "
CREATE TABLE `camagru`.`filters` ( `id` INT(11) NOT NULL AUTO_INCREMENT , `name` VARCHAR(128) NOT NULL COMMENT 'nom de la photo permettant de retrouver son emplacement' , PRIMARY KEY (`id`)) ENGINE = InnoDB;
";
ft_exe_sql_rqt("create likes table", $bdd, $sql);


// création du user
$sql = "
	INSERT INTO camagru.Users (pseudo, email, rank) 
	VALUES ('root', 'test', 2);
	";
ft_exe_sql_rqt("insert billy", $bdd, $sql);

  ?>
