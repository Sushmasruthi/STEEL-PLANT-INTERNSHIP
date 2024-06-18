<?php
include 'db.php';

$years = [2003, 2004, 2005];
$data = [];

foreach ($years as $year) {
    $sql = "SELECT EQPT, SUM(DELAY_DURN) as total_delay FROM delays 
            WHERE SHOP_CODE = 2 
              AND MONTH(DEL_DATE) = 3 
              AND YEAR(DEL_DATE) = $year 
            GROUP BY EQPT";
    $result = $conn->query($sql);
    
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
$conn->close();

function getColor($index) {
    $colors = [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
    ];
    $borders = [
        'rgba(255, 99, 132, 1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
    ];
    return [$colors[$index % count($colors)], $borders[$index % count($borders)]];
}

header('Content-Type: application/json');
echo json_encode($data);
?>
