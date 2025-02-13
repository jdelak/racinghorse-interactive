<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250117142334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE horse_skin (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) NOT NULL, price INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE race (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE race_history (id INT AUTO_INCREMENT NOT NULL, id_player INT NOT NULL, id_race INT NOT NULL, place_result INT NOT NULL, elo_variation INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, username VARCHAR(180) NOT NULL, twitch_id INT NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, elo DOUBLE PRECISION NOT NULL, money INT NOT NULL, current_horse_skin INT NOT NULL,  UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_skins (user_id INT NOT NULL, horse_skin_id INT NOT NULL, INDEX IDX_6742F49A76ED395 (user_id), INDEX IDX_6742F4949E8F0E1 (horse_skin_id), PRIMARY KEY(user_id, horse_skin_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_skins ADD CONSTRAINT FK_6742F49A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_skins ADD CONSTRAINT FK_6742F4949E8F0E1 FOREIGN KEY (horse_skin_id) REFERENCES horse_skin (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users_skins DROP FOREIGN KEY FK_6742F49A76ED395');
        $this->addSql('ALTER TABLE users_skins DROP FOREIGN KEY FK_6742F4949E8F0E1');
        $this->addSql('DROP TABLE horse_skin');
        $this->addSql('DROP TABLE race');
        $this->addSql('DROP TABLE race_history');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE users_skins');
    }
}
