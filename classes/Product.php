<?php
declare(strict_types=1);

class Product {
    private ?int $id;
    private string $naam;
    private ?string $omschrijving;
    private ?string $maat;
    private ?string $afbeelding;
    private int $prijs;

    public function __construct(?int $id, string $naam, ?string $omschrijving, ?string $maat, ?string $afbeelding, int $prijs) {
        $this->id = $id;
        $this->naam = $naam;
        $this->omschrijving = $omschrijving;
        $this->maat = $maat;
        $this->afbeelding = $afbeelding;
        $this->prijs = $prijs;
    }

    public static function getAll(PDO $db): array {
        $stmt = $db->query("SELECT * FROM producten");
        $producten = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $producten[] = new Product(
                $row['id'],
                $row['naam'],
                $row['omschrijving'],
                $row['maat'],
                $row['afbeelding'],
                $row['prijs']
            );
        }
        return $producten;
    }

    public function save(PDO $db): void {
        $stmt = $db->prepare("INSERT INTO producten (naam, omschrijving, maat, afbeelding, prijs) VALUES (:naam, :omschrijving, :maat, :afbeelding, :prijs)");
        $stmt->bindParam(':naam', $this->naam);
        $stmt->bindParam(':omschrijving', $this->omschrijving);
        $stmt->bindParam(':maat', $this->maat);
        $stmt->bindParam(':afbeelding', $this->afbeelding);
        $stmt->bindParam(':prijs', $this->prijs);
        $stmt->execute();
    }

    // Getters (omitted for brevity)
}
?>
