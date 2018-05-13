<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180401130917 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE type_hotel (id INTEGER NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE type_attraction (id INTEGER NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE app_attraction (id INTEGER NOT NULL, type_id INTEGER DEFAULT NULL, libelle VARCHAR(65) NOT NULL, taillemini DOUBLE PRECISION NOT NULL, age INTEGER NOT NULL, description CLOB NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_83184DC4A4D60759 ON app_attraction (libelle)');
        $this->addSql('CREATE INDEX IDX_83184DC4C54C8C93 ON app_attraction (type_id)');
        $this->addSql('CREATE TABLE app_hotel (id INTEGER NOT NULL, type_id INTEGER DEFAULT NULL, libelle VARCHAR(65) NOT NULL, etoiles INTEGER NOT NULL, prix DOUBLE PRECISION NOT NULL, description CLOB NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D580D314A4D60759 ON app_hotel (libelle)');
        $this->addSql('CREATE INDEX IDX_D580D314C54C8C93 ON app_hotel (type_id)');
        $this->addSql('CREATE TABLE app_users (id INTEGER NOT NULL, username VARCHAR(25) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(80) NOT NULL, number_of_children INTEGER NOT NULL, country INTEGER NOT NULL, roles VARCHAR(20) NOT NULL, is_active BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C2502824F85E0677 ON app_users (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C2502824E7927C74 ON app_users (email)');
        $this->addSql('CREATE TABLE type_restaurant (id INTEGER NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE app_restaurant (id INTEGER NOT NULL, type_id INTEGER DEFAULT NULL, libelle VARCHAR(65) NOT NULL, vege BOOLEAN NOT NULL, description CLOB NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BD8EB943A4D60759 ON app_restaurant (libelle)');
        $this->addSql('CREATE INDEX IDX_BD8EB943C54C8C93 ON app_restaurant (type_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE type_hotel');
        $this->addSql('DROP TABLE type_attraction');
        $this->addSql('DROP TABLE app_attraction');
        $this->addSql('DROP TABLE app_hotel');
        $this->addSql('DROP TABLE app_users');
        $this->addSql('DROP TABLE type_restaurant');
        $this->addSql('DROP TABLE app_restaurant');
    }
}
