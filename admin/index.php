<?php
session_start();

if (!isset($_SESSION['admin']) || !$_SESSION['admin']) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="eu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denda</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f8f9fb;
            color: #222;
            margin: 0;
            padding: 20px
        }

        .container {
            max-width: 1100px;
            margin: 0 auto
        }

        h1,
        h2 {
            color: #222
        }

        a {
            color: #007bff
        }

        table {
            width: 100%;
            border-collapse: collapse
        }

        th,
        td {
            border: 1px solid #e6e6e6;
            padding: 8px;
            text-align: left
        }

        th {
            background: #f2f2f2
        }

        form p {
            margin: 10px 0
        }

        label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px
        }

        input[type="text"],
        input[type="password"],
        textarea,
        select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px
        }

        input[type="submit"],
        button {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer
        }
    </style>
</head>

<body>
    <h1>Denda - Administratzailea</h1>



    <hr>

    <?php include 'kategoriak_erakutsi.php'; ?>

    <hr>

    <?php include 'produktuak_erakutsi.php'; ?>

    <hr>

    <?php include 'mezuak_erakutsi.php'; ?>

    <hr>

    <?php include 'eskariak_erakutsi.php'; ?>

    <p><a href="irten.php">Irten</a></p>
</body>

</html>