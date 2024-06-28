<?php
require_once 'header.php';
require_once 'db.php';
require_once 'classes/Product.php';

$errors = [];

// Controleer of het formulier is verzonden
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verkrijg gegevens van het formulier
    $naam = $_POST['naam'] ?? '';
    $omschrijving = $_POST['omschrijving'] ?? '';
    $maat = $_POST['maat'] ?? '';
    $prijs = $_POST['prijs'] ?? 0;

    // Afbeelding uploaden
    $targetDir = "uploads/";
    $afbeelding = $targetDir . basename($_FILES["afbeelding"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($afbeelding, PATHINFO_EXTENSION));

    // Controleer of het een echt afbeeldingsbestand is
    $check = getimagesize($_FILES["afbeelding"]["tmp_name"]);
    if ($check === false) {
        $errors[] = "Het bestand is geen afbeelding.";
        $uploadOk = 0;
    }

    // Controleer of het bestand al bestaat
    if (file_exists($afbeelding)) {
        $errors[] = "Sorry, dit bestand bestaat al.";
        $uploadOk = 0;
    }

    // Controleer het bestandstype
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        $errors[] = "Sorry, alleen JPG, JPEG, PNG & GIF bestanden zijn toegestaan.";
        $uploadOk = 0;
    }

    // Controleer de bestandsgrootte
    if ($_FILES["afbeelding"]["size"] > 500000) {
        $errors[] = "Sorry, je bestand is te groot.";
        $uploadOk = 0;
    }

    // Als alles goed is, probeer dan het bestand te uploaden
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["afbeelding"]["tmp_name"], $afbeelding)) {
            // Maak een nieuw Product object als het uploaden succesvol was
            $product = new Product(null, $naam, $omschrijving, $maat, $afbeelding, $prijs);

            // Opslaan in de database
            $product->save($db);

            // Redirect naar product_view.php of een andere pagina
            header("Location: product_view.php");
            exit();
        } else {
            $errors[] = "Sorry, er was een fout bij het uploaden van je bestand.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Toevoegen</title>
    <link rel="stylesheet" href="simple.css">
</head>
<body>
<h1>Product Toevoegen</h1>

<?php if (!empty($errors)): ?>
    <div style="color: red;">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
    <div>
        <label for="naam">Naam:</label>
        <input type="text" id="naam" name="naam" required>
    </div>
    <div>
        <label for="omschrijving">Omschrijving:</label>
        <textarea id="omschrijving" name="omschrijving"></textarea>
    </div>
    <div>
        <label for="maat">Maat:</label>
        <input type="text" id="maat" name="maat">
    </div>
    <div>
        <label for="afbeelding">Afbeelding uploaden:</label>
        <input type="file" id="afbeelding" name="afbeelding" accept="image/*" required>
    </div>
    <div>
        <label for="prijs">Prijs (in euro's):</label>
        <input type="number" id="prijs" name="prijs" step="0.01" required>
    </div>
    <div>
        <button type="submit">Toevoegen</button>
    </div>
</form>
<?php require_once 'footer.php'; ?>
</body>
</html>

