#!/usr/bin/env php
<?php

declare(strict_types=1);

use Doctrine\DBAL\DriverManager;
use Symfony\Component\Dotenv\Dotenv;

require __DIR__.'/../vendor/autoload.php';

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class AddData
{
    private $connection = null;

    public function __construct() {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__.'/../.env');
        $connectionParams = [
            'url' => $_ENV['DATABASE_URL']
        ];
        $this->connection = DriverManager::getConnection($connectionParams);
    }

    private function isTablesExist(): bool
    {
        $result = true;
        $tablesToCheck = ['category', 'material', 'producer', 'product', 'product_material'];
        foreach ($tablesToCheck as $table) {
            $statement = $this->connection->executeQuery("SHOW TABLES LIKE '$table'");
            if ($statement->rowCount() == 0) {
                $result = false;
                break;
            }
        }
        return $result;
    }

    public function up(): void
    {
        if (!$this->isTablesExist()) {
            echo "Jedna z tabel nie istnieje! Zostanie wykonana komenda:\nphp bin/console doctrine:migrations:migrate\n\n";
            $result = shell_exec('echo yes | php bin/console doctrine:migrations:migrate 2>&1');
            echo $result;
        }

        // this up() migration is auto-generated, please modify it to your needs
        $this->connection->executeStatement('INSERT INTO category (name) VALUES ("Komputery"), ("Użytkowe")');
        $this->connection->executeStatement('INSERT INTO material (name, conductivity, incombustible) VALUES 
        ("Mosiądz", 1, 1), ("Metal", 1, 0), ("Stal nierdzewna", 1, 1), ("Drewno", 0, 0), ("Szkło", 0, 1), 
        ("Pallad", 1, 1), ("Złoto", 1, 1), ("Srebro", 1, 1), ("Mithril", 1, 1), ("Brąz", 1, 0)');
        $this->connection->executeStatement('INSERT INTO producer (name, country, headquarters, industry) VALUES 
            ("Leibniz Machine", "Polska", "Wrocław", "IT"),
            ("FutureTech", "Anglia", "Londyn", "IT"),
            ("ClockMaster", "Szwajcaria", "Berno", "Zegarmistrzowska")
        ');
        $this->connection->executeStatement('INSERT INTO product (name, image, price, availability, category_id, functions, producer_id) VALUES 
            ("Myszka", "steampunk_computer_mouse.png", 29.99, true, 1, \'["Dopasowywalne DPI", "Programowalne Przyciski", "Bezprzewodowa Technologia"]\', 1),
            ("Klawiatura", "steampunk_keyboard.png", 49.99, true, 1, \'["Mechanizm Klawiszy", "Multimedia", "Podpórka na Dłonie"]\', 1),
            ("Głośnik", "steampunk_loudspeaker.png", 129.99, false, 1, \'["Regulacja Głośności", "Łączność Bluetooth", "Zintegrowany zegar z wyświetlaczem nixie"]\', 1),
            ("Drukarka", "steampunk_printer.png", 249.99, true, 1, \'["Wysoka jakość druku", "Możliwość druku w kolorze"]\', 1),
            ("Drukarka 3D", "steampunk_3D_printer.png", 569.99, false, 1, \'["Precyzyjny druk 3D", "Duża powierzchnia druku", "Automatyczne regulowanie temperatury"]\', 2),
            ("Zegarek kieszonkowy", "steampunk_pocket_watch.png", 79.99, true, 1, \'["Design klasycznego zegarka kieszonkowego", "Zawiera widoczną machinerię", "Solidna obudowa"]\', 3)
        ');
        $this->connection->executeStatement('INSERT INTO product_material (product_id, material_id)
        VALUES 
          (1, 1), (1, 2), (1, 3), (1, 4), (1, 10),
          (2, 2), (2, 1), (2, 6),
          (3, 1), (3, 2), (3, 3), (3, 8),
          (4, 2), (4, 3), (4, 5), 
          (5, 2), (5, 3), (5, 6), (5, 5), 
          (6, 8), (6, 7), (6, 9), (6, 5)');
    }

    public function down(): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->connection->executeStatement('DELETE FROM product_material');
        $this->connection->executeStatement('DELETE FROM product');
        $this->connection->executeStatement('DELETE FROM producer');
        $this->connection->executeStatement('DELETE FROM material');
        $this->connection->executeStatement('DELETE FROM category');
        $this->connection->executeStatement('ALTER TABLE category AUTO_INCREMENT = 1');
        $this->connection->executeStatement('ALTER TABLE material AUTO_INCREMENT = 1');
        $this->connection->executeStatement('ALTER TABLE producer AUTO_INCREMENT = 1');
        $this->connection->executeStatement('ALTER TABLE product AUTO_INCREMENT = 1');
        $this->connection->executeStatement('ALTER TABLE product_material AUTO_INCREMENT = 1');
    }
}

// Sprawdzenie, czy skrypt jest uruchamiany z konsoli
if (PHP_SAPI === 'cli') {
    $migration = new AddData();
    if (in_array('add', $argv)) {
        $migration->up();
        echo "Dane zostały dodane do bazy.\n";
    } else if (in_array('remove', $argv)) {
        $migration->down();
        echo "Dane zostały usunięte z bazy.\n";
    } else {
        echo "Dostępne opcje:\nadd - dodaje dane do bazy danych\nremove - usuwa dane z bazy danych\n";
    }
}