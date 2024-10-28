<?php
include 'connect.php';

$sql = "SELECT firstName, lastName, age, bio FROM userinfo";
$result = executeQuery($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZSP - User Information</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #FCFAEE; 
        }

        .container {
            margin-top: 50px; 
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .card {
            transition: transform 0.2s; 
            display: flex;
            flex-direction: column; 
            height: 100%; 
            background-color: #D8D2C2; 
        }

        .card:hover {
            transform: scale(1.05); 
        }

        .card-body {
            flex: 1; 
            display: flex;
            flex-direction: column; 
            justify-content: center; 
            color: #333; 
            font-family: 'Lato', sans-serif;
        }

        .bio-text {
            font-family: 'Roboto', sans-serif; 
            font-style: italic; 
        }

        .navbar {
            background-color: #E9DAC4; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
            padding: 5px; 
        }

        .navbar-brand {
            color: #171515; 
            font-size: 1.5rem; 
            font-family: 'Poppins', sans-serif; 
            font-weight: bold;
            display: flex; 
            align-items: center; 
        }

        .navbar-img {
            width: 50px; 
            height: 50px; 
            border-radius: 50%; 
            object-fit: cover; 
            margin-right: 10px;
            margin-left: 20px;
        }

        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1.2rem; 
            }
        }
    </style>
</head>
<body>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <div class="navbar-brand">
                <img src="images/zsp.jpg" alt="ZSP Logo" class="navbar-img"> 
                ZSP Members
            </div>
        </div>
    </nav>


    <div class="container">
        <div class="row">
            <?php
            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">' . htmlspecialchars($row['firstName']) . ' ' . htmlspecialchars($row['lastName']) . '</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">' . htmlspecialchars($row['age']) . ' years old</h6>
                                    <p class="bio-text">' . htmlspecialchars($row['bio']) . '</p> 
                                </div>
                            </div>
                        </div>';
                }
            }
            ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
