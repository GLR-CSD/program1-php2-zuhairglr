<?php
require_once '/pad/naar/db.php';
require_once 'classes/Product.php';

// Producten ophalen uit de database
$producten = Product::getAll($db);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Producten</title>
    <style>
        /* Basis CSS voor de opmaak (kan uitgebreid worden naar wens) */
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
            border-radius: 5px;
        }
        img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
<h1>Producten</h1>
<ul>
    <?php foreach ($producten as $product): ?>
        <li>
            <h2><?php echo htmlspecialchars($product->getNaam()); ?></h2>
            <p>Omschrijving: <?php echo htmlspecialchars($product->getOmschrijving()); ?></p>
            <p>Maat: <?php echo htmlspecialchars($product->getMaat()); ?></p>
            <p>Prijs: €<?php echo number_format($product->getPrijs() / 100, 2); ?></p>
            <?php if ($product->getAfbeelding()): ?>
                <img src="<?php echo htmlspecialchars($product->getAfbeelding()); ?>" alt="Product Afbeelding">
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>
</body>
</html>
