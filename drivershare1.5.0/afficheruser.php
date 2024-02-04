<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User informations</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="accueilcompteuser.css">
  <script src='https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js'></script>
  <link href='https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css' rel='stylesheet' />
  <style>
  body{
    background-color:green ;
  }
  button{
    background-color:wheat;
    color: green;
  }
  div{
    display: inline-block;
  justify-content: center; 
  align-items: center;
  align-content: center;
  }
  </style>
</head>
<body>
<form id='formm'style="display:none" action="miseajourcourse.php" method="post">
<input name ="usermail" id="usermail" type="text">
</form>

<section classe="home-section">
    <?php
     $host = "localhost";
     $db_name = "mabase";
     $username = "root";
     $password = "";
     $table_name = "coursedemande";
 
     // Connexion à la base de données avec mysqli
     $conn = new mysqli($host, $username, $password, $db_name);
 
     // Vérifier la connexion
     if ($conn->connect_error)
      {
         die("Erreur de connexion à la base de données: " . $conn->connect_error);
      }
        
     // Vérification si le formulaire est soumis
     if ($_SERVER["REQUEST_METHOD"] == "POST") {
         // Récupération des donnée
          $num = $_POST["numbercle"];
         // Do something with the data
        

         $sql = "SELECT * FROM coursedemande WHERE id_coursedm = '$num'";
         $result = $conn->query($sql);
        $row = $result->fetch_assoc();
$email=$row['email_user'];
$sql2 = "SELECT numero_telephone FROM users WHERE email_user = '$email'";
$result2 = $conn->query($sql2);
$row2 = $result2->fetch_assoc();
//$numero = $row2['numero_telephone'];

        echo "<h2>Voici les donnee de l'utilisateur</h2>";
        echo "<p>ID: " . htmlspecialchars($row['id_coursedm']) . "</p>";
        echo "<p>depart: " . htmlspecialchars($row['depart']) . "</p>";
        echo "<p>arrive: " . htmlspecialchars($row['arrivee']) . "</p>";
        echo "<p>distance: " . htmlspecialchars($row['distance']) . "</p>";
        echo "<p>prix: " . htmlspecialchars($row['prix']) . "</p>";
        echo "<p>duree: " . htmlspecialchars($row['duree']) . "</p>";
        echo "<p>telephone: 0668440023</p>";
        echo"<br>";
        echo "<input style='display:none' type='text' id='inputt' value='" . htmlspecialchars($email) . "'>";
        
        
     
        } else {
         echo "No data received";
     }


    ?>
    <div class="groupe">
<button onclick='doit()'>confirmer</button>
<button onclick='window.history.back();'>retour</button>
</div>
<script>
function doit(){
    document.getElementById('usermail').value=document.getElementById('inputt').value;
    console.log(document.getElementById('usermail').value);
    document.getElementById('formm').submit();
}

    </script>
    <script src="compteuser.js"></script>
    </section>
</body>
</html>