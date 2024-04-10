<?php
// Set strict types
declare(strict_types=1);

class Persoon {
    /** @var int|null Het ID van de persoon */
    private ?int $id;

    /** @var string De voornaam van de persoon */
    private string $voornaam;

    /** @var string De achternaam van de persoon */
    private string $achternaam;

    /** @var string|null Het telefoonnummer van de persoon */
    private ?string $telefoonnummer;

    /** @var string|null Het e-mailadres van de persoon */
    private ?string $email;

    /** @var string|null Eventuele opmerkingen over de persoon */
    private ?string $opmerkingen;

    // Constructor
    public function __construct($id, $voornaam, $achternaam, $telefoonnummer, $email, $opmerkingen) {
        $this->id = $id;
        $this->voornaam = $voornaam;
        $this->achternaam = $achternaam;
        $this->telefoonnummer = $telefoonnummer;
        $this->email = $email;
        $this->opmerkingen = $opmerkingen;
    }

    // Methode om alle personen uit de database op te halen
    public static function getAll($db): array
    {
        // Voorbereiden van de query
        $stmt = $db->query("SELECT * FROM persoon");

        // Array om personen op te slaan
        $personen = [];

        // Itereren over de resultaten en personen toevoegen aan de array
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $persoon = new Persoon(
                $row['id'],
                $row['voornaam'],
                $row['achternaam'],
                $row['telefoonnummer'],
                $row['email'],
                $row['opmerkingen']
            );
            $personen[] = $persoon;
        }

        // Retourneer array met personen
        return $personen;
    }

    // Methode om een persoon te vinden op basis van ID
    public static function findById($db, $id): ?Persoon
    {
        // Voorbereiden van de query
        $stmt = $db->prepare("SELECT * FROM persoon WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Retourneer een persoon als gevonden, anders null
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            return new Persoon(
                $row['id'],
                $row['voornaam'],
                $row['achternaam'],
                $row['telefoonnummer'],
                $row['email'],
                $row['opmerkingen']
            );
        } else {
            return null;
        }
    }

    // Methode om personen te zoeken op basis van achternaam
    public static function findByAchternaam($db, string $achternaam): array
    {
        //Zet de achternaam eerst om naar lowercase letters
        $achternaam = strtolower($achternaam);

        // Voorbereiden van de query
        $stmt = $db->prepare("SELECT * FROM persoon WHERE LOWER(achternaam) LIKE :achternaam");

        // Voeg wildcard toe aan de achternaam
        $achternaam = "%$achternaam%";

        // Bind de achternaam aan de query en voer deze uit
        $stmt->bindParam(':achternaam', $achternaam);
        $stmt->execute();

        // Array om personen op te slaan
        $personen = [];

        // Itereren over de resultaten en personen toevoegen aan de array
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $personen[] = new Persoon(
                $row['id'],
                $row['voornaam'],
                $row['achternaam'],
                $row['telefoonnummer'],
                $row['email'],
                $row['opmerkingen']
            );
        }

        // Retourneer array met personen
        return $personen;
    }

    // Methode om een nieuwe persoon toe te voegen aan de database
    public function save($db): void
    {
        // Voorbereiden van de query
        $stmt = $db->prepare("INSERT INTO persoon (voornaam, achternaam, telefoonnummer, email, opmerkingen) VALUES (:voornaam, :achternaam, :telefoonnummer, :email, :opmerkingen)");
        $stmt->bindParam(':voornaam', $this->voornaam);
        $stmt->bindParam(':achternaam', $this->achternaam);
        $stmt->bindParam(':telefoonnummer', $this->telefoonnummer);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':opmerkingen', $this->opmerkingen);
        $stmt->execute();
    }

    // Methode om een bestaande persoon bij te werken op basis van ID
    public function update($db): void
    {
        // Voorbereiden van de query
        $stmt = $db->prepare("UPDATE persoon SET voornaam = :voornaam, achternaam = :achternaam, telefoonnummer = :telefoonnummer, email = :email, opmerkingen = :opmerkingen WHERE id = :id");
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':voornaam', $this->voornaam);
        $stmt->bindParam(':achternaam', $this->achternaam);
        $stmt->bindParam(':telefoonnummer', $this->telefoonnummer);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':opmerkingen', $this->opmerkingen);
        $stmt->execute();
    }

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVoornaam(): string
    {
        return $this->voornaam;
    }

    public function getAchternaam(): string
    {
        return $this->achternaam;
    }

    public function getTelefoonnummer(): ?string
    {
        return $this->telefoonnummer;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getOpmerkingen(): ?string
    {
        return $this->opmerkingen;
    }

    // Setters
    public function setVoornaam($voornaam): void
    {
        $this->voornaam = $voornaam;
    }

    public function setAchternaam($achternaam): void
    {
        $this->achternaam = $achternaam;
    }

    public function setTelefoonnummer($telefoonnummer): void
    {
        $this->telefoonnummer = $telefoonnummer;
    }

    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function setOpmerkingen($opmerkingen): void
    {
        $this->opmerkingen = $opmerkingen;
    }
}
