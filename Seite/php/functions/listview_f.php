
<?php
//------------------------------------------------------PHP FUNKTIONEN------------------------------------------------------
function create_list($host, $username, $password, $database, $search, $search_tak, $sort_tak, $filt_kat, $this_page_first_result, $results_per_page)
{

    $output = "";
    $conn = new mysqli($host, $username, $password, $database);

    $sql3 = "SELECT b.id as bid, b.*, k.* FROM buecher as b left join kategorien as k ON b.kategorie=k.id WHERE " . $search_tak . " like '%" . $search . "%' AND k.id LIKE '%" . $filt_kat . "%' ORDER BY " . $sort_tak . " ASC LIMIT " . $this_page_first_result . "," . $results_per_page;

    $result3 = $conn->query($sql3);
    if ($result3->num_rows == 0) {
        $output .= "";
    } else {
        while ($row3 = $result3->fetch_assoc()) {
            if (str_replace(' ', '', $row3['kurztitle']) != "") {
                $bkurztitle = htmlspecialchars($row3['kurztitle']);
            } else {
                $bkurztitle = "Kein Kurztitel";
            }

            if (str_replace(' ', '', $row3['autor']) != "") {
                $bautor = htmlspecialchars($row3['autor']);
            } else {
                $bautor = "Kein Autor";
            }

            if (str_replace(' ', '', $row3['kategorie']) != "") {
                $kkategorie = htmlspecialchars($row3['kategorie']);
            } else {
                $kkategorie = "Keine Kategorie";
            }

            if (str_replace(' ', '', $row3['foto']) != "") {
                $foto = htmlspecialchars($row3['foto']);
            } else {
                $foto = "";
            }

            $id = $row3['bid'];

            $output .= '<div class="card bg-light mb-3 border-dark mb-3" style="max-width: 18rem; min-height: 25rem;">
            <div class="card-header">' . $kkategorie . '</div>
            <div class="card-body" >
            <img class="card-img-top" src="../pictures/' . $foto . '" alt="Kein Bild hinterlegt">
              <h5 class="card-title">' . $bkurztitle . '</h5>
              <p class="card-text">' . $bautor . '</p>
              <a href="detailview.php?id=' . $id . '" class="stretched-link"></a>
            </div>
          </div>';
        }
    }

    return $output;
}

function results($host, $username, $password, $database, $search, $search_tak, $sort_tak, $filt_kat, $this_page_first_result)
{

    $count = 0;
    $conn = new mysqli($host, $username, $password, $database);

    $sql3 = "SELECT * FROM buecher as b left join kategorien as k ON b.kategorie=k.id WHERE " . $search_tak . " like '%" . $search . "%' AND k.id LIKE '%" . $filt_kat . "%' ORDER BY " . $sort_tak . " ASC";

    $result3 = $conn->query($sql3);
    if ($result3->num_rows == 0) {
    } else {
        while ($row3 = $result3->fetch_assoc()) {

            $count++;
        }
    }
    return $count;
}

function category_list($host, $username, $password, $database, $search, $search_tak, $sort_tak, $this_page_first_result)
{

    $output = "";
    $conn = new mysqli($host, $username, $password, $database);

    $sql3 = "SELECT * FROM kategorien as k ORDER BY kategorie ASC";

    $result3 = $conn->query($sql3);
    if ($result3->num_rows == 0) {
        $output .= "FEHLER";
    } else {
        while ($row3 = $result3->fetch_assoc()) {

            $output .= '<option value="' . htmlspecialchars($row3['id']) . '">' . htmlspecialchars($row3['kategorie']) . '</option>';
        }
    }
    return $output;
}

function this_page_first_result($host, $username, $password, $database, $search, $search_tak, $sort_tak, $filt_kat, $this_page_first_result, $results_per_page)
{
    $conn = new mysqli($host, $username, $password, $database);

    $number_of_results = 0;

    $sql3 = "SELECT * FROM buecher as b left join kategorien as k ON b.kategorie=k.id WHERE " . $search_tak . " like '%" . $search . "%' AND k.id LIKE '%" . $filt_kat . "%' ORDER BY " . $sort_tak . " ASC";

    $result3 = $conn->query($sql3);
    if ($result3->num_rows == 0) {
        $this_page_first_result = 1;
    } else {
        while ($row3 = $result3->fetch_assoc()) {

            $number_of_results = $number_of_results + mysqli_num_rows($result3);

            //Momentane Seite
            if (!isset($_GET['page'])) {
                $page = 1;
            } else {
                $page = $_GET['page'];
            }

            //Startnummerzahl für den SQL Befehl "LIMIT"
            $this_page_first_result = ($page - 1) * $results_per_page;



            return $this_page_first_result;
        }
    }
    return $this_page_first_result;
}

