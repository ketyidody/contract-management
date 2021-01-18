<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210116083041 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contract (id INT AUTO_INCREMENT NOT NULL, person_id INT DEFAULT NULL, start_date DATE NOT NULL, end_date DATE DEFAULT NULL, notice_period INT NOT NULL, rent INT NOT NULL, INDEX IDX_E98F2859217BBB47 (person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person (id INT AUTO_INCREMENT NOT NULL, resident_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, personal_id VARCHAR(255) NOT NULL, INDEX IDX_34DCD1768012C5B0 (resident_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rental_object (id INT AUTO_INCREMENT NOT NULL, contract_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, number_of_rooms INT NOT NULL, description LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_9883BF8B2576E0FD (contract_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contract ADD CONSTRAINT FK_E98F2859217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD1768012C5B0 FOREIGN KEY (resident_id) REFERENCES contract (id)');
        $this->addSql('ALTER TABLE rental_object ADD CONSTRAINT FK_9883BF8B2576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD1768012C5B0');
        $this->addSql('ALTER TABLE rental_object DROP FOREIGN KEY FK_9883BF8B2576E0FD');
        $this->addSql('ALTER TABLE contract DROP FOREIGN KEY FK_E98F2859217BBB47');
        $this->addSql('DROP TABLE contract');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE rental_object');
    }
}
