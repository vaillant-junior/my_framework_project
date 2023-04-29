<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230410131601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, features LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', price INT NOT NULL, available TINYINT(1) NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_773DE69DC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rent (id INT AUTO_INCREMENT NOT NULL, car_id INT NOT NULL, user_id INT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, price DOUBLE PRECISION NOT NULL, duration INT NOT NULL, finished TINYINT(1) NOT NULL, INDEX IDX_2784DCCC3C6F69F (car_id), INDEX IDX_2784DCCA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69DC54C8C93 FOREIGN KEY (type_id) REFERENCES car_type (id)');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT FK_2784DCCC3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('ALTER TABLE rent ADD CONSTRAINT FK_2784DCCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69DC54C8C93');
        $this->addSql('ALTER TABLE rent DROP FOREIGN KEY FK_2784DCCC3C6F69F');
        $this->addSql('ALTER TABLE rent DROP FOREIGN KEY FK_2784DCCA76ED395');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE car_type');
        $this->addSql('DROP TABLE rent');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}
