<?php
session_start();
include("include/config.php");

$specialization = $_GET['specialization'] ?? null;

function getServices($con)
{
    $stmt = 'SELECT * FROM doctorspecilization';

    $res = mysqli_query($con, $stmt);
    return $res;
}

function getDoctors($con, $specialization)
{
    $stmt = "SELECT * FROM doctors WHERE specilization='$specialization'";

    $res = mysqli_query($con, $stmt);
    return $res;
}

$services = getServices($con);
$doctors = '';

if (!is_null($specialization)) {
    $doctors = getDoctors($con, $specialization);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Hospital management System </title>

    <link rel="shortcut icon" href="/assets/images/fav.jpg">
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/fontawsom-all.min.css">
    <link rel="stylesheet" href="/assets/css/animate.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css" />
</head>

<body>
    <header id="menu-jk">

        <div id="nav-head" class="header-nav">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 col-md-3 col-sm-12" style="color:#000;font-weight:bold; font-size:42px; margin-top: 1% !important;">HMS
                        <a data-toggle="collapse" data-target="#menu" href="#menu"><i class="fas d-block d-md-none small-menu fa-bars"></i></a>
                    </div>
                    <div id="menu" class="col-lg-10 col-md-9 d-none d-md-block nav-item">
                        <ul class="d-md-flex justify-content-md-end">
                            <li><a href="/#">Home</a></li>
                            <li><a href="/#services">Services</a></li>
                            <li><a href="/#about_us">About Us</a></li>
                            <li><a href="/#gallery">Gallery</a></li>
                            <li><a href="/#contact_us">Contact Us</a></li>
                            <li><a href="/#logins">Logins</a></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <?php if (is_null($specialization)) { ?>
        <section class="py-3">
            <div class="container">
                <h2>Services</h2>

                <div class="row">
                    <?php while ($row = mysqli_fetch_array($services)) { ?>
                        <div class="col-md-4 col-sm-12 py-2 px-md-2">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="mb-3"><?php echo $row['specilization'] ?></h5>
                                    <a href="?specialization=<?php echo $row['specilization'] ?>" class="btn btn-primary d-block">See Doctors</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>
    <?php } elseif (isset($specialization) && mysqli_num_rows($doctors) > 0) { ?>
        <section class="py-3">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <h2><?php echo $specialization ?></h2>
                    <a href="/hms/services.php" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>

                <div class="row">
                    <?php while ($row = mysqli_fetch_array($doctors)) { ?>
                        <div class="col-md-4 col-sm-12 py-2 px-md-2">
                            <div class="card">
                                <div class="card-body">
                                    <p><span class="font-weight-bold">Name:</span> Dr. <?php echo $row['doctorName'] ?></p>
                                    <p><span class="font-weight-bold">Address:</span> <?php echo $row['address'] ?></p>
                                    <p><span class="font-weight-bold">Fee:</span> &#8369;<?php echo $row['docFees'] ?></p>
                                    <p><span class="font-weight-bold">Contact No:</span> <?php echo '0' . $row['contactno'] ?></p>
                                    <p><span class="font-weight-bold">Email:</span> <?php echo $row['docEmail'] ?></p>
                                    <a href="user-login.php?next=book-appointment.php?specialty=<?php echo $row['specilization'] ?>%26doctorid=<?php echo $row[0] ?>" class="btn btn-primary d-block mt-3">Book Now</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>
    <?php } else { ?>
        <?php http_response_code(404); ?>
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="flex text-center">
                <h1 class="mb-3">No Doctors Found!</h1>
                <a href="/hms/services.php" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Back to Services
                </a>
            </div>
        </div>
    <?php } ?>

    <script src="/assets/js/jquery-3.2.1.min.js"></script>
    <script src="/assets/js/popper.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/plugins/scroll-nav/js/jquery.easing.min.js"></script>
    <script src="/assets/plugins/scroll-nav/js/scrolling-nav.js"></script>
    <script src="/assets/plugins/scroll-fixed/jquery-scrolltofixed-min.js"></script>

    <script src="/assets/js/script.js"></script>
</body>

</html>