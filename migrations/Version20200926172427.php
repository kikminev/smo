<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200926172427 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE business_unit (id INT AUTO_INCREMENT NOT NULL, account_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_8C200E5E9B6B5FBA (account_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE business_unit ADD CONSTRAINT FK_8C200E5E9B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E099B6B5FBA');
        $this->addSql('DROP INDEX IDX_81398E099B6B5FBA ON customer');
        $this->addSql('ALTER TABLE customer CHANGE account_id business_unit_id INT NOT NULL');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09A58ECB40 FOREIGN KEY (business_unit_id) REFERENCES business_unit (id)');
        $this->addSql('CREATE INDEX IDX_81398E09A58ECB40 ON customer (business_unit_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09A58ECB40');
        $this->addSql('DROP TABLE business_unit');
        $this->addSql('DROP INDEX IDX_81398E09A58ECB40 ON customer');
        $this->addSql('ALTER TABLE customer CHANGE business_unit_id account_id INT NOT NULL');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E099B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_81398E099B6B5FBA ON customer (account_id)');
    }
}
