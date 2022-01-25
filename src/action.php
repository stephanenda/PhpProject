<?php

require_once("../bootstrap.php");
require_once("./classes/Opinion.php");

function saveOptionToDB($name, $email , $description, $rate){
    global $entityManager;
    $opinion = new Opinion();
    $opinion->setName($name);
    $opinion->setEmail($email);
    $opinion->setDescription($description);
    $opinion->setCreatedAt(new DateTime());
    $opinion->setRate($rate);
    // Persist pour préparer l'enregistrement ou la commande
    $entityManager->persist($opinion);
    // Flush pour executer la commande
    $entityManager->flush();
}
 