<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181217090904 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Auth CHANGE last_modified_date last_modified_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Company CHANGE name name VARCHAR(255) NOT NULL, CHANGE company_code company_code VARCHAR(255) NOT NULL, CHANGE created_date created_date DATETIME NOT NULL, CHANGE last_modified_date last_modified_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE Vendor ADD vendor_id VARCHAR(255) DEFAULT NULL, CHANGE phone phone INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Auth CHANGE last_modified_date last_modified_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE Company CHANGE name name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE company_code company_code VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE created_date created_date DATETIME DEFAULT NULL, CHANGE last_modified_date last_modified_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Vendor DROP vendor_id, CHANGE phone phone VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
