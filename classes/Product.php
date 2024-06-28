<?php
// classes/Product.php

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

    // Getter-methoden om de waarden van de eigenschappen op te halen
    public function getNaam(): string {
        return $this->naam;
    }

    public function getOmschrijving(): ?string {
        return $this->omschrijving;
    }

    public function getMaat(): ?string {
        return $this->maat;
    }

    public function getAfbeelding(): ?string {
        return $this->afbeelding;
    }

    public function getPrijs(): int {
        return $this->prijs;
    }

    // Andere methoden zoals getAll en save moeten ook hier worden opgenomen
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
        if ($this->id) {
            // Als het ID al is ingesteld, voer een UPDATE uit
            $stmt = $db->prepare("UPDATE producten SET naam = :naam, omschrijving = :omschrijving, maat = :maat, afbeelding = :afbeelding, prijs = :prijs WHERE id = :id");
            $stmt->bindParam(':id', $this->id);
        } else {
            // Anders voer een INSERT uit
            $stmt = $db->prepare("INSERT INTO producten (naam, omschrijving, maat, afbeelding, prijs) VALUES (:naam, :omschrijving, :maat, :afbeelding, :prijs)");
        }

        // Bind parameters en voer uit
        $stmt->bindParam(':naam', $this->naam);
        $stmt->bindParam(':omschrijving', $this->omschrijving);
        $stmt->bindParam(':maat', $this->maat);
        $stmt->bindParam(':afbeelding', $this->afbeelding);
        $stmt->bindParam(':prijs', $this->prijs);

        $stmt->execute();
    }
}
?>
