<?php
include 'db/db_functions.php';

header('Content-Type: application/json');

// Disable error reporting in the response, but log errors to a file
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/php-error.log'); // Update this path as needed

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_GET['type'])) {
        $type = $_GET['type'];
        $data = [];

        switch ($type) {
            case 'date_wise':
                $shopCode = intval($_POST['shopCode']);
                $startDate = $_POST['startDate'];
                $endDate = $_POST['endDate'];
                $data = getDateWiseDelays($shopCode, $startDate, $endDate);
                break;
            case 'continued':
                $shopCode = intval($_POST['shopCode']);
                $startDate = $_POST['startDate'];
                $endDate = $_POST['endDate'];
                $data = getContinuedDelays($shopCode, $startDate, $endDate);
                break;
            case 'conveyor':
                $shopCode = intval($_POST['shopCode']);
                $startDate = $_POST['startDate'];
                $endDate = $_POST['endDate'];
                $data = getConveyorDelays($shopCode, $startDate, $endDate);
                break;
            case 'raw_material':
                $shopCode = intval($_POST['shopCode']);
                $startDate = $_POST['startDate'];
                $endDate = $_POST['endDate'];
                $data = getRawMaterialDelays($shopCode, $startDate, $endDate);
                break;
            case 'agency':
                $shopCode = intval($_POST['shopCode']);
                $startDate = $_POST['startDate'];
                $endDate = $_POST['endDate'];
                $data = getAgencyWiseDelays($shopCode, $startDate, $endDate);
                break;
            case 'shop_wise':
                $shopCode = intval($_POST['shopCode']);
                $startDate = $_POST['startDate'];
                $endDate = $_POST['endDate'];
                $data = getMajorDelays($shopCode, $startDate, $endDate);
                break;
            case 'submit_delay':
                $data = [
                    'del_date' => $_POST['del_date'],
                    'shop_code' => $_POST['shop_code'],
                    'material' => $_POST['material'],
                    'rake' => $_POST['rake'],
                    'delay_from' => $_POST['delay_from'],
                    'delay_to' => $_POST['delay_to'],
                    'delay_durn' => $_POST['delay_durn'],
                    'cum_delay' => $_POST['cum_delay'],
                    'eqpt' => $_POST['eqpt'],
                    'sub_eqpt' => $_POST['sub_eqpt'],
                    'remarks' => $_POST['remarks'],
                    'delay_det_code' => $_POST['delay_det_code'],
                    'agency_code' => $_POST['agency_code'],
                    'delay_freq' => $_POST['delay_freq'],
                    'continued' => isset($_POST['continued']) ? 1 : 0,
                    'expected_doc' => $_POST['expected_doc'],
                    'eff_duration' => $_POST['eff_duration'],
                    'user_entered' => $_POST['user_entered'],
                    'delay_id' => $_POST['delay_id'],
                    'delay_ref_id' => $_POST['delay_ref_id']
                ];

                $result = insertDelay($data);

                if ($result) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false]);
                }
                break;
            default:
                echo json_encode(['success' => false, 'message' => 'Invalid request type']);
        }

        if ($type !== 'submit_delay') {
            echo json_encode($data);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No request type specified']);
    }
}
?>
