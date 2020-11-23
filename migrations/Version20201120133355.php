<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201120133355 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs

        // Generate test data

        // Customer #1
        $customer['FNAME'] = 'T';
        $customer['LNAME'] = 'Sparkle';
        $customer['EMAIL'] = 'twilight@canterlot.gov.eq';
        $customer['NOTES'] = 'This is a test customer';

        $this->addSql('INSERT INTO customer (FNAME, LNAME, EMAIL, NOTES, DATE) VALUES ("' . $customer['FNAME'] . '", "' . $customer['LNAME'] . '", "' . $customer['EMAIL'] . '", "' . $customer['NOTES'] . '", "' . date('Y-m-d H:i:s') . '")');

        // Customer #2
        $customer['FNAME'] = 'Capper';
        $customer['LNAME'] = 'Cat';
        $customer['EMAIL'] = 'smootheoperator@pegasusmail.eq';
        $customer['NOTES'] = 'This is a test customer';

        $this->addSql('INSERT INTO customer (FNAME, LNAME, EMAIL, NOTES, DATE) VALUES ("' . $customer['FNAME'] . '", "' . $customer['LNAME'] . '", "' . $customer['EMAIL'] . '", "' . $customer['NOTES'] . '", "' . date('Y-m-d H:i:s') . '")');

        // Customer #3
        $customer['FNAME'] = 'S';
        $customer['LNAME'] = 'Shimmer';
        $customer['EMAIL'] = 'sunset.s@canterlothighschool.edu';
        $customer['NOTES'] = 'This is a test customer';

        $this->addSql('INSERT INTO customer (FNAME, LNAME, EMAIL, NOTES, DATE) VALUES ("' . $customer['FNAME'] . '", "' . $customer['LNAME'] . '", "' . $customer['EMAIL'] . '", "' . $customer['NOTES'] . '", "' . date('Y-m-d H:i:s') . '")');

        // Order #1 - 3 Free Trial
        $order['DATE']      = date('Y-m-d H:i:s', date('U') - rand(10000,1000000));
        $order['CUSTOMER']  = 1;
        $order['NET']       = 0;
        $order['VAT']       = 0;
        $order['TOTAL']     = 0;
        $order['STAGE']     = 'Created';
        $order['PRODUCT']   = 'Number Forwarding';
        $order['TYPE']      = 'Trial';

        $this->addSql('INSERT INTO `order` (DATE, NET, VAT, TOTAL, STAGE, PRODUCT, CUSTOMER, TYPE, USER) VALUES ("' . $order['DATE'] . '", ' . $order['NET'] . ', ' . $order['VAT'] . ', ' . $order['TOTAL'] . ', "' . $order['STAGE'] . '", "' . $order['PRODUCT'] . '", ' . $order['CUSTOMER'] . ', "' . $order['TYPE'] . '", 1)');

        $order['DATE']      = date('Y-m-d H:i:s', date('U') - rand(10000,1000000));
        $order['CUSTOMER']  = 2;

        $this->addSql('INSERT INTO `order` (DATE, NET, VAT, TOTAL, STAGE, PRODUCT, CUSTOMER, TYPE, USER) VALUES ("' . $order['DATE'] . '", ' . $order['NET'] . ', ' . $order['VAT'] . ', ' . $order['TOTAL'] . ', "' . $order['STAGE'] . '", "' . $order['PRODUCT'] . '", ' . $order['CUSTOMER'] . ', "' . $order['TYPE'] . '", 1)');

        $order['DATE']      = date('Y-m-d H:i:s', date('U') - rand(10000,1000000));
        $order['CUSTOMER']  = 3;

        $this->addSql('INSERT INTO `order` (DATE, NET, VAT, TOTAL, STAGE, PRODUCT, CUSTOMER, TYPE, USER) VALUES ("' . $order['DATE'] . '", ' . $order['NET'] . ', ' . $order['VAT'] . ', ' . $order['TOTAL'] . ', "' . $order['STAGE'] . '", "' . $order['PRODUCT'] . '", ' . $order['CUSTOMER'] . ', "' . $order['TYPE'] . '", 1)');
        // Order #4 - 6 Contract

        $order['DATE']      = date('Y-m-d H:i:s', date('U') - rand(10000,1000000));
        $order['CUSTOMER']  = 1;
        $order['NET']       = rand(100, 1000);
        $order['VAT']       = $order['NET'] * 0.2;
        $order['TOTAL']     = $order['NET'] + $order['VAT'];
        $order['STAGE']     = 'Created';
        $order['PRODUCT']   = 'Number Forwarding';
        $order['TYPE']      = 'Contract';

        $this->addSql('INSERT INTO `order` (DATE, NET, VAT, TOTAL, STAGE, PRODUCT, CUSTOMER, TYPE, USER) VALUES ("' . $order['DATE'] . '", ' . $order['NET'] . ', ' . $order['VAT'] . ', ' . $order['TOTAL'] . ', "' . $order['STAGE'] . '", "' . $order['PRODUCT'] . '", ' . $order['CUSTOMER'] . ', "' . $order['TYPE'] . '", 1)');

        $order['DATE']      = date('Y-m-d H:i:s', date('U') - rand(10000,1000000));
        $order['CUSTOMER']  = 2;
        $order['NET']       = rand(100, 1000);
        $order['VAT']       = $order['NET'] * 0.2;
        $order['TOTAL']     = $order['NET'] + $order['VAT'];

        $this->addSql('INSERT INTO `order` (DATE, NET, VAT, TOTAL, STAGE, PRODUCT, CUSTOMER, TYPE, USER) VALUES ("' . $order['DATE'] . '", ' . $order['NET'] . ', ' . $order['VAT'] . ', ' . $order['TOTAL'] . ', "' . $order['STAGE'] . '", "' . $order['PRODUCT'] . '", ' . $order['CUSTOMER'] . ', "' . $order['TYPE'] . '", 1)');

        $order['DATE']      = date('Y-m-d H:i:s', date('U') - rand(10000,1000000));
        $order['CUSTOMER']  = 3;
        $order['NET']       = rand(100, 1000);
        $order['VAT']       = $order['NET'] * 0.2;
        $order['TOTAL']     = $order['NET'] + $order['VAT'];

        $this->addSql('INSERT INTO `order` (DATE, NET, VAT, TOTAL, STAGE, PRODUCT, CUSTOMER, TYPE, USER) VALUES ("' . $order['DATE'] . '", ' . $order['NET'] . ', ' . $order['VAT'] . ', ' . $order['TOTAL'] . ', "' . $order['STAGE'] . '", "' . $order['PRODUCT'] . '", ' . $order['CUSTOMER'] . ', "' . $order['TYPE'] . '", 1)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('TRUNCATE TABLE customer');
        $this->addSql('TRUNCATE TABLE `order`');

    }
}
