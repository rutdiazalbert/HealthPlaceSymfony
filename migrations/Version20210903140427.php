<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210903140427 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appointment (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, doctor_id INT NOT NULL, date DATE NOT NULL, time TIME NOT NULL, reason LONGTEXT NOT NULL, is_visited TINYINT(1) DEFAULT NULL, INDEX IDX_FE38F8446B899279 (patient_id), INDEX IDX_FE38F84487F4FB17 (doctor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE diagnosis (id INT AUTO_INCREMENT NOT NULL, doctor_id INT NOT NULL, patient_id INT NOT NULL, appointment_id INT NOT NULL, observation LONGTEXT NOT NULL, treatment LONGTEXT NOT NULL, INDEX IDX_7ED10F3D87F4FB17 (doctor_id), INDEX IDX_7ED10F3D6B899279 (patient_id), UNIQUE INDEX UNIQ_7ED10F3DE5B533F9 (appointment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, dr_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(60) NOT NULL, surname VARCHAR(60) NOT NULL, birthdate DATE NOT NULL, gender VARCHAR(20) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, phone INT DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649F2A652A5 (dr_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F8446B899279 FOREIGN KEY (patient_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F84487F4FB17 FOREIGN KEY (doctor_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE diagnosis ADD CONSTRAINT FK_7ED10F3D87F4FB17 FOREIGN KEY (doctor_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE diagnosis ADD CONSTRAINT FK_7ED10F3D6B899279 FOREIGN KEY (patient_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE diagnosis ADD CONSTRAINT FK_7ED10F3DE5B533F9 FOREIGN KEY (appointment_id) REFERENCES appointment (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F2A652A5 FOREIGN KEY (dr_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE diagnosis DROP FOREIGN KEY FK_7ED10F3DE5B533F9');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F8446B899279');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F84487F4FB17');
        $this->addSql('ALTER TABLE diagnosis DROP FOREIGN KEY FK_7ED10F3D87F4FB17');
        $this->addSql('ALTER TABLE diagnosis DROP FOREIGN KEY FK_7ED10F3D6B899279');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F2A652A5');
        $this->addSql('DROP TABLE appointment');
        $this->addSql('DROP TABLE diagnosis');
        $this->addSql('DROP TABLE user');
    }
}
