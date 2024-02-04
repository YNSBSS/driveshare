<!DOCTYPE html>
<html>
<head>
    <title>User Data</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="style.css">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src='https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js'></script>
  <link href='https://api.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css' rel='stylesheet' />
  <link rel="stylesheet" href="accueilcompteuser.css">

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
<main>
  <div style="background-color: black;" class="sidebar">
      <div class="logo-details">
      <div class="logo_name"> <img src="driversharegreen.png" style = " height: 40px; width: 40px;"> Drivershare</div>
          <i class='bx bx-menu' id="btn" ></i>
      </div>
      <ul class="nav-list">
        <li>
            <i class='bx bx-search' ></i>
           <input type="text" placeholder="Rechercher...">
        </li>
        <li>
          <a href="demandertrajet.html">
            <i class='bx bx-home' ></i>
            <span class="links_name"> Acceuil</span>
          </a>
        </li>
        <li>
         <a href="profiluser.html">
           <i class='bx bx-user' ></i>
           <span class="links_name"> Profil</span>
         </a>
       </li>
       <li>
        <a href="mestrajets.html">
          <i class='bx bx-list-plus' ></i>
          <span class="links_name"> Mes trajets</span>
        </a>
       </li>
       <li>
        <a href='authentification.html'>
          <i class='bx bxs-dock-left'></i>
          <span class="links_name" name="deconnexion" id="deconnexion">Déconnexion</span></a>
       </li>
      </ul>
  </div>
<section class="home-section">

<?php
$host = "localhost";
$db_name = "mabase";
$username = "root";
$password = "";
$table_name = "course";

// Connexion à la base de données avec mysqli
$conn = new mysqli($host, $username, $password, $db_name);

// Vérifier la connexion
if ($conn->connect_error)
 {
    die("Erreur de connexion à la base de données: " . $conn->connect_error);
 }
   
session_start();
$email = $_SESSION["email"];
$sql = "SELECT * FROM course WHERE email_user = '$email'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$data  = $stmt->get_result();

?>

    <h1>Vos courses</h1>
    <table>
        <tr>
            <th>course numero</th>
            <th>depart</th>
            <th>arrive</th>
            <th>prix</th>
            <th>distance</th>
            <th>date</th>
            
        </tr>
        <?php foreach ($data as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id_course']); ?></td>
                <td><?php echo htmlspecialchars($row['depart']); ?></td>
                <td><?php echo htmlspecialchars($row['arrivee']); ?></td>
                <td><?php echo htmlspecialchars($row['prix']); ?></td>
                <td><?php echo htmlspecialchars($row['distance']); ?></td>
                <td><?php echo htmlspecialchars($row['coursedate']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>
  

</main>

    <script src="compteuser.js"></script>
</body>
</html>
