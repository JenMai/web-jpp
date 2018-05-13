<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180407120819 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_83184DC48CDE5729');
        $this->addSql('DROP INDEX UNIQ_83184DC4A4D60759');
        $this->addSql('CREATE TEMPORARY TABLE __temp__app_attraction AS SELECT id, type, libelle, taillemini, age, description, image FROM app_attraction');
        $this->addSql('DROP TABLE app_attraction');
        $this->addSql('CREATE TABLE app_attraction (id INTEGER NOT NULL, type_id INTEGER DEFAULT NULL, libelle VARCHAR(65) NOT NULL COLLATE BINARY, taillemini DOUBLE PRECISION NOT NULL, age INTEGER NOT NULL, description CLOB NOT NULL COLLATE BINARY, image VARCHAR(255) NOT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_83184DC4C54C8C93 FOREIGN KEY (type_id) REFERENCES type_attraction (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO app_attraction (id, type_id, libelle, taillemini, age, description, image) SELECT id, type, libelle, taillemini, age, description, image FROM __temp__app_attraction');
        $this->addSql('DROP TABLE __temp__app_attraction');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_83184DC4A4D60759 ON app_attraction (libelle)');
        $this->addSql('CREATE INDEX IDX_83184DC4C54C8C93 ON app_attraction (type_id)');
        $this->addSql('DROP INDEX IDX_D580D314C54C8C93');
        $this->addSql('DROP INDEX UNIQ_D580D314A4D60759');
        $this->addSql('CREATE TEMPORARY TABLE __temp__app_hotel AS SELECT id, type_id, libelle, etoiles, prix, description, image FROM app_hotel');
        $this->addSql('DROP TABLE app_hotel');
        $this->addSql('CREATE TABLE app_hotel (id INTEGER NOT NULL, type_id INTEGER DEFAULT NULL, libelle VARCHAR(65) NOT NULL COLLATE BINARY, etoiles INTEGER NOT NULL, prix DOUBLE PRECISION NOT NULL, description CLOB NOT NULL COLLATE BINARY, image VARCHAR(255) NOT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_D580D314C54C8C93 FOREIGN KEY (type_id) REFERENCES type_hotel (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO app_hotel (id, type_id, libelle, etoiles, prix, description, image) SELECT id, type_id, libelle, etoiles, prix, description, image FROM __temp__app_hotel');
        $this->addSql('DROP TABLE __temp__app_hotel');
        $this->addSql('CREATE INDEX IDX_D580D314C54C8C93 ON app_hotel (type_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D580D314A4D60759 ON app_hotel (libelle)');
        $this->addSql('DROP INDEX IDX_BD8EB943C54C8C93');
        $this->addSql('DROP INDEX UNIQ_BD8EB943A4D60759');
        $this->addSql('CREATE TEMPORARY TABLE __temp__app_restaurant AS SELECT id, type_id, libelle, vege, description, image FROM app_restaurant');
        $this->addSql('DROP TABLE app_restaurant');
        $this->addSql('CREATE TABLE app_restaurant (id INTEGER NOT NULL, type_id INTEGER DEFAULT NULL, libelle VARCHAR(65) NOT NULL COLLATE BINARY, vege BOOLEAN NOT NULL, description CLOB NOT NULL COLLATE BINARY, image VARCHAR(255) NOT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_BD8EB943C54C8C93 FOREIGN KEY (type_id) REFERENCES type_restaurant (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO app_restaurant (id, type_id, libelle, vege, description, image) SELECT id, type_id, libelle, vege, description, image FROM __temp__app_restaurant');
        $this->addSql('DROP TABLE __temp__app_restaurant');
        $this->addSql('CREATE INDEX IDX_BD8EB943C54C8C93 ON app_restaurant (type_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BD8EB943A4D60759 ON app_restaurant (libelle)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_83184DC4A4D60759');
        $this->addSql('DROP INDEX IDX_83184DC4C54C8C93');
        $this->addSql('CREATE TEMPORARY TABLE __temp__app_attraction AS SELECT id, type_id, libelle, taillemini, age, description, image FROM app_attraction');
        $this->addSql('DROP TABLE app_attraction');
        $this->addSql('CREATE TABLE app_attraction (id INTEGER NOT NULL, libelle VARCHAR(65) NOT NULL, taillemini DOUBLE PRECISION NOT NULL, age INTEGER NOT NULL, description CLOB NOT NULL, image VARCHAR(255) NOT NULL, type INTEGER DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO app_attraction (id, type, libelle, taillemini, age, description, image) SELECT id, type_id, libelle, taillemini, age, description, image FROM __temp__app_attraction');
        $this->addSql('DROP TABLE __temp__app_attraction');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_83184DC4A4D60759 ON app_attraction (libelle)');
        $this->addSql('CREATE INDEX IDX_83184DC48CDE5729 ON app_attraction (type)');
        $this->addSql('DROP INDEX UNIQ_D580D314A4D60759');
        $this->addSql('DROP INDEX IDX_D580D314C54C8C93');
        $this->addSql('CREATE TEMPORARY TABLE __temp__app_hotel AS SELECT id, type_id, libelle, etoiles, prix, description, image FROM app_hotel');
        $this->addSql('DROP TABLE app_hotel');
        $this->addSql('CREATE TABLE app_hotel (id INTEGER NOT NULL, type_id INTEGER DEFAULT NULL, libelle VARCHAR(65) NOT NULL, etoiles INTEGER NOT NULL, prix DOUBLE PRECISION NOT NULL, description CLOB NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO app_hotel (id, type_id, libelle, etoiles, prix, description, image) SELECT id, type_id, libelle, etoiles, prix, description, image FROM __temp__app_hotel');
        $this->addSql('DROP TABLE __temp__app_hotel');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D580D314A4D60759 ON app_hotel (libelle)');
        $this->addSql('CREATE INDEX IDX_D580D314C54C8C93 ON app_hotel (type_id)');
        $this->addSql('DROP INDEX UNIQ_BD8EB943A4D60759');
        $this->addSql('DROP INDEX IDX_BD8EB943C54C8C93');
        $this->addSql('CREATE TEMPORARY TABLE __temp__app_restaurant AS SELECT id, type_id, libelle, vege, description, image FROM app_restaurant');
        $this->addSql('DROP TABLE app_restaurant');
        $this->addSql('CREATE TABLE app_restaurant (id INTEGER NOT NULL, type_id INTEGER DEFAULT NULL, libelle VARCHAR(65) NOT NULL, vege BOOLEAN NOT NULL, description CLOB NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO app_restaurant (id, type_id, libelle, vege, description, image) SELECT id, type_id, libelle, vege, description, image FROM __temp__app_restaurant');
        $this->addSql('DROP TABLE __temp__app_restaurant');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BD8EB943A4D60759 ON app_restaurant (libelle)');
        $this->addSql('CREATE INDEX IDX_BD8EB943C54C8C93 ON app_restaurant (type_id)');
    }
}
