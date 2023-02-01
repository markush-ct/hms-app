<?php
include('include/config.php');

if ((isset($_POST['action']) && $_POST['action'] === 'updatePaidStatus') && isset($_POST['appointmentId'])) {
    mysqli_query($con, "UPDATE appointment SET IsPaid = '1' WHERE id = '" . $_POST['appointmentId'] . "'");
}

?>