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
   
session_start();
$email = $_SESSION["email"];
$sql = "SELECT * FROM coursedemande WHERE email_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$data  = $stmt->get_result();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Les courses disponible</title>
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
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Les courses disponible</h1>
    <table>
        <tr>
            <th>course numero</th>
            <th>depart</th>
            <th>arrive</th>
            <th>prix</th>
            <th>distance</th>
            <th>date</th>
            <th>select</th>
        </tr>
        <?php foreach ($data as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id_coursedm']); ?></td>
                <td><?php echo htmlspecialchars($row['depart']); ?></td>
                <td><?php echo htmlspecialchars($row['arrivee']); ?></td>
                <td><?php echo htmlspecialchars($row['prix']); ?></td>
                <td><?php echo htmlspecialchars($row['distance']); ?></td>
                <td><?php echo htmlspecialchars($row['coursedate']); ?></td>
                <td><button type="button" onclick="afficherinformation(<?php echo htmlspecialchars($row['id_coursedm'])?>)">afficher</button></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <form style="display: none;" id="formm" action="afficheruser.php" method="post">
        <input name="numbercle" id="numbercle" type="text">
    </form>
    <script>
function afficherinformation(num){
    document.getElementById('numbercle').value=num;
    document.getElementById('formm').submit();}

    </script>
</body>
</html>
