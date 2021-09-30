<?php
//------------------------------------------------------PHP FUNKTIONEN------------------------------------------------------
function get_data($host, $username, $password, $database, $bid, $data)
{

    $output = "";
    $conn = new mysqli($host, $username, $password, $database);

    $sql3 = "SELECT " . $data . " FROM buecher as b left join kategorien as k ON b.kategorie=k.id WHERE " . $bid . "=b.id";

    $result3 = $conn->query($sql3);
    if ($result3->num_rows == 0) {
        $output .= "";
    } else {
        while ($row3 = $result3->fetch_assoc()) {
            if (str_replace(' ', '', $row3[$data]) != "") {
                $output = htmlspecialchars($row3[$data]);
            } else {
                $output = "";
            }
        }
    }
    return $output;
}

function bid_valid($host, $username, $password, $database, $bid)
{

    $output = false;
    $conn = new mysqli($host, $username, $password, $database);

    $sql3 = "SELECT * FROM buecher as b WHERE " . $bid . "=b.id";

    $result3 = $conn->query($sql3);
    if ($result3->num_rows == 0) {
        $output = false;
    } else {
        while ($row3 = $result3->fetch_assoc()) {
            $output = true;
        }
    }
    return $output;
}


function get_k($host, $username, $password, $database, $bid)
{

    $output = "";
    $conn = new mysqli($host, $username, $password, $database);

    $sql3 = "SELECT k.id as kid, k.kategorie as kkateggorie, b.* FROM buecher as b left join kategorien as k ON b.kategorie=k.id WHERE " . $bid . "=b.id";

    $result3 = $conn->query($sql3);
    if ($result3->num_rows == 0) {
        $output .= "";
    } else {
        while ($row3 = $result3->fetch_assoc()) {

            $output .= $row3['kid'];
        }
    }
    return $output;
}

function get_klist($host, $username, $password, $database, $bid)
{
    $output = "";
    $conn = new mysqli($host, $username, $password, $database);

    $sql3 = "SELECT k.id as kid, k.kategorie as kkateggorie, k.* FROM kategorien as k";

    $result3 = $conn->query($sql3);
    if ($result3->num_rows == 0) {
        $output .= "";
    } else {
        while ($row3 = $result3->fetch_assoc()) {
            if ($row3['kid'] == get_k($host, $username, $password, $database, $bid)) {
                $output .= '<option value="' . $row3['kid'] . '" selected disabled>' . htmlspecialchars($row3['kkateggorie']) . '</option>';
            } else {

                $output .= '<option value="' . $row3['kid'] . '" disabled>' . htmlspecialchars($row3['kkateggorie']) . '</option>';
            }
        }
    }
    return $output;
}
