<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210319013305 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agence (id INT AUTO_INCREMENT NOT NULL, pays_id INT DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, tel INT NOT NULL, update_at DATETIME DEFAULT NULL, INDEX IDX_64C19AA9A6E44244 (pays_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chauffeur (id_chauffeur INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, date_d_n DATE DEFAULT NULL, PRIMARY KEY(id_chauffeur)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE moydetran (id_moy_trans INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) DEFAULT NULL, matricule VARCHAR(255) DEFAULT NULL, disponibilite INT DEFAULT NULL, PRIMARY KEY(id_moy_trans)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pays (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, continent VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plan (id INT AUTO_INCREMENT NOT NULL, pays_id INT DEFAULT NULL, agence_id INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, sujet VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date DATE NOT NULL, prix DOUBLE PRECISION NOT NULL, update_at DATETIME DEFAULT NULL, INDEX IDX_DD5A5B7DA6E44244 (pays_id), INDEX IDX_DD5A5B7DD725330D (agence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plan_res (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, plan_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_75536115A76ED395 (user_id), UNIQUE INDEX UNIQ_75536115E899029B (plan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, utilisateurs_id INT DEFAULT NULL, object VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, statut VARCHAR(255) NOT NULL, INDEX IDX_CE6064041E969C5 (utilisateurs_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trajet (id_trajet INT AUTO_INCREMENT NOT NULL, id_moy_trans INT DEFAULT NULL, date_depart DATE DEFAULT NULL, date_arrive DATE DEFAULT NULL, pt_depart VARCHAR(255) DEFAULT NULL, pt_arrive VARCHAR(255) DEFAULT NULL, id_chauffeur INT DEFAULT NULL, prix DOUBLE PRECISION DEFAULT NULL, INDEX FN_key (id_chauffeur), INDEX FN_keymoy (id_moy_trans), PRIMARY KEY(id_trajet)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agence ADD CONSTRAINT FK_64C19AA9A6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id)');
        $this->addSql('ALTER TABLE plan ADD CONSTRAINT FK_DD5A5B7DA6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id)');
        $this->addSql('ALTER TABLE plan ADD CONSTRAINT FK_DD5A5B7DD725330D FOREIGN KEY (agence_id) REFERENCES agence (id)');
        $this->addSql('ALTER TABLE plan_res ADD CONSTRAINT FK_75536115A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE plan_res ADD CONSTRAINT FK_75536115E899029B FOREIGN KEY (plan_id) REFERENCES plan (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE6064041E969C5 FOREIGN KEY (utilisateurs_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98CF0F0BA17 FOREIGN KEY (id_moy_trans) REFERENCES moydetran (id_moy_trans)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plan DROP FOREIGN KEY FK_DD5A5B7DD725330D');
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98CF0F0BA17');
        $this->addSql('ALTER TABLE agence DROP FOREIGN KEY FK_64C19AA9A6E44244');
        $this->addSql('ALTER TABLE plan DROP FOREIGN KEY FK_DD5A5B7DA6E44244');
        $this->addSql('ALTER TABLE plan_res DROP FOREIGN KEY FK_75536115E899029B');
        $this->addSql('ALTER TABLE plan_res DROP FOREIGN KEY FK_75536115A76ED395');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE6064041E969C5');
        $this->addSql('DROP TABLE agence');
        $this->addSql('DROP TABLE chauffeur');
        $this->addSql('DROP TABLE moydetran');
        $this->addSql('DROP TABLE pays');
        $this->addSql('DROP TABLE plan');
        $this->addSql('DROP TABLE plan_res');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE trajet');
        $this->addSql('DROP TABLE utilisateur');
    }
}
