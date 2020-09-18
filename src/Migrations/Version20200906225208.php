<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200906225208 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cars (id VARCHAR(255) NOT NULL, car_brand_id VARCHAR(255) DEFAULT NULL, car_custom_complectation_id VARCHAR(255) DEFAULT NULL, car_external_parameters_id VARCHAR(255) DEFAULT NULL, car_internal_parameters_id VARCHAR(255) DEFAULT NULL, car_common_parameters_id VARCHAR(255) DEFAULT NULL, car_factory_complectation_id VARCHAR(255) DEFAULT NULL, INDEX IDX_95C71D14CBC3E50C (car_brand_id), UNIQUE INDEX UNIQ_95C71D14BFB7797A (car_custom_complectation_id), UNIQUE INDEX UNIQ_95C71D14FC59A55E (car_external_parameters_id), UNIQUE INDEX UNIQ_95C71D14A4620774 (car_internal_parameters_id), UNIQUE INDEX UNIQ_95C71D14BADA2A12 (car_common_parameters_id), INDEX IDX_95C71D146599B5A3 (car_factory_complectation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_custom_complectations (id VARCHAR(255) NOT NULL, air_conditioner TINYINT(1) NOT NULL, rain_sensor TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_common_parameters (id VARCHAR(255) NOT NULL, mileage INT NOT NULL, price INT NOT NULL, release_date DATE NOT NULL, delivery_date DATE NOT NULL, usage_condition VARCHAR(255) NOT NULL, INDEX IDX_89075C7056BDF814 (mileage), INDEX IDX_89075C70CAC822D9 (price), INDEX IDX_89075C70E769876D (release_date), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_external_parameters (id VARCHAR(255) NOT NULL, body_form VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_brands (id VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, INDEX IDX_66CAA8C65E237E06D79572D9 (name, model), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_internal_parameters (id VARCHAR(255) NOT NULL, engine_power DOUBLE PRECISION NOT NULL, torque DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_factory_complectations (id VARCHAR(255) NOT NULL, car_factory_complectation_id VARCHAR(255) NOT NULL, air_conditioner TINYINT(1) NOT NULL, rain_sensor TINYINT(1) NOT NULL, INDEX IDX_E297AA9C6599B5A3 (car_factory_complectation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_general_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cars ADD CONSTRAINT FK_95C71D14CBC3E50C FOREIGN KEY (car_brand_id) REFERENCES car_brands (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE cars ADD CONSTRAINT FK_95C71D14BFB7797A FOREIGN KEY (car_custom_complectation_id) REFERENCES car_custom_complectations (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE cars ADD CONSTRAINT FK_95C71D14FC59A55E FOREIGN KEY (car_external_parameters_id) REFERENCES car_external_parameters (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE cars ADD CONSTRAINT FK_95C71D14A4620774 FOREIGN KEY (car_internal_parameters_id) REFERENCES car_internal_parameters (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE cars ADD CONSTRAINT FK_95C71D14BADA2A12 FOREIGN KEY (car_common_parameters_id) REFERENCES car_common_parameters (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE cars ADD CONSTRAINT FK_95C71D146599B5A3 FOREIGN KEY (car_factory_complectation_id) REFERENCES car_factory_complectations (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE car_factory_complectations ADD CONSTRAINT FK_E297AA9C6599B5A3 FOREIGN KEY (car_factory_complectation_id) REFERENCES car_brands (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE cars DROP FOREIGN KEY FK_95C71D14BFB7797A');
        $this->addSql('ALTER TABLE cars DROP FOREIGN KEY FK_95C71D14BADA2A12');
        $this->addSql('ALTER TABLE cars DROP FOREIGN KEY FK_95C71D14FC59A55E');
        $this->addSql('ALTER TABLE cars DROP FOREIGN KEY FK_95C71D14CBC3E50C');
        $this->addSql('ALTER TABLE car_factory_complectations DROP FOREIGN KEY FK_E297AA9C6599B5A3');
        $this->addSql('ALTER TABLE cars DROP FOREIGN KEY FK_95C71D14A4620774');
        $this->addSql('ALTER TABLE cars DROP FOREIGN KEY FK_95C71D146599B5A3');
        $this->addSql('DROP TABLE cars');
        $this->addSql('DROP TABLE car_custom_complectations');
        $this->addSql('DROP TABLE car_common_parameters');
        $this->addSql('DROP TABLE car_external_parameters');
        $this->addSql('DROP TABLE car_brands');
        $this->addSql('DROP TABLE car_internal_parameters');
        $this->addSql('DROP TABLE car_factory_complectations');
    }
}
