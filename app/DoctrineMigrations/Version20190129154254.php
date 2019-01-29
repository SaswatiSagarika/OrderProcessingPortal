<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190129154254 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE POItems (id INT AUTO_INCREMENT NOT NULL, po_id INT NOT NULL, item_id INT NOT NULL, item_price VARCHAR(45) NOT NULL, quantity INT NOT NULL, status VARCHAR(45) NOT NULL, taxable_amount VARCHAR(45) NOT NULL, created_date DATETIME NOT NULL, last_modified_date DATETIME NOT NULL, INDEX IDX_A64ABF24C5B5ECA5 (po_id), INDEX IDX_A64ABF24126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE TaxCode (id INT AUTO_INCREMENT NOT NULL, status_id INT NOT NULL, name VARCHAR(45) NOT NULL, code VARCHAR(45) NOT NULL, taxable TINYINT(1) NOT NULL, created_date DATETIME NOT NULL, last_modified_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_B69F259177153098 (code), INDEX IDX_B69F25916BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Classification (id INT AUTO_INCREMENT NOT NULL, status_id INT NOT NULL, name VARCHAR(45) DEFAULT NULL, code VARCHAR(45) DEFAULT NULL, created_date DATETIME DEFAULT NULL, last_modified_date DATETIME DEFAULT NULL, INDEX IDX_880FAAE96BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE CompanyCurrency (id INT AUTO_INCREMENT NOT NULL, status_id INT NOT NULL, code VARCHAR(10) DEFAULT NULL, name VARCHAR(45) DEFAULT NULL, sparse VARCHAR(45) DEFAULT NULL, domain VARCHAR(45) DEFAULT NULL, created_date DATETIME DEFAULT NULL, last_modified_date DATETIME DEFAULT NULL, INDEX IDX_4CFF2F5D6BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Product (id INT AUTO_INCREMENT NOT NULL, status_id INT DEFAULT NULL, type_id INT DEFAULT NULL, inventory_assest_account_id INT DEFAULT NULL, item_category_type_id INT DEFAULT NULL, expense_account_id INT DEFAULT NULL, prefered_vendor_id INT DEFAULT NULL, name VARCHAR(45) DEFAULT NULL, sku VARCHAR(10) DEFAULT NULL, description VARCHAR(45) DEFAULT NULL, level VARCHAR(45) DEFAULT NULL, taxable TINYINT(1) DEFAULT NULL, sales_tax_included TINYINT(1) DEFAULT NULL, unit_price VARCHAR(45) DEFAULT NULL, image VARCHAR(60) DEFAULT NULL, created_date DATETIME DEFAULT NULL, last_updated_time DATETIME DEFAULT NULL, quantity_on_hand INT DEFAULT NULL, reorder_point INT DEFAULT NULL, sales_information VARCHAR(45) DEFAULT NULL, purchasing_information VARCHAR(45) DEFAULT NULL, product INT DEFAULT NULL, UNIQUE INDEX UNIQ_1CF73D31F9038C4 (sku), INDEX IDX_1CF73D316BF700BD (status_id), INDEX IDX_1CF73D31C54C8C93 (type_id), INDEX IDX_1CF73D319C706823 (inventory_assest_account_id), INDEX IDX_1CF73D313AF6CFF2 (item_category_type_id), INDEX IDX_1CF73D312B7F60B3 (expense_account_id), INDEX IDX_1CF73D31E7183500 (prefered_vendor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE PurchaseOrder (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, account_id INT NOT NULL, sales_term_id INT NOT NULL, currency_id INT NOT NULL, po_id INT NOT NULL, QB_id INT NOT NULL, total_amt VARCHAR(45) NOT NULL, notes VARCHAR(45) NOT NULL, due_date DATETIME NOT NULL, po_status VARCHAR(45) NOT NULL, created_date DATETIME NOT NULL, last_modified_date DATETIME NOT NULL, INDEX IDX_AA004F119395C3F3 (customer_id), INDEX IDX_AA004F119B6B5FBA (account_id), INDEX IDX_AA004F11D5499C (sales_term_id), INDEX IDX_AA004F1138248176 (currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE User (id INT AUTO_INCREMENT NOT NULL, status_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, last VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, otp VARCHAR(20) DEFAULT NULL, role VARCHAR(20) DEFAULT NULL, is_verified TINYINT(1) NOT NULL, password VARCHAR(50) NOT NULL, employee_id VARCHAR(200) DEFAULT NULL, last_update_date_time DATETIME DEFAULT NULL, created_date_time DATETIME DEFAULT NULL, INDEX IDX_2DA179776BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE VendorPurchaseOrder (id INT AUTO_INCREMENT NOT NULL, vendor_id INT NOT NULL, account_id INT NOT NULL, sales_term_id INT NOT NULL, currency_id INT NOT NULL, VendorPurchaseOrder_id INT NOT NULL, qb_VendorPO_id INT NOT NULL, total_amt VARCHAR(45) NOT NULL, notes VARCHAR(45) NOT NULL, due_date DATETIME NOT NULL, VendorPurchaseOrder_status VARCHAR(45) NOT NULL, exchange_rate VARCHAR(45) NOT NULL, created_date DATETIME NOT NULL, last_modified_date DATETIME NOT NULL, INDEX IDX_7DDD2A74F603EE73 (vendor_id), INDEX IDX_7DDD2A749B6B5FBA (account_id), INDEX IDX_7DDD2A74D5499C (sales_term_id), INDEX IDX_7DDD2A7438248176 (currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE SubAccountType (id INT AUTO_INCREMENT NOT NULL, classification_id INT DEFAULT NULL, account_type_id INT DEFAULT NULL, status_id INT DEFAULT NULL, name VARCHAR(45) DEFAULT NULL, description VARCHAR(45) DEFAULT NULL, created_date DATETIME DEFAULT NULL, last_modified_date DATETIME DEFAULT NULL, INDEX IDX_25042C092A86559F (classification_id), INDEX IDX_25042C09C6798DB (account_type_id), INDEX IDX_25042C096BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Auth (id INT AUTO_INCREMENT NOT NULL, access_token VARCHAR(1000) NOT NULL, realm_id VARCHAR(55) NOT NULL, refresh_token VARCHAR(55) NOT NULL, created_date DATETIME DEFAULT NULL, last_modified_date DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_58EC1F679DFF5F89 (realm_id), UNIQUE INDEX UNIQ_58EC1F67C74F2195 (refresh_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Status (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(45) NOT NULL, name VARCHAR(45) NOT NULL, created_date DATETIME NOT NULL, last_modified_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Term (id INT AUTO_INCREMENT NOT NULL, status_id INT NOT NULL, name VARCHAR(45) DEFAULT NULL, duedate DATETIME DEFAULT NULL, type VARCHAR(45) DEFAULT NULL, domain VARCHAR(45) DEFAULT NULL, sparse VARCHAR(45) DEFAULT NULL, discount_day VARCHAR(45) DEFAULT NULL, created_date DATETIME NOT NULL, last_updated_time DATETIME NOT NULL, INDEX IDX_53D48B36BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Type (id INT AUTO_INCREMENT NOT NULL, status_id INT DEFAULT NULL, code VARCHAR(45) DEFAULT NULL, description VARCHAR(45) DEFAULT NULL, created_date DATETIME NOT NULL, last_updated_time DATETIME DEFAULT NULL, INDEX IDX_2CECF8176BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Customer (id INT AUTO_INCREMENT NOT NULL, company_id INT DEFAULT NULL, status_id INT DEFAULT NULL, company_currency_id INT DEFAULT NULL, name VARCHAR(45) DEFAULT NULL, phone VARCHAR(45) DEFAULT NULL, email_address VARCHAR(45) DEFAULT NULL, web_address VARCHAR(45) DEFAULT NULL, balance_with_jobs VARCHAR(45) DEFAULT NULL, balance DOUBLE PRECISION DEFAULT NULL, preferred_delivery_method VARCHAR(45) DEFAULT NULL, print_on_check_name VARCHAR(45) DEFAULT NULL, line1 VARCHAR(45) DEFAULT NULL, line2 VARCHAR(45) DEFAULT NULL, line3 VARCHAR(45) DEFAULT NULL, city VARCHAR(45) DEFAULT NULL, country_sub_division_code VARCHAR(45) DEFAULT NULL, postal_code VARCHAR(45) DEFAULT NULL, country VARCHAR(45) DEFAULT NULL, latitude VARCHAR(45) DEFAULT NULL, customer_id VARCHAR(55) NOT NULL, logitude VARCHAR(45) DEFAULT NULL, created_date DATETIME DEFAULT NULL, last_updated_time DATETIME DEFAULT NULL, INDEX IDX_784FEC5F979B1AD6 (company_id), INDEX IDX_784FEC5F6BF700BD (status_id), INDEX IDX_784FEC5F21F539EE (company_currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ItemCategoryType (id INT AUTO_INCREMENT NOT NULL, status_id INT NOT NULL, name VARCHAR(45) DEFAULT NULL, type VARCHAR(45) DEFAULT NULL, created_date DATETIME DEFAULT NULL, last_modified_date DATETIME DEFAULT NULL, INDEX IDX_F59E06FA6BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Account (id INT AUTO_INCREMENT NOT NULL, account_type_id INT DEFAULT NULL, currency_id INT DEFAULT NULL, tax_code_id INT DEFAULT NULL, status_id INT DEFAULT NULL, sub_account_type INT DEFAULT NULL, classification_id INT DEFAULT NULL, name VARCHAR(45) DEFAULT NULL, description VARCHAR(45) DEFAULT NULL, account_number VARCHAR(45) DEFAULT NULL, account_id VARCHAR(45) NOT NULL, credit_balance VARCHAR(45) DEFAULT NULL, sub_account VARCHAR(45) DEFAULT NULL, sparse VARCHAR(45) DEFAULT NULL, domain VARCHAR(45) DEFAULT NULL, created_date DATETIME DEFAULT NULL, last_updated_time DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_B28B6F38B1A4D127 (account_number), UNIQUE INDEX UNIQ_B28B6F389B6B5FBA (account_id), INDEX IDX_B28B6F38C6798DB (account_type_id), INDEX IDX_B28B6F3838248176 (currency_id), INDEX IDX_B28B6F3866925E1D (tax_code_id), INDEX IDX_B28B6F386BF700BD (status_id), INDEX IDX_B28B6F38171F97B5 (sub_account_type), INDEX IDX_B28B6F382A86559F (classification_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE AccountType (id INT AUTO_INCREMENT NOT NULL, classification_id INT DEFAULT NULL, status_id INT DEFAULT NULL, name VARCHAR(45) DEFAULT NULL, code VARCHAR(45) DEFAULT NULL, created_date DATETIME DEFAULT NULL, last_modified_date DATETIME DEFAULT NULL, INDEX IDX_A7E037642A86559F (classification_id), INDEX IDX_A7E037646BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) DEFAULT NULL, company_code VARCHAR(45) DEFAULT NULL, created_date DATETIME DEFAULT NULL, last_modified_date DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_800230D334782A76 (company_code), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Vendor (id INT AUTO_INCREMENT NOT NULL, company_id INT DEFAULT NULL, status_id INT DEFAULT NULL, term_id INT DEFAULT NULL, company_currency_id INT DEFAULT NULL, name VARCHAR(45) DEFAULT NULL, phone VARCHAR(45) DEFAULT NULL, email_address VARCHAR(45) DEFAULT NULL, web_address VARCHAR(45) DEFAULT NULL, balance DOUBLE PRECISION DEFAULT NULL, account_number VARCHAR(45) DEFAULT NULL, vendor1099 TINYINT(1) DEFAULT NULL, line1 VARCHAR(45) DEFAULT NULL, line2 VARCHAR(45) DEFAULT NULL, line3 VARCHAR(45) DEFAULT NULL, city VARCHAR(45) DEFAULT NULL, country_sub_division_code VARCHAR(45) DEFAULT NULL, postal_code VARCHAR(45) DEFAULT NULL, country VARCHAR(45) DEFAULT NULL, latitude VARCHAR(45) DEFAULT NULL, vendor_id VARCHAR(45) NOT NULL, logitude VARCHAR(45) DEFAULT NULL, created_date DATETIME DEFAULT NULL, last_updated_time DATETIME DEFAULT NULL, INDEX IDX_F28E36C0979B1AD6 (company_id), INDEX IDX_F28E36C06BF700BD (status_id), INDEX IDX_F28E36C0E2C35FC (term_id), INDEX IDX_F28E36C021F539EE (company_currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE POItems ADD CONSTRAINT FK_A64ABF24C5B5ECA5 FOREIGN KEY (po_id) REFERENCES PurchaseOrder (id)');
        $this->addSql('ALTER TABLE POItems ADD CONSTRAINT FK_A64ABF24126F525E FOREIGN KEY (item_id) REFERENCES Product (id)');
        $this->addSql('ALTER TABLE TaxCode ADD CONSTRAINT FK_B69F25916BF700BD FOREIGN KEY (status_id) REFERENCES Status (id)');
        $this->addSql('ALTER TABLE Classification ADD CONSTRAINT FK_880FAAE96BF700BD FOREIGN KEY (status_id) REFERENCES Status (id)');
        $this->addSql('ALTER TABLE CompanyCurrency ADD CONSTRAINT FK_4CFF2F5D6BF700BD FOREIGN KEY (status_id) REFERENCES Status (id)');
        $this->addSql('ALTER TABLE Product ADD CONSTRAINT FK_1CF73D316BF700BD FOREIGN KEY (status_id) REFERENCES Status (id)');
        $this->addSql('ALTER TABLE Product ADD CONSTRAINT FK_1CF73D31C54C8C93 FOREIGN KEY (type_id) REFERENCES Type (id)');
        $this->addSql('ALTER TABLE Product ADD CONSTRAINT FK_1CF73D319C706823 FOREIGN KEY (inventory_assest_account_id) REFERENCES Account (id)');
        $this->addSql('ALTER TABLE Product ADD CONSTRAINT FK_1CF73D313AF6CFF2 FOREIGN KEY (item_category_type_id) REFERENCES ItemCategoryType (id)');
        $this->addSql('ALTER TABLE Product ADD CONSTRAINT FK_1CF73D312B7F60B3 FOREIGN KEY (expense_account_id) REFERENCES Account (id)');
        $this->addSql('ALTER TABLE Product ADD CONSTRAINT FK_1CF73D31E7183500 FOREIGN KEY (prefered_vendor_id) REFERENCES Vendor (id)');
        $this->addSql('ALTER TABLE PurchaseOrder ADD CONSTRAINT FK_AA004F119395C3F3 FOREIGN KEY (customer_id) REFERENCES Customer (id)');
        $this->addSql('ALTER TABLE PurchaseOrder ADD CONSTRAINT FK_AA004F119B6B5FBA FOREIGN KEY (account_id) REFERENCES Account (id)');
        $this->addSql('ALTER TABLE PurchaseOrder ADD CONSTRAINT FK_AA004F11D5499C FOREIGN KEY (sales_term_id) REFERENCES Term (id)');
        $this->addSql('ALTER TABLE PurchaseOrder ADD CONSTRAINT FK_AA004F1138248176 FOREIGN KEY (currency_id) REFERENCES CompanyCurrency (id)');
        $this->addSql('ALTER TABLE User ADD CONSTRAINT FK_2DA179776BF700BD FOREIGN KEY (status_id) REFERENCES Status (id)');
        $this->addSql('ALTER TABLE VendorPurchaseOrder ADD CONSTRAINT FK_7DDD2A74F603EE73 FOREIGN KEY (vendor_id) REFERENCES Vendor (id)');
        $this->addSql('ALTER TABLE VendorPurchaseOrder ADD CONSTRAINT FK_7DDD2A749B6B5FBA FOREIGN KEY (account_id) REFERENCES Account (id)');
        $this->addSql('ALTER TABLE VendorPurchaseOrder ADD CONSTRAINT FK_7DDD2A74D5499C FOREIGN KEY (sales_term_id) REFERENCES Term (id)');
        $this->addSql('ALTER TABLE VendorPurchaseOrder ADD CONSTRAINT FK_7DDD2A7438248176 FOREIGN KEY (currency_id) REFERENCES CompanyCurrency (id)');
        $this->addSql('ALTER TABLE SubAccountType ADD CONSTRAINT FK_25042C092A86559F FOREIGN KEY (classification_id) REFERENCES Classification (id)');
        $this->addSql('ALTER TABLE SubAccountType ADD CONSTRAINT FK_25042C09C6798DB FOREIGN KEY (account_type_id) REFERENCES AccountType (id)');
        $this->addSql('ALTER TABLE SubAccountType ADD CONSTRAINT FK_25042C096BF700BD FOREIGN KEY (status_id) REFERENCES Status (id)');
        $this->addSql('ALTER TABLE Term ADD CONSTRAINT FK_53D48B36BF700BD FOREIGN KEY (status_id) REFERENCES Status (id)');
        $this->addSql('ALTER TABLE Type ADD CONSTRAINT FK_2CECF8176BF700BD FOREIGN KEY (status_id) REFERENCES Status (id)');
        $this->addSql('ALTER TABLE Customer ADD CONSTRAINT FK_784FEC5F979B1AD6 FOREIGN KEY (company_id) REFERENCES Company (id)');
        $this->addSql('ALTER TABLE Customer ADD CONSTRAINT FK_784FEC5F6BF700BD FOREIGN KEY (status_id) REFERENCES Status (id)');
        $this->addSql('ALTER TABLE Customer ADD CONSTRAINT FK_784FEC5F21F539EE FOREIGN KEY (company_currency_id) REFERENCES CompanyCurrency (id)');
        $this->addSql('ALTER TABLE ItemCategoryType ADD CONSTRAINT FK_F59E06FA6BF700BD FOREIGN KEY (status_id) REFERENCES Status (id)');
        $this->addSql('ALTER TABLE Account ADD CONSTRAINT FK_B28B6F38C6798DB FOREIGN KEY (account_type_id) REFERENCES AccountType (id)');
        $this->addSql('ALTER TABLE Account ADD CONSTRAINT FK_B28B6F3838248176 FOREIGN KEY (currency_id) REFERENCES CompanyCurrency (id)');
        $this->addSql('ALTER TABLE Account ADD CONSTRAINT FK_B28B6F3866925E1D FOREIGN KEY (tax_code_id) REFERENCES TaxCode (id)');
        $this->addSql('ALTER TABLE Account ADD CONSTRAINT FK_B28B6F386BF700BD FOREIGN KEY (status_id) REFERENCES Status (id)');
        $this->addSql('ALTER TABLE Account ADD CONSTRAINT FK_B28B6F38171F97B5 FOREIGN KEY (sub_account_type) REFERENCES SubAccountType (id)');
        $this->addSql('ALTER TABLE Account ADD CONSTRAINT FK_B28B6F382A86559F FOREIGN KEY (classification_id) REFERENCES Classification (id)');
        $this->addSql('ALTER TABLE AccountType ADD CONSTRAINT FK_A7E037642A86559F FOREIGN KEY (classification_id) REFERENCES Classification (id)');
        $this->addSql('ALTER TABLE AccountType ADD CONSTRAINT FK_A7E037646BF700BD FOREIGN KEY (status_id) REFERENCES Status (id)');
        $this->addSql('ALTER TABLE Vendor ADD CONSTRAINT FK_F28E36C0979B1AD6 FOREIGN KEY (company_id) REFERENCES Company (id)');
        $this->addSql('ALTER TABLE Vendor ADD CONSTRAINT FK_F28E36C06BF700BD FOREIGN KEY (status_id) REFERENCES Status (id)');
        $this->addSql('ALTER TABLE Vendor ADD CONSTRAINT FK_F28E36C0E2C35FC FOREIGN KEY (term_id) REFERENCES Term (id)');
        $this->addSql('ALTER TABLE Vendor ADD CONSTRAINT FK_F28E36C021F539EE FOREIGN KEY (company_currency_id) REFERENCES CompanyCurrency (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Account DROP FOREIGN KEY FK_B28B6F3866925E1D');
        $this->addSql('ALTER TABLE SubAccountType DROP FOREIGN KEY FK_25042C092A86559F');
        $this->addSql('ALTER TABLE Account DROP FOREIGN KEY FK_B28B6F382A86559F');
        $this->addSql('ALTER TABLE AccountType DROP FOREIGN KEY FK_A7E037642A86559F');
        $this->addSql('ALTER TABLE PurchaseOrder DROP FOREIGN KEY FK_AA004F1138248176');
        $this->addSql('ALTER TABLE VendorPurchaseOrder DROP FOREIGN KEY FK_7DDD2A7438248176');
        $this->addSql('ALTER TABLE Customer DROP FOREIGN KEY FK_784FEC5F21F539EE');
        $this->addSql('ALTER TABLE Account DROP FOREIGN KEY FK_B28B6F3838248176');
        $this->addSql('ALTER TABLE Vendor DROP FOREIGN KEY FK_F28E36C021F539EE');
        $this->addSql('ALTER TABLE POItems DROP FOREIGN KEY FK_A64ABF24126F525E');
        $this->addSql('ALTER TABLE POItems DROP FOREIGN KEY FK_A64ABF24C5B5ECA5');
        $this->addSql('ALTER TABLE Account DROP FOREIGN KEY FK_B28B6F38171F97B5');
        $this->addSql('ALTER TABLE TaxCode DROP FOREIGN KEY FK_B69F25916BF700BD');
        $this->addSql('ALTER TABLE Classification DROP FOREIGN KEY FK_880FAAE96BF700BD');
        $this->addSql('ALTER TABLE CompanyCurrency DROP FOREIGN KEY FK_4CFF2F5D6BF700BD');
        $this->addSql('ALTER TABLE Product DROP FOREIGN KEY FK_1CF73D316BF700BD');
        $this->addSql('ALTER TABLE User DROP FOREIGN KEY FK_2DA179776BF700BD');
        $this->addSql('ALTER TABLE SubAccountType DROP FOREIGN KEY FK_25042C096BF700BD');
        $this->addSql('ALTER TABLE Term DROP FOREIGN KEY FK_53D48B36BF700BD');
        $this->addSql('ALTER TABLE Type DROP FOREIGN KEY FK_2CECF8176BF700BD');
        $this->addSql('ALTER TABLE Customer DROP FOREIGN KEY FK_784FEC5F6BF700BD');
        $this->addSql('ALTER TABLE ItemCategoryType DROP FOREIGN KEY FK_F59E06FA6BF700BD');
        $this->addSql('ALTER TABLE Account DROP FOREIGN KEY FK_B28B6F386BF700BD');
        $this->addSql('ALTER TABLE AccountType DROP FOREIGN KEY FK_A7E037646BF700BD');
        $this->addSql('ALTER TABLE Vendor DROP FOREIGN KEY FK_F28E36C06BF700BD');
        $this->addSql('ALTER TABLE PurchaseOrder DROP FOREIGN KEY FK_AA004F11D5499C');
        $this->addSql('ALTER TABLE VendorPurchaseOrder DROP FOREIGN KEY FK_7DDD2A74D5499C');
        $this->addSql('ALTER TABLE Vendor DROP FOREIGN KEY FK_F28E36C0E2C35FC');
        $this->addSql('ALTER TABLE Product DROP FOREIGN KEY FK_1CF73D31C54C8C93');
        $this->addSql('ALTER TABLE PurchaseOrder DROP FOREIGN KEY FK_AA004F119395C3F3');
        $this->addSql('ALTER TABLE Product DROP FOREIGN KEY FK_1CF73D313AF6CFF2');
        $this->addSql('ALTER TABLE Product DROP FOREIGN KEY FK_1CF73D319C706823');
        $this->addSql('ALTER TABLE Product DROP FOREIGN KEY FK_1CF73D312B7F60B3');
        $this->addSql('ALTER TABLE PurchaseOrder DROP FOREIGN KEY FK_AA004F119B6B5FBA');
        $this->addSql('ALTER TABLE VendorPurchaseOrder DROP FOREIGN KEY FK_7DDD2A749B6B5FBA');
        $this->addSql('ALTER TABLE SubAccountType DROP FOREIGN KEY FK_25042C09C6798DB');
        $this->addSql('ALTER TABLE Account DROP FOREIGN KEY FK_B28B6F38C6798DB');
        $this->addSql('ALTER TABLE Customer DROP FOREIGN KEY FK_784FEC5F979B1AD6');
        $this->addSql('ALTER TABLE Vendor DROP FOREIGN KEY FK_F28E36C0979B1AD6');
        $this->addSql('ALTER TABLE Product DROP FOREIGN KEY FK_1CF73D31E7183500');
        $this->addSql('ALTER TABLE VendorPurchaseOrder DROP FOREIGN KEY FK_7DDD2A74F603EE73');
        $this->addSql('DROP TABLE POItems');
        $this->addSql('DROP TABLE TaxCode');
        $this->addSql('DROP TABLE Classification');
        $this->addSql('DROP TABLE CompanyCurrency');
        $this->addSql('DROP TABLE Product');
        $this->addSql('DROP TABLE PurchaseOrder');
        $this->addSql('DROP TABLE User');
        $this->addSql('DROP TABLE VendorPurchaseOrder');
        $this->addSql('DROP TABLE SubAccountType');
        $this->addSql('DROP TABLE Auth');
        $this->addSql('DROP TABLE Status');
        $this->addSql('DROP TABLE Term');
        $this->addSql('DROP TABLE Type');
        $this->addSql('DROP TABLE Customer');
        $this->addSql('DROP TABLE ItemCategoryType');
        $this->addSql('DROP TABLE Account');
        $this->addSql('DROP TABLE AccountType');
        $this->addSql('DROP TABLE Company');
        $this->addSql('DROP TABLE Vendor');
    }
}
