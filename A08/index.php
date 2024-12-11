<?php
include("connect.php");

$aircraftTypeFilter = $_GET['aircraftType'] ?? '';
$airlineNameFilter = $_GET['airlineName'] ?? '';
$sort = $_GET['sort'] ?? '';
$order = $_GET['order'] ?? '';

$flightlogsQuery = "SELECT * FROM flightlogs";

if ($aircraftTypeFilter || $airlineNameFilter) {
    $flightlogsQuery .= " WHERE";

    if ($aircraftTypeFilter) {
        $flightlogsQuery .= " aircraftType='$aircraftTypeFilter'";
    }

    if ($aircraftTypeFilter && $airlineNameFilter) {
        $flightlogsQuery .= " AND";
    }

    if ($airlineNameFilter) {
        $flightlogsQuery .= " airlineName='$airlineNameFilter'";
    }
}

if ($sort != '') {
    $flightlogsQuery .= " ORDER BY $sort";

    if ($order != '') {
        $flightlogsQuery .= " $order";
    }
}

$flightlogsResults = executeQuery($flightlogsQuery);

$aircraftTypeQuery = "SELECT DISTINCT(aircraftType) FROM flightlogs";
$aircraftTypeResults = executeQuery($aircraftTypeQuery);

$airlineNameQuery = "SELECT DISTINCT(airlineName) FROM flightlogs";
$airlineNameResults = executeQuery($airlineNameQuery);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PUP Airport</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #394867;
            color: #0B111D;
            overflow-x: hidden;
        }

        .navbar {
            background-color: #212A3E;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 5px;
            display: flex;
            overflow: hidden;
        }

        .navbar-brand {
            color: whitesmoke;
            font-size: 1.3rem;
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
            display: flex;
            align-items: center;
        }

        .navbar-img {
            max-width: 60px;
            height: auto;
            border-radius: 100%;
            margin-left: 20px;
            margin-right: 10px;
        }

        .navbar:hover .navbar-brand {
            color: white !important;
        }

        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1.2rem;
            }
        }

        label {
            color: whitesmoke
        }

        .card,
        option {
            background-color: #758694;
        }

        .card {
            background-color: #161A30;
            overflow: hidden
        }

        .card table,
        .card table tr,
        .card table th,
        .card table td {
            background-color: #161A30;
            color: whitesmoke;
            overflow: hidden;
        }

        .btn {
            background-color: #7FA1C3;
            border-radius: 50px;
        }

        .btn:hover {
            background-color: #6482AD;
            border-radius: 50px;
        }

        .fa-filter, 
        .fa-sort {
            color: #80C4E9;
            font-size: 1.5rem;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-brand">
                <img src="img/pupair.png" alt="Logo" class="navbar-img">
                PUP AIRPORT FLIGHT LOGS
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row m-2 my-5">
            <div class="col">
                <form method="GET">
                    <div class="card p-3 rounded-4">
                        <div class="row p-5">
                            <!-- Filter -->
                            <div class="d-flex flex-wrap align-items-center mb-4">
                                <i class="fa-solid fa-filter me-2"></i>
                                <div class="d-flex align-items-center me-3">
                                    <label for="aircraftTypeSelect" class="me-2">Aircraft Type</label>
                                    <select id="aircraftTypeSelect" name="aircraftType" class="form-control" style="width: fit-content">
                                        <option value="">Any</option>
                                        <?php
                                        if (mysqli_num_rows($aircraftTypeResults) > 0) {
                                            while ($aircraftTypeRow = mysqli_fetch_assoc($aircraftTypeResults)) {
                                        ?>
                                                <option <?php if ($aircraftTypeFilter == $aircraftTypeRow['aircraftType']) {
                                                            echo "selected";
                                                        } ?> value="<?php echo $aircraftTypeRow['aircraftType'] ?>">
                                                    <?php echo $aircraftTypeRow['aircraftType'] ?>
                                                </option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="d-flex align-items-center me-3">
                                    <label for="airlineSelect" class="me-2">Airline Name</label>
                                    <select id="airlineSelect" name="airlineName" class="form-control" style="width: fit-content">
                                        <option value="">Any</option>
                                        <?php
                                        if (mysqli_num_rows($airlineNameResults) > 0) {
                                            while ($airlineNameRow = mysqli_fetch_assoc($airlineNameResults)) {
                                        ?>
                                                <option <?php if ($airlineNameFilter == $airlineNameRow['airlineName']) {
                                                            echo "selected";
                                                        } ?> value="<?php echo $airlineNameRow['airlineName'] ?>">
                                                    <?php echo $airlineNameRow['airlineName'] ?>
                                                </option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- Sort -->
                            <div class="d-flex flex-wrap align-items-center">
                                <i class="fa-solid fa-sort me-2"></i>
                                <div class="d-flex align-items-center me-3">
                                    <label for="sort" class="me-2">Sort By</label>
                                    <select id="sort" name="sort" class="form-control" style="width: fit-content">
                                        <option value="">None</option>
                                        <option <?php if ($sort == "passengerCount") {
                                                    echo "selected";
                                                } ?> value="passengerCount">Passenger Count</option>
                                        <option <?php if ($sort == "departureAirportCode") {
                                                    echo "selected";
                                                } ?> value="departureAirportCode">Departure Airport Code</option>
                                        <option <?php if ($sort == "arrivalAirportCode") {
                                                    echo "selected";
                                                } ?> value="arrivalAirportCode">Arrival Airport Code</option>
                                        <option <?php if ($sort == "flightNumber") {
                                                    echo "selected";
                                                } ?> value="flightNumber">Flight Number</option>
                                        <option <?php if ($sort == "pilotName") {
                                                    echo "selected";
                                                } ?> value="pilotName">Pilot Name</option>
                                    </select>
                                </div>
                                <div class="d-flex align-items-center me-3">
                                    <label for="order" class="me-2">Order</label>
                                    <select id="order" name="order" class="form-control" style="width: fit-content">
                                        <option <?php if ($order == "ASC") {
                                                    echo "selected";
                                                } ?> value="ASC">Ascending</option>
                                        <option <?php if ($order == "DESC") {
                                                    echo "selected";
                                                } ?> value="DESC">Descending</option>
                                    </select>
                                </div>
                            </div>

                            <div class="w-100 d-flex justify-content-center align-items-center mt-4">
                                <button class="btn" type="submit" style="width: fit-content">Go</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>    
    <!-- Table -->
    <div class="row m-2">
        <div class="col">
            <div class="card p-5 rounded-4">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Flight Number</th>
                                <th scope="col">Airline Name</th>
                                <th scope="col">Departure Airport Code</th>
                                <th scope="col">Arrival Airport Code</th>
                                <th scope="col">Aircraft Type</th>
                                <th scope="col">Pilot Name</th>
                                <th scope="col">Passenger Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($flightlogsResults) > 0) {
                                while ($flightlogsRow = mysqli_fetch_assoc($flightlogsResults)) {
                            ?>
                                    <tr>
                                        <td><?php echo $flightlogsRow['flightNumber'] ?></td>
                                        <td><?php echo $flightlogsRow['airlineName'] ?></td>
                                        <td><?php echo $flightlogsRow['departureAirportCode'] ?></td>
                                        <td><?php echo $flightlogsRow['arrivalAirportCode'] ?></td>
                                        <td><?php echo $flightlogsRow['aircraftType'] ?></td>
                                        <td><?php echo $flightlogsRow['pilotName'] ?></td>
                                        <td><?php echo $flightlogsRow['passengerCount'] ?></td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <footer class="container-fluid py-3 mt-4" style="background-color: #394867;">
        <ul class="nav justify-content-center" 
            style="border-bottom: 2px solid #F6F5F2; padding-bottom: 3px; margin-bottom: 3px; width: calc(100% - 80px); margin-left: 40px; margin-right: 40px;">
            <li class="nav-item">
                <span class="nav-link px-2" style="color: #F6F5F2;">©rejoicerabino</span>
            </li>
        </ul>
        <p class="text-center" style="color: #F6F5F2;">Polytechnic University of the Philippines</p>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/js/all.min.js"></script>
</body>

</html>
