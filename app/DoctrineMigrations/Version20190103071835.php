<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190103071835 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Invoice (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, account_id INT NOT NULL, sales_term_id INT NOT NULL, currency_id INT NOT NULL, invoice_id INT NOT NULL, qb_invoice_id INT NOT NULL, total_amt VARCHAR(45) NOT NULL, notes VARCHAR(45) NOT NULL, due_date DATETIME NOT NULL, invoice_status VARCHAR(45) NOT NULL, exchange_rate VARCHAR(45) NOT NULL, created_date DATETIME NOT NULL, last_modified_date DATETIME NOT NULL, INDEX IDX_5FD82ED89395C3F3 (customer_id), INDEX IDX_5FD82ED89B6B5FBA (account_id), INDEX IDX_5FD82ED8D5499C (sales_term_id), INDEX IDX_5FD82ED838248176 (currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Invoice ADD CONSTRAINT FK_5FD82ED89395C3F3 FOREIGN KEY (customer_id) REFERENCES Customer (id)');
        $this->addSql('ALTER TABLE Invoice ADD CONSTRAINT FK_5FD82ED89B6B5FBA FOREIGN KEY (account_id) REFERENCES Account (id)');
        $this->addSql('ALTER TABLE Invoice ADD CONSTRAINT FK_5FD82ED8D5499C FOREIGN KEY (sales_term_id) REFERENCES Term (id)');
        $this->addSql('ALTER TABLE Invoice ADD CONSTRAINT FK_5FD82ED838248176 FOREIGN KEY (currency_id) REFERENCES CompanyCurrency (id)');
        $this->addSql('ALTER TABLE PurchaseOrder DROP FOREIGN KEY FK_AA004F119395C3F3');
        $this->addSql('DROP INDEX IDX_AA004F119395C3F3 ON PurchaseOrder');
        $this->addSql('ALTER TABLE PurchaseOrder CHANGE customer_id vendor_id INT NOT NULL');
        $this->addSql('ALTER TABLE PurchaseOrder ADD CONSTRAINT FK_AA004F11F603EE73 FOREIGN KEY (vendor_id) REFERENCES Vendor (id)');
        $this->addSql('CREATE INDEX IDX_AA004F11F603EE73 ON PurchaseOrder (vendor_id)');
        $this->addSql('ALTER TABLE Customer DROP FOREIGN KEY Customer_ibfk_1');
        $this->addSql('ALTER TABLE Customer DROP FOREIGN KEY Customer_ibfk_2');
        $this->addSql('ALTER TABLE Customer DROP FOREIGN KEY Customer_ibfk_3');
        $this->addSql('ALTER TABLE Customer ADD CONSTRAINT FK_784FEC5F979B1AD6 FOREIGN KEY (company_id) REFERENCES Company (id)');
        $this->addSql('ALTER TABLE Customer ADD CONSTRAINT FK_784FEC5F6BF700BD FOREIGN KEY (status_id) REFERENCES Status (id)');
        $this->addSql('ALTER TABLE Customer ADD CONSTRAINT FK_784FEC5F21F539EE FOREIGN KEY (company_currency_id) REFERENCES CompanyCurrency (id)');
        $this->addSql('ALTER TABLE Account CHANGE name name VARCHAR(45) DEFAULT NULL');
        $this->addSql('ALTER TABLE Account ADD CONSTRAINT FK_B28B6F38C6798DB FOREIGN KEY (account_type_id) REFERENCES AccountType (id)');
        $this->addSql('ALTER TABLE Account ADD CONSTRAINT FK_B28B6F3838248176 FOREIGN KEY (currency_id) REFERENCES CompanyCurrency (id)');
        $this->addSql('ALTER TABLE Account ADD CONSTRAINT FK_B28B6F3866925E1D FOREIGN KEY (tax_code_id) REFERENCES TaxCode (id)');
        $this->addSql('ALTER TABLE Account ADD CONSTRAINT FK_B28B6F386BF700BD FOREIGN KEY (status_id) REFERENCES Status (id)');
        $this->addSql('ALTER TABLE Account ADD CONSTRAINT FK_B28B6F38171F97B5 FOREIGN KEY (sub_account_type) REFERENCES SubAccountType (id)');
        $this->addSql('ALTER TABLE Account ADD CONSTRAINT FK_B28B6F382A86559F FOREIGN KEY (classification_id) REFERENCES Classification (id)');
        $this->addSql('ALTER TABLE AccountType DROP FOREIGN KEY AccountType_ibfk_1');
        $this->addSql('ALTER TABLE AccountType DROP FOREIGN KEY AccountType_ibfk_2');
        $this->addSql('ALTER TABLE AccountType ADD CONSTRAINT FK_A7E037642A86559F FOREIGN KEY (classification_id) REFERENCES Classification (id)');
        $this->addSql('ALTER TABLE AccountType ADD CONSTRAINT FK_A7E037646BF700BD FOREIGN KEY (status_id) REFERENCES Status (id)');
        $this->addSql('ALTER TABLE Vendor DROP FOREIGN KEY Vendor_ibfk_1');
        $this->addSql('ALTER TABLE Vendor DROP FOREIGN KEY Vendor_ibfk_2');
        $this->addSql('ALTER TABLE Vendor DROP FOREIGN KEY Vendor_ibfk_3');
        $this->addSql('ALTER TABLE Vendor DROP FOREIGN KEY Vendor_ibfk_4');
        $this->addSql('ALTER TABLE Vendor DROP FOREIGN KEY Vendor_ibfk_5');
        $this->addSql('DROP INDEX IDX_F28E36C066925E1D ON Vendor');
        $this->addSql('ALTER TABLE Vendor DROP tax_code_id, CHANGE phone phone VARCHAR(45) DEFAULT NULL, CHANGE email_address email_address VARCHAR(45) DEFAULT NULL');
        $this->addSql('ALTER TABLE Vendor ADD CONSTRAINT FK_F28E36C0979B1AD6 FOREIGN KEY (company_id) REFERENCES Company (id)');
        $this->addSql('ALTER TABLE Vendor ADD CONSTRAINT FK_F28E36C06BF700BD FOREIGN KEY (status_id) REFERENCES Status (id)');
        $this->addSql('ALTER TABLE Vendor ADD CONSTRAINT FK_F28E36C0E2C35FC FOREIGN KEY (term_id) REFERENCES Term (id)');
        $this->addSql('ALTER TABLE Vendor ADD CONSTRAINT FK_F28E36C021F539EE FOREIGN KEY (company_currency_id) REFERENCES CompanyCurrency (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE Invoice');
        $this->addSql('ALTER TABLE Account DROP FOREIGN KEY FK_B28B6F38C6798DB');
        $this->addSql('ALTER TABLE Account DROP FOREIGN KEY FK_B28B6F3838248176');
        $this->addSql('ALTER TABLE Account DROP FOREIGN KEY FK_B28B6F3866925E1D');
        $this->addSql('ALTER TABLE Account DROP FOREIGN KEY FK_B28B6F386BF700BD');
        $this->addSql('ALTER TABLE Account DROP FOREIGN KEY FK_B28B6F38171F97B5');
        $this->addSql('ALTER TABLE Account DROP FOREIGN KEY FK_B28B6F382A86559F');
        $this->addSql('ALTER TABLE Account CHANGE name name VARCHAR(225) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE AccountType DROP FOREIGN KEY FK_A7E037642A86559F');
        $this->addSql('ALTER TABLE AccountType DROP FOREIGN KEY FK_A7E037646BF700BD');
        $this->addSql('ALTER TABLE AccountType ADD CONSTRAINT AccountType_ibfk_1 FOREIGN KEY (classification_id) REFERENCES Classification (id) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE AccountType ADD CONSTRAINT AccountType_ibfk_2 FOREIGN KEY (status_id) REFERENCES Status (id) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE Customer DROP FOREIGN KEY FK_784FEC5F979B1AD6');
        $this->addSql('ALTER TABLE Customer DROP FOREIGN KEY FK_784FEC5F6BF700BD');
        $this->addSql('ALTER TABLE Customer DROP FOREIGN KEY FK_784FEC5F21F539EE');
        $this->addSql('ALTER TABLE Customer ADD CONSTRAINT Customer_ibfk_1 FOREIGN KEY (company_id) REFERENCES Company (id) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE Customer ADD CONSTRAINT Customer_ibfk_2 FOREIGN KEY (company_currency_id) REFERENCES CompanyCurrency (id) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE Customer ADD CONSTRAINT Customer_ibfk_3 FOREIGN KEY (status_id) REFERENCES Status (id) ON UPDATE CASCADE');
        $this->addSql('ALTER TABLE PurchaseOrder DROP FOREIGN KEY FK_AA004F11F603EE73');
        $this->addSql('DROP INDEX IDX_AA004F11F603EE73 ON PurchaseOrder');
        $this->addSql('ALTER TABLE PurchaseOrder CHANGE vendor_id customer_id INT NOT NULL');
        $this->addSql('ALTER TABLE PurchaseOrder ADD CONSTRAINT FK_AA004F119395C3F3 FOREIGN KEY (customer_id) REFERENCES Customer (id)');
        $this->addSql('CREATE INDEX IDX_AA004F119395C3F3 ON PurchaseOrder (customer_id)');
        $this->addSql('ALTER TABLE Vendor DROP FOREIGN KEY FK_F28E36C0979B1AD6');
        $this->addSql('ALTER TABLE Vendor DROP FOREIGN KEY FK_F28E36C06BF700BD');
        $this->addSql('ALTER TABLE Vendor DROP FOREIGN KEY FK_F28E36C0E2C35FC');
        $this->addSql('ALTER TABLE Vendor DROP FOREIGN KEY FK_F28E36C021F539EE');
        $this->addSql('ALTER TABLE Vendor ADD tax_code_id INT DEFAULT NULL, CHANGE phone phone VARCHAR(20) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE email_address email_address VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE Vendor ADD CONSTRAINT Vendor_ibfk_1 FOREIGN KEY (company_currency_id) REFERENCES CompanyCurrency (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Vendor ADD CONSTRAINT Vendor_ibfk_2 FOREIGN KEY (tax_code_id) REFERENCES TaxCode (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Vendor ADD CONSTRAINT Vendor_ibfk_3 FOREIGN KEY (term_id) REFERENCES Term (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Vendor ADD CONSTRAINT Vendor_ibfk_4 FOREIGN KEY (company_id) REFERENCES Company (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Vendor ADD CONSTRAINT Vendor_ibfk_5 FOREIGN KEY (status_id) REFERENCES Status (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_F28E36C066925E1D ON Vendor (tax_code_id)');
    }
}
