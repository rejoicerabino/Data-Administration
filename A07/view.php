<?php
include('connect.php');

$id = $_GET['id'];

if (isset($_POST['btnEditMember'])) {
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $bio = $_POST['bio'];
  $age = $_POST['age'];

  $bio = addslashes($_POST['bio']);
  $editQuery = "UPDATE userinfo SET firstName='$firstName', lastName='$lastName', bio='$bio', age='$age' WHERE userInfoID = '$id'";
  executeQuery($editQuery);

  header('Location: ./');
}

$query = "SELECT * FROM userinfo WHERE userInfoID = '$id'";
$result = executeQuery($query);
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Member Info</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

  <style>
   body {
      font-family: 'Poppins', sans-serif;
      background-color: #181C14;
    }

    .container {
      margin-top: 20px;
    }

    .bio-text {
      font-family: 'Roboto', sans-serif;
      font-style: italic;
    }

    .navbar {
      background: linear-gradient(to right, #3C3D37, #4A4947, #1E201E);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      padding: 10px;
    }

    .navbar-brand {
      color: #ffffff;
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

    .navbar2 {
      background: linear-gradient(to right, #CBDCEB, #608BC1, #536493);
      color: #333;
      padding: 10px;
      border-radius: 12px 12px 0 0;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 20px;
      width: 100%;
    }

    .col-12,
    .col-md-6,
    .col-lg-4 {
      margin-top: 20px;
      margin-bottom: 20px;
    }

    input::placeholder,
    textarea::placeholder {
      font-family: 'Lato', sans-serif;
    }

    .navbar2 .container-fluid {
      display: flex;
      align-items: center;
    }

    .member-form {
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      background-color: #2A3663;
    }

    .member-form .form-control {
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 10px;
      transition: border-color 0.3s, box-shadow 0.3s;
    }

    .member-form .form-control:focus {
      border-color: #B59F78;
      box-shadow: 0 0 8px rgba(181, 159, 120, 0.4);
      outline: none;
    }

    .member-form textarea.form-control {
      resize: vertical;
    }

    .member-form .btn-primary {
      border-radius: 6px;
      padding: 10px 20px;
      transition: transform 0.3s, background-color 0.3s;
    }

    .member-form .btn-primary:hover {
      transform: scale(1.03);
      background-color: #9E8A62;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-light">
    <div class="container-fluid">
      <div class="navbar-brand">
        <img src="images/zsp.jpg" alt="ZSP Logo" class="navbar-img">
        ZSP Members
      </div>
    </div>
  </nav>

  <div class="container"> 
    <div class="row mt-5 mb-5">
      <div class="col">
        <?php
        if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
        ?>

        <form method="post" class="member-form">
          <nav class="navbar2">
            <div class="container-fluid">
              <span class="navbar-text" style="font-weight: bold">Edit Members' Info</span>
            </div>
          </nav>
          <div class="row">
            <div class="col-12 col-md-6 mb-3">
              <input type="text" class="form-control" id="firstName" name="firstName" required placeholder="First Name"
                value="<?php echo htmlspecialchars($row['firstName']); ?>">
            </div>
            <div class="col-12 col-md-6 mb-3">
              <input type="text" class="form-control" id="lastName" name="lastName" required placeholder="Last Name"
                value="<?php echo htmlspecialchars($row['lastName']); ?>">
            </div>
            <div class="col-12 mb-3">
              <textarea class="form-control" id="bio" name="bio" rows="3" required placeholder="Bio"><?php echo htmlspecialchars($row['bio']); ?></textarea>
            </div>
            <div class="col-12 col-md-6 mb-3">
              <input type="number" class="form-control" id="age" name="age" required placeholder="Age"
                value="<?php echo htmlspecialchars($row['age']); ?>">
            </div>
            <div class="col-12 mb-3">
              <button type="submit" name="btnEditMember" class="btn btn-primary w-40"
                style="background-color: #608BC1; color: white; border: none; cursor: pointer; transition: background-color 0.3s ease;"
                onmouseover="this.style.backgroundColor='#536493'" onmouseout="this.style.backgroundColor='#608BC1'">
                Save
              </button>
            </div>
          </div>
        </form>

        <?php
          }
        }
        ?>
      </div>
    </div>
  </div> 

  <footer class="container-fluid py-3" style="background-color: #181C14;">
    <ul class="nav justify-content-center"
      style="border-bottom: 2px solid #F6F5F2; padding-bottom: 3px; margin-bottom: 3px; width: calc(100% - 80px); margin-left: 40px; margin-right: 40px;">
      <li class="nav-item">
        <span class="nav-link px-2" style="color: #F6F5F2;">©rejoicerabino</span>
      </li>
    </ul>
    <p class="text-center" style="color: #F6F5F2;">Polytechnic University of the Philippines</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
