<?php
require_once 'db.php';
require_once 'classes/Product.php';

// Array om foutmeldingen op te slaan
$errors = [];

// Verwerk het formulier indien ingediend
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validatie
    if (empty($_POST['naam'])) {
        $errors[] = 'Naam is verplicht.';
    }
    // Andere validaties voor omschrijving, maat, afbeelding, prijs etc.

    // Als er geen fouten zijn, sla het product op
    if (empty($errors)) {
        $product = new Product(
            null,
            $_POST['naam'],
            $_POST['omschrijving'],
            $_POST['maat'],
            $_POST['afbeelding'],
            (int)$_POST['prijs'] * 100 // Prijs in centen opslaan
        );
        $product->save($db);

        // Optioneel: Stuur gebruiker door naar de productenpagina na toevoegen
        header('Location: product_view.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toevoegen Product</title>
    <style>
        /* Basis CSS voor de opmaak (kan uitgebreid worden naar wens) */
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-group input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .form-group input[type="submit"]:hover {
            background-color: #45a049;
        }
        .error {
            color: red;
            margin-top: 5px;
        }
    </style>
</head>
<body>
<h1>Voeg een nieuw product toe</h1>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <div class="form-group">
        <label for="naam">Naam:</label>
        <input type="text" id="naam" name="naam" required>
    </div>
    <div class="form-group">
        <label for="omschrijving">Omschrijving:</label>
        <textarea id="omschrijving" name="omschrijving"></textarea>
    </div>
    <div class="form-group">
        <label for="maat">Maat:</label>
        <input type="text" id="maat" name="maat">
    </div>
    <div class="form-group">
        <label for="afbeelding">Afbeelding URL:</label>
        <input type="text" id="afbeelding" name="afbeelding">
    </div>
    <div class="form-group">
        <label for="prijs">Prijs (in eurocenten):</label>
        <input type="number" id="prijs" name="prijs" required>
    </div>
    <div class="form-group">
        <input type="submit" value="Opslaan">
    </div>
</form>

<?php if (!empty($errors)): ?>
    <div class="error">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
</body>
</html>
