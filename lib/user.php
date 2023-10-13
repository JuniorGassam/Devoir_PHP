<?php

function addUser(PDO $pdo, string $first_name, string $last_name, string $email, string $password, $role = "user")
{
    /*
        @todo faire la requête d'insertion d'utilisateur et retourner $query->execute();
        Attention faire une requête préparer et à binder les paramètres
    */

    $requete = $pdo->prepare("INSERT INTO `users` (`email`, `password`, `first_name`, `last_name`, `role`) VALUES(:email, :password, :first_name, :last_name, :role)");
    $requete->bindValue(":email", $email, PDO::PARAM_STR);
    $requete->bindValue(":password", password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
    $requete->bindValue(":first_name", $first_name, PDO::PARAM_STR);
    $requete->bindValue(":last_name", $last_name, PDO::PARAM_STR);
    $requete->bindValue(":role", $role, PDO::PARAM_STR);
    $requete->execute();

    if($requete){
        return true;
    }else{
        return false;
    }

}

function verifyUserLoginPassword(PDO $pdo, string $email, string $password)
{
    /*
        @todo faire une requête qui récupère l'utilisateur par email et stocker le résultat dans user
        Attention faire une requête préparer et à binder les paramètres
    */


    $requete = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $requete->bindValue(":email", $email, PDO::PARAM_STR);
    $requete->execute();

    $user = $requete->fetch();


    /*
        @todo Si on a un utilisateur et que le mot de passe correspond (voir fonction  native password_verify)
              alors on retourne $user
              sinon on retourne false
    */

    if($user){
        if(password_verify($password, $user['password'])){
            return $user;
        }else{
            return false;
        }
    }

}
