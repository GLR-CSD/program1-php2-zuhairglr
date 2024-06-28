<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Producten'; ?></title>
    <link rel="stylesheet" href="simple.css">
    <style>

    </style>
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="product_view.php">Producten</a></li>
            <li><a href="toevoegen.php">Product Toevoegen</a></li>
            <!-- Voeg hier extra navigatie-items toe indien nodig -->
        </ul>
    </nav>
</header>
<main>
