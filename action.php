<?php
$user = "root";
$password = "";

$connexion = new PDO("mysql:host=localhost;dbname=gestionproduit", $user, $password);

$receive_data = json_decode(file_get_contents("php://input"));

$data = array();

if($receive_data->action == 'fetchall')
{
    $requete = $connexion->query("SELECT * FROM produit ORDER BY numProduit ASC");

    while($row = $requete->fetch(PDO::FETCH_ASSOC)){
        $data[] = $row;
    }

    echo json_encode($data);
}

if($receive_data->action == 'fetch'){
    $id = $receive_data->id;
    $requete = $connexion->query("SELECT * FROM produit WHERE numProduit = '$id' ");
    $data[] = $requete->fetch(PDO::FETCH_ASSOC);
    echo json_encode($data);
}

if($receive_data->action == 'fetchElse'){
    $requete = $connexion->query("SELECT MIN(prix*qte) as minimum, MAX(prix*qte) as maximum, SUM(prix*qte) as somme FROM produit");
    $data[] = $requete->fetch(PDO::FETCH_ASSOC);
    echo json_encode($data);
}

if($receive_data->action == 'insert'){
    $data = array(
        ':numeroProduit' => $receive_data->numeroProduit,
        ':design' => $receive_data->design,
        ':prix' => $receive_data->prix,
        ':quantite' => $receive_data->quantite
    );

    $requete = $connexion->prepare("INSERT INTO produit(numProduit, design, prix, qte) VALUES (:numeroProduit, :design, :prix, :quantite)");
    $resultat = $requete->execute($data);

    if($resultat)
    {
        $sortie = array(
            'message' => 'Opération éffectuer avec succés !'
        );
    
        echo json_encode($sortie);
    
    }else{
        $sortie = array(
            'message' => 'Opération non éffectuer !'
        );
    
        echo json_encode($sortie);
    
    }

    }
    if($receive_data->action == 'update'){

        $id = $receive_data->id;
        $numeroProduit = $receive_data->numeroProduit;
        $design = $receive_data->design;
        $prix = $receive_data->prix;
        $quantite = $receive_data->quantite;
        $requete = $connexion->prepare("UPDATE produit SET numProduit= :numeroProduit, design = :design, prix = :prix, qte = :quantite WHERE numProduit= '$id'");

        $requete->bindParam(":numeroProduit", $numeroProduit);
        $requete->bindParam(":design", $design);
        $requete->bindParam(":prix", $prix);
        $requete->bindParam(":quantite", $quantite);

        $resultat = $requete->execute();
        if($resultat){
            $sortie = array(
                'message' => "Modification éffectuer !"
            );
            echo json_encode($sortie);

        }else{
            $sortie = array(
                'message' => "Modification non éffectuer !"
            );
            echo json_encode($sortie);
        }
    }

    if($receive_data->action == 'delete'){
        $id = $receive_data->id;
        $requete = $connexion->prepare("DELETE FROM produit WHERE numProduit = '$id'");
        $resultat = $requete->execute();

        if($resultat)
        {
            $sortie = array(
                'message' => 'Suppression éffectuer !'
            );

            echo json_encode($sortie);
        }
    }

?>