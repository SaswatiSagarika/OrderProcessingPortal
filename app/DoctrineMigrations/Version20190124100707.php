<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190124100707 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE User (id INT AUTO_INCREMENT NOT NULL, status_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, last VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, otp VARCHAR(20) DEFAULT NULL, role VARCHAR(20) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, password VARCHAR(50) NOT NULL, employee_id VARCHAR(200) DEFAULT NULL, last_update_date_time DATETIME NOT NULL, created_date_time DATETIME NOT NULL, INDEX IDX_2DA179776BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VendorPurchaseOrder (id INT AUTO_INCREMENT NOT NULL, vendor_id INT NOT NULL, account_id INT NOT NULL, sales_term_id INT NOT NULL, currency_id INT NOT NULL, VendorPurchaseOrder_id INT NOT NULL, qb_VendorPO_id INT NOT NULL, total_amt VARCHAR(45) NOT NULL, notes VARCHAR(45) NOT NULL, due_date DATETIME NOT NULL, VendorPurchaseOrder_status VARCHAR(45) NOT NULL, exchange_rate VARCHAR(45) NOT NULL, created_date DATETIME NOT NULL, last_modified_date DATETIME NOT NULL, INDEX IDX_7DDD2A74F603EE73 (vendor_id), INDEX IDX_7DDD2A749B6B5FBA (account_id), INDEX IDX_7DDD2A74D5499C (sales_term_id), INDEX IDX_7DDD2A7438248176 (currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE User ADD CONSTRAINT FK_2DA179776BF700BD FOREIGN KEY (status_id) REFERENCES Status (id)');
       
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

       
        $this->addSql('DROP TABLE User');
       
    }
}
