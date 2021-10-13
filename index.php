<?php

require_once '_connec.php';


$pdo = new \PDO(DSN, USER, PASS);

$query = 'SELECT * FROM friend';
$statement = $pdo->query($query);
$friends = $statement->fetchAll();

//header('Location: index.php');
//var_dump($friends);

$errors = [];

if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']); 

    if(empty($firstname)) {
        $errors[]= 'Le prénom est obligatoire';
    }   

    if(empty($lastname)) {
        $errors[]= 'Le nom est obligatoire';
    }

    $maxfirstLastNameLength= 45;
    if(strlen($firstname) > $maxfirstLastNameLength) {
        $errors[]= 'Le prénom doit faire moins de' . $maxfirstLastNameLength;
    }

    if(strlen($lastname) > $maxfirstLastNameLength) {
        $errors[]= 'Le nom doit faire moins de' . $maxfirstLastNameLength;
    }

    if (!empty($errors)) {
        var_dump($errors);
    }else{
        $query = "INSERT INTO friend (firstname, lastname) VALUES (:firstname , :lastname)";
        //on prepare la requête
        $statement = $pdo->prepare($query);

        //on injecte les valeurs "bindValue"
        $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);                                                                    
        

        // on exécute
        $statement->execute();
        header('Location: index.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDO Quete</title>
</head>
<body>
<ul>
<?php foreach ($friends as $friend): ?>
    <li><?= $friend['firstname'] . ' ' . $friend['lastname'] ?></li>
    <?php endforeach; ?>
</ul>


<form action="" method="POST">
    

        <label for="firstname">firstName :</label>
        <input required type="text" id="firstname" name="firstname">
    
        <label for="lastname">lastName :</label>
        <input required type="text" id="lastname" name="lastname">
    
        <button>Envoyer</button>
</form>

</body>
</html>



