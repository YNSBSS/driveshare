<!DOCTYPE html>
<html>
<head>
    <title>User Data</title>
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
</body>
</html>
