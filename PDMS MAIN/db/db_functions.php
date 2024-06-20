<?php
include 'db.php';

function getMajorDelays($shopCode, $startDate, $endDate) {
    global $conn;
    $data = [];

    $sql = "SELECT EQPT, SUM(DELAY_DURN) as total_delay FROM delays 
            WHERE SHOP_CODE = ? 
              AND DEL_DATE BETWEEN ? AND ?
            GROUP BY EQPT";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $shopCode, $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    return $data;
}
function getDateWiseDelays($shopCode, $startDate, $endDate) {
    global $conn;
    $data = [];

    $sql = "SELECT SUM(DELAY_DURN) AS total_delay, EQPT
            FROM delays
            WHERE DELAY_DURN > 1
              AND SHOP_CODE = ?
              AND DEL_DATE BETWEEN ? AND ?
            GROUP BY EQPT";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        // Handle error
        error_log('Prepare failed: ' . $conn->error);
        die(json_encode(['error' => 'Prepare failed: ' . $conn->error]));
    }

    $stmt->bind_param("sss", $shopCode, $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

function getContinuedDelays($shopCode, $startDate, $endDate) {
    global $conn;
    $data = [];

    $sql = "SELECT EQPT, SUM(DELAY_DURN) as total_delay FROM delays 
            WHERE CONTINUED = 'Y'
              AND DEL_DATE BETWEEN ? AND ?
            GROUP BY EQPT";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    return $data;
}

function getConveyorDelays($shopCode, $startDate, $endDate) {
    global $conn;
    $data = [];

    $sql = "SELECT EQPT, SUM(DELAY_DURN) as total_delay
            FROM delays
            WHERE remarks LIKE '%Conveyor%'
             AND DEL_DATE BETWEEN ? AND ?
            GROUP BY EQPT";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    return $data;
}

function getRawMaterialDelays($shopCode, $startDate, $endDate) {
    global $conn;
    $data = [];

    $sql = "SELECT MATERIAL, SUM(DELAY_DURN) as total_delay FROM delays 
    WHERE SHOP_CODE = ? 
    AND DEL_DATE BETWEEN ? AND ?
    GROUP BY MATERIAL";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $shopCode, $startDate, $endDate);

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    return $data;
}

function getAgencyWiseDelays($shopCode, $startDate, $endDate) {
    global $conn;
    $data = [];

    $sql = "SELECT AGENCY_CODE, SUM(DELAY_DURN) as total_delay FROM delays 
            WHERE DEL_DATE BETWEEN ? AND ?
            GROUP BY AGENCY_CODE";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $startDate, $endDate);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    return $data;
}


function insertDelay($data) {
    global $conn;

    $sql = "INSERT INTO delays (DEL_DATE, SHOP_CODE, MATERIAL, RAKE, DELAY_FROM, DELAY_TO, DELAY_DURN, CUM_DELAY, EQPT, SUB_EQPT, REMARKS, DELAY_DET_CODE, AGENCY_CODE, DELAY_FREQ, CONTINUED, EXPECTED_DOC, EFF_DURATION, USER_ENTERED, DELAY_ID, DELAY_REF_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssiddiddsssidisssii",
        $data['del_date'], $data['shop_code'], $data['material'], $data['rake'],
        $data['delay_from'], $data['delay_to'], $data['delay_durn'], $data['cum_delay'],
        $data['eqpt'], $data['sub_eqpt'], $data['remarks'], $data['delay_det_code'],
        $data['agency_code'], $data['delay_freq'], $data['continued'], $data['expected_doc'],
        $data['eff_duration'], $data['user_entered'], $data['delay_id'], $data['delay_ref_id']
    );

    return $stmt->execute();
}
?>
