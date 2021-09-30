<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDOs</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>



</head>

<body>

    <?php
    //meldet sich bei der datenbank an
    require 'functions/connect_db.php';

    require 'functions/listview_f.php';

    require 'navbar.php';


    $search = "";
    $search_tak = "";
    $sort_tak = "b.title";
    $filt_kat = "";

    $this_page_first_result = ""; //Navigation

    if (isset($_GET['search'])) {
        $search = $_GET['search'];
    }

    if (isset($_GET['search_tak'])) {
        $search_tak = $_GET['search_tak'];
    } else {
        $search_tak = "b.title";
    }


    if (isset($_GET['sort_tak'])) {
        $sort_tak = $_GET['sort_tak'];
    } else {
        $sort_tak = "b.title";
    }

    if (isset($_GET['filt_kat'])) {
        $filt_kat = $_GET['filt_kat'];
    }

    $results_per_page = 20;

    $this_page_first_result = this_page_first_result($host, $username, $password, $database, $search, $search_tak, $sort_tak, $filt_kat, $this_page_first_result, $results_per_page);

    $booklist = create_list($host, $username, $password, $database, $search, $search_tak, $sort_tak, $filt_kat, $this_page_first_result, $results_per_page);

    $ergebnisse = Results($host, $username, $password, $database, $search, $search_tak, $sort_tak, $filt_kat, $this_page_first_result);

    $category_list = category_list($host, $username, $password, $database, $search, $search_tak, $sort_tak, $this_page_first_result);


    ?>



    <div class="">

        <form method="GET">

            <div class="container p-3">
                <div class="form-row">

                    <div class="col-7">
                        <label for="search">Suchfeld: </label>
                        <input id="search" class="form-control mr-sm-2" type="search" value="<?php echo htmlspecialchars($_GET['search'] ?? '', ENT_QUOTES); ?>" name="search" placeholder="Suche" aria-label="Search">
                    </div>

                    <div class="col">
                        <label for="searchopt">Suche nur nach: </label>
                        <select name="search_tak" id="searchopt" class="custom-select mr-sm-2" aria-label="Default select example">
                            <option value="b.kurztitle" selected>Titel</option>
                            <option value="b.autor">Autor</option>
                        </select>
                    </div>

                    <script>
                        document.getElementById('searchopt').value = "<?php echo $_GET['search_tak']; ?>";
                    </script>

                    <div class="col">
                        <label for="submit">Suchen und Aktualisieren: </label>
                        <button id="submit" style="width: 9rem;" name="submit" class="btn btn-outline-success my-2 my-sm-0" type="submit">Suche</button>
                    </div>

                </div>


                <div class="form-row">

                    <div class="col">
                        <label for="sort">Sortieren nach: </label>
                        <select name="sort_tak" id="sort" class="custom-select mr-sm-2" aria-label="Default select example">
                            <option value="b.kurztitle">Titel</option>
                            <option value="b.autor">Autor</option>
                            <option value="k.kategorie">Kategorie</option>
                        </select>
                    </div>

                    <script>
                        document.getElementById('sort').value = "<?php echo $_GET['sort_tak']; ?>";
                    </script>


                    <div class="col">
                        <label for="filt">Kategorie: </label>
                        <select name="filt_kat" id="filt" class="custom-select mr-sm-2" aria-label="Default select example">
                            <option value="" selected>Alle</option>
                            <?php echo $category_list ?>
                        </select>
                    </div>

                    <script>
                        document.getElementById('filt').value = "<?php echo $_GET['filt_kat']; ?>";
                    </script>


                </div>



            </div>
        </form>
    </div>

    <div class="container p-3">
        <h4>Es gibt <?php echo $ergebnisse ?> Ergebnisse.</h4>
    </div>

    <!-- <div class="card-deck"> -->
    <div class="container border p-4">
        <div class="card-columns">
            <div class="container">
                <div class="container">
                    <?php echo $booklist; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="position-relative p-3">
        <!-- Pagination -->
        <?php page_listed($ergebnisse, $results_per_page) ?>

    </div>




</body>

<?php require 'footer.php'; ?>

</html>