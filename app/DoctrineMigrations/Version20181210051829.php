<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181210051829 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE SubItem (id INT AUTO_INCREMENT NOT NULL, status_id INT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, created_date DATETIME NOT NULL, last_modified_date DATETIME NOT NULL, INDEX IDX_A921C1376BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE POItems (id INT AUTO_INCREMENT NOT NULL, po_id INT NOT NULL, item_id INT NOT NULL, tax_code_id INT NOT NULL, item_price VARCHAR(255) NOT NULL, quantity INT NOT NULL, status VARCHAR(255) NOT NULL, bill_status VARCHAR(255) NOT NULL, taxable_amount VARCHAR(255) NOT NULL, created_date DATETIME NOT NULL, last_modified_date DATETIME NOT NULL, INDEX IDX_A64ABF24C5B5ECA5 (po_id), INDEX IDX_A64ABF24126F525E (item_id), INDEX IDX_A64ABF2466925E1D (tax_code_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE TaxRate (id INT AUTO_INCREMENT NOT NULL, status_id INT NOT NULL, tax_agency_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, rate_value DOUBLE PRECISION NOT NULL, created_date DATETIME NOT NULL, last_modified_date DATETIME NOT NULL, INDEX IDX_1E662A306BF700BD (status_id), INDEX IDX_1E662A30E1D3D100 (tax_agency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE TaxCode (id INT AUTO_INCREMENT NOT NULL, status_id INT NOT NULL, tax_rate_id INT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, taxable TINYINT(1) NOT NULL, created_date DATETIME NOT NULL, last_modified_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_B69F259177153098 (code), INDEX IDX_B69F25916BF700BD (status_id), INDEX IDX_B69F2591FDD13F95 (tax_rate_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Classification (id INT AUTO_INCREMENT NOT NULL, status_id INT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, created_date DATETIME NOT NULL, last_modified_date DATETIME NOT NULL, INDEX IDX_880FAAE96BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE CompanyCurrency (id INT AUTO_INCREMENT NOT NULL, status_id INT NOT NULL, code VARCHAR(10) NOT NULL, name VARCHAR(255) NOT NULL, sparse VARCHAR(255) NOT NULL, domain VARCHAR(255) NOT NULL, created_date DATETIME NOT NULL, last_modified_date DATETIME NOT NULL, INDEX IDX_4CFF2F5D6BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Product (id INT AUTO_INCREMENT NOT NULL, status_id INT NOT NULL, sub_item_id INT NOT NULL, type_id INT NOT NULL, inventory_assest_account_id INT NOT NULL, item_category_type_id INT NOT NULL, expense_account_id INT NOT NULL, prefered_vendorprefered_vendor_id INT NOT NULL, name VARCHAR(255) NOT NULL, sku VARCHAR(10) NOT NULL, description VARCHAR(255) NOT NULL, level VARCHAR(255) NOT NULL, taxable TINYINT(1) NOT NULL, sales_tax_included TINYINT(1) NOT NULL, unit_price VARCHAR(255) NOT NULL, created_date DATETIME NOT NULL, last_updated_time DATETIME NOT NULL, quantity_on_hand INT NOT NULL, reorder_point INT NOT NULL, sales_information VARCHAR(255) NOT NULL, purchasing_information VARCHAR(255) NOT NULL, cost INT NOT NULL, UNIQUE INDEX UNIQ_1CF73D31F9038C4 (sku), INDEX IDX_1CF73D316BF700BD (status_id), INDEX IDX_1CF73D316DB70EAA (sub_item_id), INDEX IDX_1CF73D31C54C8C93 (type_id), INDEX IDX_1CF73D319C706823 (inventory_assest_account_id), INDEX IDX_1CF73D313AF6CFF2 (item_category_type_id), INDEX IDX_1CF73D312B7F60B3 (expense_account_id), INDEX IDX_1CF73D3137DED660 (prefered_vendorprefered_vendor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE PurchaseOrder (id INT AUTO_INCREMENT NOT NULL, vendor INT NOT NULL, account_id INT NOT NULL, sales_term_id INT NOT NULL, currency_id INT NOT NULL, po_id INT NOT NULL, total_amt VARCHAR(255) NOT NULL, notes VARCHAR(255) NOT NULL, due_date DATETIME NOT NULL, po_status VARCHAR(255) NOT NULL, exchange_rate VARCHAR(255) NOT NULL, created_date DATETIME NOT NULL, last_modified_date DATETIME NOT NULL, INDEX IDX_AA004F11F52233F6 (vendor), INDEX IDX_AA004F119B6B5FBA (account_id), INDEX IDX_AA004F11D5499C (sales_term_id), INDEX IDX_AA004F1138248176 (currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE SubAccountType (id INT AUTO_INCREMENT NOT NULL, classification_id INT NOT NULL, account_type_id INT NOT NULL, status_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, created_date DATETIME NOT NULL, last_modified_date DATETIME NOT NULL, INDEX IDX_25042C092A86559F (classification_id), INDEX IDX_25042C09C6798DB (account_type_id), INDEX IDX_25042C096BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Status (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, created_date DATETIME NOT NULL, last_modified_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE TaxAgency (id INT AUTO_INCREMENT NOT NULL, status_id INT NOT NULL, name VARCHAR(255) NOT NULL, tax_registration_number VARCHAR(255) NOT NULL, tax_tracked_purchase TINYINT(1) NOT NULL, tax_tracked_sales TINYINT(1) NOT NULL, created_date DATETIME NOT NULL, last_modified_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_CCDF58CE6700DD87 (tax_registration_number), INDEX IDX_CCDF58CE6BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Term (id INT AUTO_INCREMENT NOT NULL, status_id INT NOT NULL, name VARCHAR(255) NOT NULL, duedate DATETIME NOT NULL, type VARCHAR(255) NOT NULL, domain VARCHAR(255) NOT NULL, sparse VARCHAR(255) NOT NULL, discount_day VARCHAR(255) NOT NULL, created_date DATETIME NOT NULL, last_updated_time DATETIME NOT NULL, INDEX IDX_53D48B36BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Type (id INT AUTO_INCREMENT NOT NULL, status_id INT NOT NULL, code VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, created_date DATETIME NOT NULL, last_updated_time DATETIME NOT NULL, INDEX IDX_2CECF8176BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ItemCategoryType (id INT AUTO_INCREMENT NOT NULL, status_id INT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, created_date DATETIME NOT NULL, last_modified_date DATETIME NOT NULL, INDEX IDX_F59E06FA6BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Account (id INT AUTO_INCREMENT NOT NULL, account_type_id INT NOT NULL, currency_id INT NOT NULL, tax_code_id INT NOT NULL, status_id INT NOT NULL, sub_account_type INT NOT NULL, classification_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, account_number VARCHAR(255) NOT NULL, account_id VARCHAR(255) NOT NULL, credit_balance VARCHAR(255) NOT NULL, sub_account VARCHAR(255) NOT NULL, sparse VARCHAR(255) DEFAULT NULL, domain VARCHAR(255) NOT NULL, created_date DATETIME NOT NULL, last_updated_time DATETIME NOT NULL, UNIQUE INDEX UNIQ_B28B6F38B1A4D127 (account_number), UNIQUE INDEX UNIQ_B28B6F389B6B5FBA (account_id), INDEX IDX_B28B6F38C6798DB (account_type_id), INDEX IDX_B28B6F3838248176 (currency_id), INDEX IDX_B28B6F3866925E1D (tax_code_id), INDEX IDX_B28B6F386BF700BD (status_id), INDEX IDX_B28B6F38171F97B5 (sub_account_type), INDEX IDX_B28B6F382A86559F (classification_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE AccountType (id INT AUTO_INCREMENT NOT NULL, classification_id INT NOT NULL, status_id INT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, created_date DATETIME NOT NULL, last_modified_date DATETIME NOT NULL, INDEX IDX_A7E037642A86559F (classification_id), INDEX IDX_A7E037646BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, company_code VARCHAR(255) NOT NULL, created_date DATETIME NOT NULL, last_modified_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_800230D334782A76 (company_code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Vendor (id INT AUTO_INCREMENT NOT NULL, company_id INT NOT NULL, status_id INT NOT NULL, tax_code_id INT NOT NULL, term_id INT NOT NULL, company_currency_id INT NOT NULL, name VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, email_address VARCHAR(255) NOT NULL, web_address VARCHAR(255) NOT NULL, balance DOUBLE PRECISION NOT NULL, account_number VARCHAR(255) NOT NULL, vendor1099 TINYINT(1) NOT NULL, line1 VARCHAR(255) NOT NULL, line2 VARCHAR(255) NOT NULL, line3 VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, country_sub_division_code VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, latitude VARCHAR(255) NOT NULL, logitude VARCHAR(255) NOT NULL, created_date DATETIME NOT NULL, last_updated_time DATETIME NOT NULL, INDEX IDX_F28E36C0979B1AD6 (company_id), INDEX IDX_F28E36C06BF700BD (status_id), INDEX IDX_F28E36C066925E1D (tax_code_id), INDEX IDX_F28E36C0E2C35FC (term_id), INDEX IDX_F28E36C021F539EE (company_currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE SubItem ADD CONSTRAINT FK_A921C1376BF700BD FOREIGN KEY (status_id) REFERENCES Status (id)');
        $this->addSql('ALTER TABLE POItems ADD CONSTRAINT FK_A64ABF24C5B5ECA5 FOREIGN KEY (po_id) REFERENCES PurchaseOrder (id)');
        $this->addSql('ALTER TABLE POItems ADD CONSTRAINT FK_A64ABF24126F525E FOREIGN KEY (item_id) REFERENCES Product (id)');
        $this->addSql('ALTER TABLE POItems ADD CONSTRAINT FK_A64ABF2466925E1D FOREIGN KEY (tax_code_id) REFERENCES TaxCode (id)');
        $this->addSql('ALTER TABLE TaxRate ADD CONSTRAINT FK_1E662A306BF700BD FOREIGN KEY (status_id) REFERENCES Status (id)');
        $this->addSql('ALTER TABLE TaxRate ADD CONSTRAINT FK_1E662A30E1D3D100 FOREIGN KEY (tax_agency_id) REFERENCES TaxAgency (id)');
        $this->addSql('ALTER TABLE TaxCode ADD CONSTRAINT FK_B69F25916BF700BD FOREIGN KEY (status_id) REFERENCES Status (id)');
        $this->addSql('ALTER TABLE TaxCode ADD CONSTRAINT FK_B69F2591FDD13F95 FOREIGN KEY (tax_rate_id) REFERENCES TaxRate (id)');
        $this->addSql('ALTER TABLE Classification ADD CONSTRAINT FK_880FAAE96BF700BD FOREIGN KEY (status_id) REFERENCES Status (id)');
        $this->addSql('ALTER TABLE CompanyCurrency ADD CONSTRAINT FK_4CFF2F5D6BF700BD FOREIGN KEY (status_id) REFERENCES Status (id)');
        $this->addSql('ALTER TABLE Product ADD CONSTRAINT FK_1CF73D316BF700BD FOREIGN KEY (status_id) REFERENCES Status (id)');
        $this->addSql('ALTER TABLE Product ADD CONSTRAINT FK_1CF73D316DB70EAA FOREIGN KEY (sub_item_id) REFERENCES SubItem (id)');
        $this->addSql('ALTER TABLE Product ADD CONSTRAINT FK_1CF73D31C54C8C93 FOREIGN KEY (type_id) REFERENCES Type (id)');
        $this->addSql('ALTER TABLE Product ADD CONSTRAINT FK_1CF73D319C706823 FOREIGN KEY (inventory_assest_account_id) REFERENCES Account (id)');
        $this->addSql('ALTER TABLE Product ADD CONSTRAINT FK_1CF73D313AF6CFF2 FOREIGN KEY (item_category_type_id) REFERENCES ItemCategoryType (id)');
        $this->addSql('ALTER TABLE Product ADD CONSTRAINT FK_1CF73D312B7F60B3 FOREIGN KEY (expense_account_id) REFERENCES Account (id)');
        $this->addSql('ALTER TABLE Product ADD CONSTRAINT FK_1CF73D3137DED660 FOREIGN KEY (prefered_vendorprefered_vendor_id) REFERENCES Vendor (id)');
        $this->addSql('ALTER TABLE PurchaseOrder ADD CONSTRAINT FK_AA004F11F52233F6 FOREIGN KEY (vendor) REFERENCES Vendor (id)');
        $this->addSql('ALTER TABLE PurchaseOrder ADD CONSTRAINT FK_AA004F119B6B5FBA FOREIGN KEY (account_id) REFERENCES Account (id)');
        $this->addSql('ALTER TABLE PurchaseOrder ADD CONSTRAINT FK_AA004F11D5499C FOREIGN KEY (sales_term_id) REFERENCES Term (id)');
        $this->addSql('ALTER TABLE PurchaseOrder ADD CONSTRAINT FK_AA004F1138248176 FOREIGN KEY (currency_id) REFERENCES CompanyCurrency (id)');
        $this->addSql('ALTER TABLE SubAccountType ADD CONSTRAINT FK_25042C092A86559F FOREIGN KEY (classification_id) REFERENCES Classification (id)');
        $this->addSql('ALTER TABLE SubAccountType ADD CONSTRAINT FK_25042C09C6798DB FOREIGN KEY (account_type_id) REFERENCES AccountType (id)');
        $this->addSql('ALTER TABLE SubAccountType ADD CONSTRAINT FK_25042C096BF700BD FOREIGN KEY (status_id) REFERENCES Status (id)');
        $this->addSql('ALTER TABLE TaxAgency ADD CONSTRAINT FK_CCDF58CE6BF700BD FOREIGN KEY (status_id) REFERENCES Status (id)');
        $this->addSql('ALTER TABLE Term ADD CONSTRAINT FK_53D48B36BF700BD FOREIGN KEY (status_id) REFERENCES Status (id)');
        $this->addSql('ALTER TABLE Type ADD CONSTRAINT FK_2CECF8176BF700BD FOREIGN KEY (status_id) REFERENCES Status (id)');
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
        $this->addSql('ALTER TABLE Vendor ADD CONSTRAINT FK_F28E36C066925E1D FOREIGN KEY (tax_code_id) REFERENCES TaxCode (id)');
        $this->addSql('ALTER TABLE Vendor ADD CONSTRAINT FK_F28E36C0E2C35FC FOREIGN KEY (term_id) REFERENCES Term (id)');
        $this->addSql('ALTER TABLE Vendor ADD CONSTRAINT FK_F28E36C021F539EE FOREIGN KEY (company_currency_id) REFERENCES CompanyCurrency (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Product DROP FOREIGN KEY FK_1CF73D316DB70EAA');
        $this->addSql('ALTER TABLE TaxCode DROP FOREIGN KEY FK_B69F2591FDD13F95');
        $this->addSql('ALTER TABLE POItems DROP FOREIGN KEY FK_A64ABF2466925E1D');
        $this->addSql('ALTER TABLE Account DROP FOREIGN KEY FK_B28B6F3866925E1D');
        $this->addSql('ALTER TABLE Vendor DROP FOREIGN KEY FK_F28E36C066925E1D');
        $this->addSql('ALTER TABLE SubAccountType DROP FOREIGN KEY FK_25042C092A86559F');
        $this->addSql('ALTER TABLE Account DROP FOREIGN KEY FK_B28B6F382A86559F');
        $this->addSql('ALTER TABLE AccountType DROP FOREIGN KEY FK_A7E037642A86559F');
        $this->addSql('ALTER TABLE PurchaseOrder DROP FOREIGN KEY FK_AA004F1138248176');
        $this->addSql('ALTER TABLE Account DROP FOREIGN KEY FK_B28B6F3838248176');
        $this->addSql('ALTER TABLE Vendor DROP FOREIGN KEY FK_F28E36C021F539EE');
        $this->addSql('ALTER TABLE POItems DROP FOREIGN KEY FK_A64ABF24126F525E');
        $this->addSql('ALTER TABLE POItems DROP FOREIGN KEY FK_A64ABF24C5B5ECA5');
        $this->addSql('ALTER TABLE Account DROP FOREIGN KEY FK_B28B6F38171F97B5');
        $this->addSql('ALTER TABLE SubItem DROP FOREIGN KEY FK_A921C1376BF700BD');
        $this->addSql('ALTER TABLE TaxRate DROP FOREIGN KEY FK_1E662A306BF700BD');
        $this->addSql('ALTER TABLE TaxCode DROP FOREIGN KEY FK_B69F25916BF700BD');
        $this->addSql('ALTER TABLE Classification DROP FOREIGN KEY FK_880FAAE96BF700BD');
        $this->addSql('ALTER TABLE CompanyCurrency DROP FOREIGN KEY FK_4CFF2F5D6BF700BD');
        $this->addSql('ALTER TABLE Product DROP FOREIGN KEY FK_1CF73D316BF700BD');
        $this->addSql('ALTER TABLE SubAccountType DROP FOREIGN KEY FK_25042C096BF700BD');
        $this->addSql('ALTER TABLE TaxAgency DROP FOREIGN KEY FK_CCDF58CE6BF700BD');
        $this->addSql('ALTER TABLE Term DROP FOREIGN KEY FK_53D48B36BF700BD');
        $this->addSql('ALTER TABLE Type DROP FOREIGN KEY FK_2CECF8176BF700BD');
        $this->addSql('ALTER TABLE ItemCategoryType DROP FOREIGN KEY FK_F59E06FA6BF700BD');
        $this->addSql('ALTER TABLE Account DROP FOREIGN KEY FK_B28B6F386BF700BD');
        $this->addSql('ALTER TABLE AccountType DROP FOREIGN KEY FK_A7E037646BF700BD');
        $this->addSql('ALTER TABLE Vendor DROP FOREIGN KEY FK_F28E36C06BF700BD');
        $this->addSql('ALTER TABLE TaxRate DROP FOREIGN KEY FK_1E662A30E1D3D100');
        $this->addSql('ALTER TABLE PurchaseOrder DROP FOREIGN KEY FK_AA004F11D5499C');
        $this->addSql('ALTER TABLE Vendor DROP FOREIGN KEY FK_F28E36C0E2C35FC');
        $this->addSql('ALTER TABLE Product DROP FOREIGN KEY FK_1CF73D31C54C8C93');
        $this->addSql('ALTER TABLE Product DROP FOREIGN KEY FK_1CF73D313AF6CFF2');
        $this->addSql('ALTER TABLE Product DROP FOREIGN KEY FK_1CF73D319C706823');
        $this->addSql('ALTER TABLE Product DROP FOREIGN KEY FK_1CF73D312B7F60B3');
        $this->addSql('ALTER TABLE PurchaseOrder DROP FOREIGN KEY FK_AA004F119B6B5FBA');
        $this->addSql('ALTER TABLE SubAccountType DROP FOREIGN KEY FK_25042C09C6798DB');
        $this->addSql('ALTER TABLE Account DROP FOREIGN KEY FK_B28B6F38C6798DB');
        $this->addSql('ALTER TABLE Vendor DROP FOREIGN KEY FK_F28E36C0979B1AD6');
        $this->addSql('ALTER TABLE Product DROP FOREIGN KEY FK_1CF73D3137DED660');
        $this->addSql('ALTER TABLE PurchaseOrder DROP FOREIGN KEY FK_AA004F11F52233F6');
        $this->addSql('DROP TABLE SubItem');
        $this->addSql('DROP TABLE POItems');
        $this->addSql('DROP TABLE TaxRate');
        $this->addSql('DROP TABLE TaxCode');
        $this->addSql('DROP TABLE Classification');
        $this->addSql('DROP TABLE CompanyCurrency');
        $this->addSql('DROP TABLE Product');
        $this->addSql('DROP TABLE PurchaseOrder');
        $this->addSql('DROP TABLE SubAccountType');
        $this->addSql('DROP TABLE Status');
        $this->addSql('DROP TABLE TaxAgency');
        $this->addSql('DROP TABLE Term');
        $this->addSql('DROP TABLE Type');
        $this->addSql('DROP TABLE ItemCategoryType');
        $this->addSql('DROP TABLE Account');
        $this->addSql('DROP TABLE AccountType');
        $this->addSql('DROP TABLE Company');
        $this->addSql('DROP TABLE Vendor');
    }
}