//Hier wird die Pagination erstellt
function page_listed($ergebnisse, $results_per_page)
{
    $page_max = 0;
    $page_min = 0;
    $springen = 3;

    //Anzahl max. Seiten
    $number_of_pages = ceil($ergebnisse / $results_per_page);

    //Momentane Seite
    if (!isset($_GET['page'])) {
        $page = 1;
    } else {
        $page = $_GET['page'];
    }

    //Berechner der Pagination
    if ($page - $springen < 1) {
        $page_min = 1;
    } else {
        $page_min = $page - $springen;
    }

    if ($number_of_pages < 1) {
        $page_max = 1;
    } elseif ($page + $springen > $number_of_pages - 1) {
        $page_max = $number_of_pages;
    } else {
        $page_max = $page + $springen;
    }

    if ($number_of_pages == 1) {
        $page_min = 1;
        $page_max = 1;
    } elseif ($number_of_pages == 2) {
        $page_min = 1;
        $page_max = 2;
    }

    //Output Checker
    /*     echo ceil($ergebnisse / $results_per_page) . "     -    ";
    echo "number_of_pages: " . $number_of_pages . "=" . $ergebnisse . "/" . $results_per_page . " - ";
    echo "page_min: " . $page_min . " - ";
    echo "page_max: " . $page_max . " - ";
    echo "page: " . $page . " - "; */


    //Alle Seiten Printen
    echo '<nav><ul class="pagination justify-content-center pagination-lg">
 
      </li>';

    if ($number_of_pages != 1 and $page > 1) {
        echo '<li class="page-item"><a class="page-link" href="' . overwrite_url_with(1) . '">Erste Seite</a></li>';
    } else {
        echo '<li class="page-item disabled"><a class="page-link" href="">Erste Seite</a></li>';
    }


    //Springer
    if ($page - 30 > 0) {
        echo '<li class="page-item"><a class="page-link" href="' . overwrite_url_with($page - 30) . '"><<</a></li>';
    } else {
        echo '<li class="page-item disabled"><a class="page-link" href=""><<</a></li>';
    }

    //Looper
    for ($i = $page_min; $i <= $page_max; $i++) {
        if ($page == $i) {
            echo '<li class="page-item active"><a class="page-link" href="' . overwrite_url_with($i) . '">' . $i . '</a></li>';
        } else {
            echo '<li class="page-item"><a class="page-link" href="' . overwrite_url_with($i) . '">' . $i . '</a></li>';
        }
    }

    //Springer
    if ($page + 30 < $number_of_pages + 1) {
        echo '<li class="page-item"><a class="page-link" href="' . overwrite_url_with($page + 30) . '">>></a></li>';
    } else {

        echo '<li class="page-item disabled"><a class="page-link" href="">>></a></li>';
    }

    if ($number_of_pages > 1 and $number_of_pages != $page) {
        echo '<li class="page-item"><a class="page-link" href="' . overwrite_url_with($number_of_pages) . '">Letzte Seite</a></li>';
    } else {
        echo '<li class="page-item disabled"><a class="page-link" href="">Letzte Seite</a></li>';
    }
    echo '</ul></nav>';
}




function overwrite_url_with($value)
{

    $url = getcurrenturl();

    $url_parts = parse_url($url);
    // If URL doesn't have a query string.
    if (isset($url_parts['query'])) { // Avoid 'Undefined index: query'
        parse_str($url_parts['query'], $params);
    } else {
        $params = array();
    }

    $params['page'] = $value;     // Overwrite if exists

    // Note that this will url_encode all values
    $url_parts['query'] = http_build_query($params);

    //return
    return $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'] . '?' . $url_parts['query'];
}

function getcurrenturl()
{
    // Program to display URL of current page.
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $link = "https";
    else
        $link = "http";

    // Here append the common URL characters.
    $link .= "://";

    // Append the host(domain name, ip) to the URL.
    $link .= $_SERVER['HTTP_HOST'];

    // Append the requested resource location to the URL
    $link .= $_SERVER['REQUEST_URI'];

    return $link;
}
