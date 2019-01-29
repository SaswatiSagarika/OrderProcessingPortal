<?php
namespace Application\Migrations;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181210124933 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE SubItem CHANGE name name VARCHAR(255) NOT NULL, CHANGE code code VARCHAR(255) NOT NULL, CHANGE created_date created_date DATETIME NOT NULL, CHANGE last_modified_date last_modified_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE TaxCode CHANGE status_id status_id INT NOT NULL, CHANGE tax_rate_id tax_rate_id INT NOT NULL, CHANGE name name VARCHAR(255) NOT NULL, CHANGE code code VARCHAR(255) NOT NULL, CHANGE taxable taxable TINYINT(1) NOT NULL, CHANGE created_date created_date DATETIME NOT NULL, CHANGE last_modified_date last_modified_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE Classification CHANGE status_id status_id INT NOT NULL, CHANGE name name VARCHAR(255) NOT NULL, CHANGE code code VARCHAR(255) NOT NULL, CHANGE created_date created_date DATETIME NOT NULL, CHANGE last_modified_date last_modified_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE CompanyCurrency CHANGE status_id status_id INT NOT NULL, CHANGE code code VARCHAR(10) NOT NULL, CHANGE name name VARCHAR(255) NOT NULL, CHANGE sparse sparse VARCHAR(255) NOT NULL, CHANGE domain domain VARCHAR(255) NOT NULL, CHANGE created_date created_date DATETIME NOT NULL, CHANGE last_modified_date last_modified_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE Product DROP FOREIGN KEY FK_1CF73D3137DED660');
        $this->addSql('DROP INDEX IDX_1CF73D3137DED660 ON Product');
        $this->addSql('ALTER TABLE Product ADD prefered_vendorprefered_vendor_id INT NOT NULL, DROP prefered_vendor_id, CHANGE expense_account_id expense_account_id INT NOT NULL, CHANGE item_category_type_id item_category_type_id INT NOT NULL, CHANGE sub_item_id sub_item_id INT NOT NULL, CHANGE inventory_assest_account_id inventory_assest_account_id INT NOT NULL, CHANGE type_id type_id INT NOT NULL, CHANGE name name VARCHAR(255) NOT NULL, CHANGE sku sku VARCHAR(10) NOT NULL, CHANGE description description VARCHAR(255) NOT NULL, CHANGE level level VARCHAR(255) NOT NULL, CHANGE taxable taxable TINYINT(1) NOT NULL, CHANGE sales_tax_included sales_tax_included TINYINT(1) NOT NULL, CHANGE unit_price unit_price VARCHAR(255) NOT NULL, CHANGE created_date created_date DATETIME NOT NULL, CHANGE last_updated_time last_updated_time DATETIME NOT NULL, CHANGE quantity_on_hand quantity_on_hand INT NOT NULL, CHANGE sales_information sales_information VARCHAR(255) NOT NULL, CHANGE cost cost INT NOT NULL');
        $this->addSql('ALTER TABLE Product ADD CONSTRAINT FK_1CF73D3137DED660 FOREIGN KEY (prefered_vendorprefered_vendor_id) REFERENCES Vendor (id)');
        $this->addSql('CREATE INDEX IDX_1CF73D3137DED660 ON Product (prefered_vendorprefered_vendor_id)');
        $this->addSql('ALTER TABLE SubAccountType CHANGE created_date created_date DATETIME NOT NULL, CHANGE last_modified_date last_modified_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE Term CHANGE name name VARCHAR(255) NOT NULL, CHANGE duedate duedate DATETIME NOT NULL, CHANGE type type VARCHAR(255) NOT NULL, CHANGE domain domain VARCHAR(255) NOT NULL, CHANGE sparse sparse VARCHAR(255) NOT NULL, CHANGE discount_day discount_day VARCHAR(255) NOT NULL, CHANGE created_date created_date DATETIME NOT NULL, CHANGE last_updated_time last_updated_time DATETIME NOT NULL');
        $this->addSql('ALTER TABLE Type CHANGE code code VARCHAR(255) NOT NULL, CHANGE description description VARCHAR(255) NOT NULL, CHANGE created_date created_date DATETIME NOT NULL, CHANGE last_updated_time last_updated_time DATETIME NOT NULL');
        $this->addSql('ALTER TABLE ItemCategoryType CHANGE name name VARCHAR(255) NOT NULL, CHANGE type type VARCHAR(255) NOT NULL, CHANGE created_date created_date DATETIME NOT NULL, CHANGE last_modified_date last_modified_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE Account CHANGE sub_account_type sub_account_type INT NOT NULL, CHANGE classification_id classification_id INT NOT NULL, CHANGE currency_id currency_id INT NOT NULL, CHANGE tax_code_id tax_code_id INT NOT NULL, CHANGE status_id status_id INT NOT NULL, CHANGE account_type_id account_type_id INT NOT NULL, CHANGE account_id account_id VARCHAR(255) DEFAULT NULL, CHANGE sub_account sub_account VARCHAR(255) DEFAULT NULL, CHANGE domain domain VARCHAR(255) NOT NULL, CHANGE created_date created_date DATETIME NOT NULL, CHANGE last_updated_time last_updated_time DATETIME NOT NULL');
        $this->addSql('ALTER TABLE AccountType CHANGE classification_id classification_id INT NOT NULL, CHANGE status_id status_id INT NOT NULL, CHANGE name name VARCHAR(255) NOT NULL, CHANGE code code VARCHAR(255) NOT NULL, CHANGE created_date created_date DATETIME NOT NULL, CHANGE last_modified_date last_modified_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE Company CHANGE name name VARCHAR(255) NOT NULL, CHANGE company_code company_code VARCHAR(255) NOT NULL, CHANGE created_date created_date DATETIME NOT NULL, CHANGE last_modified_date last_modified_date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE Vendor CHANGE company_currency_id company_currency_id INT NOT NULL, CHANGE tax_code_id tax_code_id INT NOT NULL, CHANGE status_id status_id INT NOT NULL, CHANGE company_id company_id INT NOT NULL, CHANGE term_id term_id INT NOT NULL, CHANGE name name VARCHAR(255) NOT NULL, CHANGE phone phone VARCHAR(255) NOT NULL, CHANGE email_address email_address VARCHAR(255) NOT NULL, CHANGE web_address web_address VARCHAR(255) NOT NULL, CHANGE balance balance DOUBLE PRECISION NOT NULL, CHANGE account_number account_number VARCHAR(255) NOT NULL, CHANGE vendor1099 vendor1099 TINYINT(1) NOT NULL, CHANGE line1 line1 VARCHAR(255) NOT NULL, CHANGE line2 line2 VARCHAR(255) NOT NULL, CHANGE line3 line3 VARCHAR(255) NOT NULL, CHANGE city city VARCHAR(255) NOT NULL, CHANGE country_sub_division_code country_sub_division_code VARCHAR(255) NOT NULL, CHANGE postal_code postal_code VARCHAR(255) NOT NULL, CHANGE country country VARCHAR(255) NOT NULL, CHANGE latitude latitude VARCHAR(255) NOT NULL, CHANGE logitude logitude VARCHAR(255) NOT NULL, CHANGE created_date created_date DATETIME NOT NULL, CHANGE last_updated_time last_updated_time DATETIME NOT NULL');
    }
    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('ALTER TABLE Account CHANGE account_type_id account_type_id INT DEFAULT NULL, CHANGE currency_id currency_id INT DEFAULT NULL, CHANGE tax_code_id tax_code_id INT DEFAULT NULL, CHANGE status_id status_id INT DEFAULT NULL, CHANGE sub_account_type sub_account_type INT DEFAULT NULL, CHANGE classification_id classification_id INT DEFAULT NULL, CHANGE account_id account_id VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE sub_account sub_account VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE domain domain VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE created_date created_date DATETIME DEFAULT NULL, CHANGE last_updated_time last_updated_time DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE AccountType CHANGE classification_id classification_id INT DEFAULT NULL, CHANGE status_id status_id INT DEFAULT NULL, CHANGE name name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE code code VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE created_date created_date DATETIME DEFAULT NULL, CHANGE last_modified_date last_modified_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Classification CHANGE status_id status_id INT DEFAULT NULL, CHANGE name name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE code code VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE created_date created_date DATETIME DEFAULT NULL, CHANGE last_modified_date last_modified_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Company CHANGE name name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE company_code company_code VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE created_date created_date DATETIME DEFAULT NULL, CHANGE last_modified_date last_modified_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE CompanyCurrency CHANGE status_id status_id INT DEFAULT NULL, CHANGE code code VARCHAR(10) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE name name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE sparse sparse VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE domain domain VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE created_date created_date DATETIME DEFAULT NULL, CHANGE last_modified_date last_modified_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE ItemCategoryType CHANGE name name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE type type VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE created_date created_date DATETIME DEFAULT NULL, CHANGE last_modified_date last_modified_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Product DROP FOREIGN KEY FK_1CF73D3137DED660');
        $this->addSql('DROP INDEX IDX_1CF73D3137DED660 ON Product');
        $this->addSql('ALTER TABLE Product ADD prefered_vendor_id INT DEFAULT NULL, DROP prefered_vendorprefered_vendor_id, CHANGE sub_item_id sub_item_id INT DEFAULT NULL, CHANGE type_id type_id INT DEFAULT NULL, CHANGE inventory_assest_account_id inventory_assest_account_id INT DEFAULT NULL, CHANGE item_category_type_id item_category_type_id INT DEFAULT NULL, CHANGE expense_account_id expense_account_id INT DEFAULT NULL, CHANGE name name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE sku sku VARCHAR(10) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE description description VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE level level VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE taxable taxable TINYINT(1) DEFAULT NULL, CHANGE sales_tax_included sales_tax_included TINYINT(1) DEFAULT NULL, CHANGE unit_price unit_price VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE created_date created_date DATETIME DEFAULT NULL, CHANGE last_updated_time last_updated_time DATETIME DEFAULT NULL, CHANGE quantity_on_hand quantity_on_hand INT DEFAULT NULL, CHANGE sales_information sales_information VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE cost cost INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Product ADD CONSTRAINT FK_1CF73D3137DED660 FOREIGN KEY (prefered_vendor_id) REFERENCES Vendor (id)');
        $this->addSql('CREATE INDEX IDX_1CF73D3137DED660 ON Product (prefered_vendor_id)');
        $this->addSql('ALTER TABLE SubAccountType CHANGE created_date created_date DATETIME DEFAULT NULL, CHANGE last_modified_date last_modified_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE SubItem CHANGE name name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE code code VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE created_date created_date DATETIME DEFAULT NULL, CHANGE last_modified_date last_modified_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE TaxCode CHANGE status_id status_id INT DEFAULT NULL, CHANGE tax_rate_id tax_rate_id INT DEFAULT NULL, CHANGE name name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE code code VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE taxable taxable TINYINT(1) DEFAULT NULL, CHANGE created_date created_date DATETIME DEFAULT NULL, CHANGE last_modified_date last_modified_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Term CHANGE name name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE duedate duedate DATETIME DEFAULT NULL, CHANGE type type VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE domain domain VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE sparse sparse VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE discount_day discount_day VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE created_date created_date DATETIME DEFAULT NULL, CHANGE last_updated_time last_updated_time DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Type CHANGE code code VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE description description VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE created_date created_date DATETIME DEFAULT NULL, CHANGE last_updated_time last_updated_time DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE Vendor CHANGE company_id company_id INT DEFAULT NULL, CHANGE status_id status_id INT DEFAULT NULL, CHANGE tax_code_id tax_code_id INT DEFAULT NULL, CHANGE term_id term_id INT DEFAULT NULL, CHANGE company_currency_id company_currency_id INT DEFAULT NULL, CHANGE name name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE phone phone VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE email_address email_address VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE web_address web_address VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE balance balance DOUBLE PRECISION DEFAULT NULL, CHANGE account_number account_number VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE vendor1099 vendor1099 TINYINT(1) DEFAULT NULL, CHANGE line1 line1 VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE line2 line2 VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE line3 line3 VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE city city VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE country_sub_division_code country_sub_division_code VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE postal_code postal_code VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE country country VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE latitude latitude VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE logitude logitude VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE created_date created_date DATETIME DEFAULT NULL, CHANGE last_updated_time last_updated_time DATETIME DEFAULT NULL');
    }
}