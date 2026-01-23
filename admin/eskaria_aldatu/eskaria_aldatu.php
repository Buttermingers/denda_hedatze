<!DOCTYPE html>
<html lang="eu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eskaria Aldatu - Denda</title>
    <style>
    body{font-family:Arial,Helvetica,sans-serif;background:#f8f9fb;color:#222;margin:0;padding:20px}
    .container{max-width:800px;margin:0 auto;background:#fff;padding:20px;border-radius:5px;box-shadow:0 0 10px rgba(0,0,0,0.1)}
    h1{margin-top:0}
    label{display:block;font-weight:bold;margin-top:10px}
    input[type="text"],input[type="email"],input[type="number"],input[type="date"]{width:100%;padding:8px;margin-top:5px;border:1px solid #ccc;border-radius:4px;box-sizing:border-box}
    input[type="submit"]{margin-top:20px;background:#007bff;color:#fff;border:none;padding:10px 15px;border-radius:4px;cursor:pointer;font-size:16px}
    input[type="submit"]:hover{background:#0056b3}
    a{display:inline-block;margin-top:15px;color:#666;text-decoration:none}
    a:hover{text-decoration:underline}
    .products{margin-top:20px;padding:10px;background:#f9f9f9;border:1px solid #eee}
    table{width:100%;border-collapse:collapse;margin-top:10px}
    th,td{border:1px solid #ddd;padding:8px;text-align:left}
    th{background-color:#eee}
    </style>
</head>
<body>
    <div class="container">
        <h1>Eskaria Aldatu</h1>
        
        <?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>

        <form action="index.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $eskaria->getId(); ?>">
            
            <label>Data:</label>
            <input type="text" name="data" value="<?php echo htmlspecialchars($eskaria->getData()); ?>" required>

            <?php $bezeroa = $eskaria->getBezeroa(); ?>

            <label>Izena:</label>
            <input type="text" name="izena" value="<?php echo htmlspecialchars($bezeroa->getIzena()); ?>" required>

            <label>Abizenak:</label>
            <input type="text" name="abizenak" value="<?php echo htmlspecialchars($bezeroa->getAbizenak()); ?>" required>

            <label>Helbidea:</label>
            <input type="text" name="helbidea" value="<?php echo htmlspecialchars($bezeroa->getHelbidea()); ?>" required>

            <label>Herria:</label>
            <input type="text" name="herria" value="<?php echo htmlspecialchars($bezeroa->getHerria()); ?>" required>

            <label>Posta Kodea:</label>
            <input type="number" name="postaKodea" value="<?php echo htmlspecialchars($bezeroa->getPostaKodea()); ?>" required>

            <label>Probintzia:</label>
            <input type="text" name="probintzia" value="<?php echo htmlspecialchars($bezeroa->getProbintzia()); ?>" required>

            <label>Emaila:</label>
            <input type="email" name="emaila" value="<?php echo htmlspecialchars($bezeroa->getEmaila()); ?>" required>

            <div class="products">
                <h3>Eskariaren Produktuak</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Produktua</th>
                            <th>Kopurua</th>
                            <th>Ezabatu?</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($eskaria->getDetaileak() as $d): 
                        $p = $d->getProduktua();
                        $pid = $p->getId();
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($p->getIzena() ?? 'Produktua #' . $pid); ?></td>
                            <td>
                                <input type="number" name="detaileak[<?php echo $pid; ?>][kopurua]" value="<?php echo $d->getKopurua(); ?>" min="1" required style="width: 60px">
                            </td>
                            <td>
                                <input type="checkbox" name="detaileak[<?php echo $pid; ?>][ezabatu]" value="1">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <p style="font-size:0.9em; color:#666">* Produktu berriak gehitzeko, sortu eskaria berria edo editatu datu basean zuzenean.</p>
            </div>

            <input type="submit" value="Gorde Aldaketak">
        </form>
        
        <a href="../index.php">Atzera</a>
    </div>
</body>
</html>