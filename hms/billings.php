<?php
session_start();
error_reporting(0);
include('include/config.php');

$data = array();
$loginId = $_SESSION['id'];

if (strlen($loginId === 0)) {
    header('location:logout.php');
} else {
    $appointments = mysqli_query($con, "SELECT doctors.doctorName, appointment.* FROM appointment JOIN doctors ON doctors.id =appointment.doctorId WHERE IsApproved = '1' AND userId = '" . $loginId . "'");
    $resAppointments = mysqli_fetch_all($appointments, MYSQLI_ASSOC);

    foreach ($resAppointments as $item) {
        $data['appointments'][$item['id']] = $item;
    }

    // echo '<pre>';
    // print_r($data);
    // exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HMS | Billings</title>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/css/fontawsom-all.min.css">
    <link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
    <link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
    <link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
    <link href="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" media="screen">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="screen">
    <link href="vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" media="screen">
    <link href="vendor/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/plugins.css">
    <link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
</head>

<body>
    <div id="app">
        <?php include('include/sidebar.php'); ?>
        <div class="app-content">
            <?php include('include/header.php'); ?>
            <div class="main-content">
                <div class="wrap-content container" id="container">
                    <section id="page-title">
                        <div class="row">
                            <div class="col-sm-8">
                                <h1 class="mainTitle">User | Billings</h1>
                            </div>
                            <ol class="breadcrumb">
                                <li>
                                    <span>User </span>
                                </li>
                                <li class="active">
                                    <span>Billings</span>
                                </li>
                            </ol>
                        </div>
                    </section>
                    <div class="container-fluid container-fullw bg-white">
                        <?php if (!isset($_GET['action'])) { ?>
                            <div class="panel-heading">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#appointments" data-toggle="tab">Appointments</a></li>
                                    <li><a href="#admissions" data-toggle="tab">Admissions</a></li>
                                </ul>
                            </div>
                            <div class="panel-body">
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="appointments">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Service</th>
                                                    <th>Doctor</th>
                                                    <th>Consultancy Fee</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data['appointments'] as $item) { ?>
                                                    <tr>
                                                        <td><?php echo $item['doctorSpecialization'] ?></td>
                                                        <td>Dr. <?php echo $item['doctorName'] ?></td>
                                                        <td><?php echo $item['consultancyFees'] ?></td>
                                                        <td><?php echo $item['IsPaid'] ? '<span class="badge badge-success">Paid</span>' : '<span class="badge badge-warning">Pending</span>' ?></td>
                                                        <td>
                                                            <?php if (!$item['IsPaid']) { ?>
                                                                <a href="?action=checkoutAppointment&appointmentId=<?php echo $item['id'] ?>" class="btn btn-transparent btn-xs tooltips" title="Checkout Appointment" tooltip-placement="top" tooltip="Remove">Checkout</a>
                                                            <?php } else { ?>
                                                                --
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="admissions">
                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Facere rem doloremque quidem ducimus. Perferendis distinctio corrupti eos repellendus, temporibus, illo aliquam inventore culpa quaerat nesciunt, facilis necessitatibus blanditiis consequatur mollitia!
                                    </div>
                                </div>
                            </div>
                        <?php } elseif (isset($_GET['action']) && $_GET['action'] === 'checkoutAppointment') { ?>
                            <?php $appointment = $data['appointments'][$_GET['appointmentId']] ?>
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-10">
                                        <h3>Checkout Appointment</h3>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-2 text-right">
                                        <a href="/hms/billings.php" class="btn btn-primary">
                                            <i class="fas fa-arrow-left"></i> Back
                                        </a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="border-bottom">
                                            <span class="text-bold">Creation Date: </span><?php echo date('F j, Y g:i a', strtotime($appointment['postingDate'])) ?>
                                        </p>
                                        <p class="border-bottom">
                                            <span class="text-bold">Service: </span><?php echo $appointment['doctorSpecialization'] ?>
                                        </p>
                                        <p class="border-bottom">
                                            <span class="text-bold">Doctor: </span>Dr. <?php echo $appointment['doctorName'] ?>
                                        </p>
                                        <p class="border-bottom">
                                            <span class="text-bold">Consultancy Fee: </span><?php echo $appointment['consultancyFees'] ?>
                                        </p>
                                        <p>
                                        <div id="paypal-button-container" class="text-right"></div>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            a
                            Checkout admission here...
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/modernizr/modernizr.js"></script>
    <script src="vendor/jquery-cookie/jquery.cookie.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="vendor/switchery/switchery.min.js"></script>
    <script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
    <script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
    <script src="vendor/autosize/autosize.min.js"></script>
    <script src="vendor/selectFx/classie.js"></script>
    <script src="vendor/selectFx/selectFx.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/form-elements.js"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=[your-app-id]&currency=USD"></script>

    <script>
        jQuery(document).ready(function() {
            Main.init();
            FormElements.init();
        });
    </script>

    <?php if (isset($_GET['action']) && $_GET['action'] === 'checkoutAppointment' && !$appointment['IsPaid']) { ?>
        <script type="text/javascript">
            paypal.Buttons({
                style: {
                    layout: 'horizontal',
                    color: 'blue',
                    label: 'pay',
                    shape: 'pill',
                    tagline: true
                },
                // Sets up the transaction when a payment button is clicked
                createOrder: (data, actions) => {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: <?php echo $appointment['consultancyFees'] ?> // Can also reference a variable or function
                            }
                        }]
                    });
                },
                // Finalize the transaction after payer approval
                onApprove: (data, actions) => {
                    return actions.order.capture().then(function(orderData) {
                        // Successful capture! For dev/demo purposes:
                        console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                        const transaction = orderData.purchase_units[0].payments.captures[0];
                        alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
                        // When ready to go live, remove the alert and show a success message within this page. For example:
                        // const element = document.getElementById('paypal-button-container');
                        // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                        // Or go to another URL:  actions.redirect('thank_you.html');
                        $.ajax({
                            url: 'update-paid-status.php',
                            type: 'post',
                            data: 'action=updatePaidStatus&appointmentId=<?php echo $appointment['id'] ?>',
                            success: function (response) {
                                console.log(response);
                                location.replace('billings.php');
                            }
                        })
                    });
                }
            }).render('#paypal-button-container');
        </script>
    <?php } ?>
</body>

</html>