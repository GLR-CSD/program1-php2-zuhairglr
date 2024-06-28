<?php
require_once 'header.php';
require_once 'db.php';
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
    <link rel="stylesheet" href="simple.css">
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
<?php require_once 'footer.php'; ?>
</body>
</html>
