<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buch Detail</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>


<body>

    <?php
    //meldet sich bei der datenbank an
    require 'functions/connect_db.php';

    require 'functions/detailview_f.php';

    require 'navbar.php';

    if (isset($_GET['id']) and bid_valid($host, $username, $password, $database, $_GET['id'])) {
        $bid = $_GET['id'];

        $title = get_data($host, $username, $password, $database, $bid, "title");
        $autor = get_data($host, $username, $password, $database, $bid, "autor");
        $kurztitle = get_data($host, $username, $password, $database, $bid, "kurztitle");
        $category_list = get_klist($host, $username, $password, $database, $bid);
        $sprache = get_data($host, $username, $password, $database, $bid, "sprache");
        $verkauft = get_data($host, $username, $password, $database, $bid, "verkauft");

        $imageurl = get_data($host, $username, $password, $database, $bid, "foto");
    } else {
    ?>
        <meta http-equiv="refresh" content="0;url=listview.php" />
    <?php
    }
    ?>

    <div class="d-flex justify-content-center">
        <div class="container m-5">
            <div class="d-flex justify-content-center">

                <h2><?php if ($verkauft == 1) {
                        echo "Das Buch (ID: " . $bid . ") wurde verkauft.";
                    } else {
                        echo "Das Buch (ID: " . $bid . ") ist noch verfügbar.";
                    } ?></h2>

            </div>

            <img src="../pictures/<?php echo $imageurl; ?>" class="rounded float-left" alt="Kein Bild.">

            <form method="">
                <div class="container p-3 ">

                    <div class="form-row">
                        <div class="col">
                            <label for="title">Titel: </label>
                            <textarea id="title" class="form-control" name="title" placeholder="Kein Titel" cols="3" rows="3" readonly><?php echo $title ?></textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col">
                            <label for="kurztitle">Kurztitel: </label>
                            <input id="kurztitle" name="kurztitle" value="<?php echo $kurztitle ?>" class="form-control" type="text" placeholder="Kein Kurztitel" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col">
                            <label for="autor">Autor: </label>
                            <input id="autor" name="autor" value="<?php echo $autor ?>" class="form-control" type="text" placeholder="Kein Autor" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col">
                            <label for="filt">Kategorie: </label>
                            <select name="filt_kat" id="filt" class="custom-select mr-sm-2" aria-label="Default select example">
                                <?php echo $category_list ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col">
                            <label for="sprache">Sprachen: </label>
                            <input id="sprache" name="sprache" value="<?php echo $sprache ?>" class="form-control" type="text" placeholder="Keine Sprache" readonly>
                        </div>
                    </div>


                </div>
            </form>

        </div>
    </div>
    <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
</body>
<?php require 'footer.php'; ?>

</html>