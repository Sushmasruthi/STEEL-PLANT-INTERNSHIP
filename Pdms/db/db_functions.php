<?php
// /xampp/htdocs/PDMS/db/db_functions.php

include 'db.php';

function getCumulativeDelays($shopCode, $month, $years) {
    global $conn;
    $data = [];

    foreach ($years as $year) {
        $sql = "SELECT EQPT, SUM(DELAY_DURN) as total_delay FROM delays 
                WHERE SHOP_CODE = ? 
                  AND MONTH(DEL_DATE) = ? 
                  AND YEAR(DEL_DATE) = ? 
                GROUP BY EQPT";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $shopCode, $month, $year);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $equipment = [];
        $total_delays = [];
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $equipment[] = $row['EQPT'];
                $total_delays[] = $row['total_delay'];
            }
        }
        $data[$year] = ['equipment' => $equipment, 'total_delays' => $total_delays];
    }

    return $data;
} 
?>
