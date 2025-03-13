<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250307100025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE category (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE dress_history (id SERIAL NOT NULL, user_id INT NOT NULL, consultation_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CA4C5C8FA76ED395 ON dress_history (user_id)');
        $this->addSql('COMMENT ON COLUMN dress_history.consultation_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE dress_history_item (dress_history_id INT NOT NULL, item_id INT NOT NULL, PRIMARY KEY(dress_history_id, item_id))');
        $this->addSql('CREATE INDEX IDX_B8C6893CE54C86A4 ON dress_history_item (dress_history_id)');
        $this->addSql('CREATE INDEX IDX_B8C6893C126F525E ON dress_history_item (item_id)');
        $this->addSql('CREATE TABLE item (id SERIAL NOT NULL, user_id INT NOT NULL, category_id INT NOT NULL, suggestion_ia_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1F1B251EA76ED395 ON item (user_id)');
        $this->addSql('CREATE INDEX IDX_1F1B251E12469DE2 ON item (category_id)');
        $this->addSql('CREATE INDEX IDX_1F1B251ECC2F4A74 ON item (suggestion_ia_id)');
        $this->addSql('COMMENT ON COLUMN item.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE notification (id SERIAL NOT NULL, user_id INT NOT NULL, content TEXT NOT NULL, send_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BF5476CAA76ED395 ON notification (user_id)');
        $this->addSql('COMMENT ON COLUMN notification.send_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE outfit (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE outfit_item (outfit_id INT NOT NULL, item_id INT NOT NULL, PRIMARY KEY(outfit_id, item_id))');
        $this->addSql('CREATE INDEX IDX_98142D2AE96E385 ON outfit_item (outfit_id)');
        $this->addSql('CREATE INDEX IDX_98142D2126F525E ON outfit_item (item_id)');
        $this->addSql('CREATE TABLE reference (id SERIAL NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, marque VARCHAR(255) NOT NULL, price DOUBLE PRECISION DEFAULT NULL, partner_link VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AEA3491312469DE2 ON reference (category_id)');
        $this->addSql('COMMENT ON COLUMN reference.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE social_interaction (id SERIAL NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE suggestion_ia (id SERIAL NOT NULL, user_id INT NOT NULL, outfit_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D4714CADA76ED395 ON suggestion_ia (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D4714CADAE96E385 ON suggestion_ia (outfit_id)');
        $this->addSql('COMMENT ON COLUMN suggestion_ia.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, profil_picture VARCHAR(255) DEFAULT NULL, gender VARCHAR(255) NOT NULL, height VARCHAR(255) DEFAULT NULL, weight VARCHAR(255) DEFAULT NULL, morphology VARCHAR(255) DEFAULT NULL, roles JSON NOT NULL, is_verified BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "user".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE dress_history ADD CONSTRAINT FK_CA4C5C8FA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dress_history_item ADD CONSTRAINT FK_B8C6893CE54C86A4 FOREIGN KEY (dress_history_id) REFERENCES dress_history (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dress_history_item ADD CONSTRAINT FK_B8C6893C126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251EA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251ECC2F4A74 FOREIGN KEY (suggestion_ia_id) REFERENCES suggestion_ia (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE outfit_item ADD CONSTRAINT FK_98142D2AE96E385 FOREIGN KEY (outfit_id) REFERENCES outfit (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE outfit_item ADD CONSTRAINT FK_98142D2126F525E FOREIGN KEY (item_id) REFERENCES item (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reference ADD CONSTRAINT FK_AEA3491312469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE suggestion_ia ADD CONSTRAINT FK_D4714CADA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE suggestion_ia ADD CONSTRAINT FK_D4714CADAE96E385 FOREIGN KEY (outfit_id) REFERENCES outfit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE dress_history DROP CONSTRAINT FK_CA4C5C8FA76ED395');
        $this->addSql('ALTER TABLE dress_history_item DROP CONSTRAINT FK_B8C6893CE54C86A4');
        $this->addSql('ALTER TABLE dress_history_item DROP CONSTRAINT FK_B8C6893C126F525E');
        $this->addSql('ALTER TABLE item DROP CONSTRAINT FK_1F1B251EA76ED395');
        $this->addSql('ALTER TABLE item DROP CONSTRAINT FK_1F1B251E12469DE2');
        $this->addSql('ALTER TABLE item DROP CONSTRAINT FK_1F1B251ECC2F4A74');
        $this->addSql('ALTER TABLE notification DROP CONSTRAINT FK_BF5476CAA76ED395');
        $this->addSql('ALTER TABLE outfit_item DROP CONSTRAINT FK_98142D2AE96E385');
        $this->addSql('ALTER TABLE outfit_item DROP CONSTRAINT FK_98142D2126F525E');
        $this->addSql('ALTER TABLE reference DROP CONSTRAINT FK_AEA3491312469DE2');
        $this->addSql('ALTER TABLE suggestion_ia DROP CONSTRAINT FK_D4714CADA76ED395');
        $this->addSql('ALTER TABLE suggestion_ia DROP CONSTRAINT FK_D4714CADAE96E385');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE dress_history');
        $this->addSql('DROP TABLE dress_history_item');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE outfit');
        $this->addSql('DROP TABLE outfit_item');
        $this->addSql('DROP TABLE reference');
        $this->addSql('DROP TABLE social_interaction');
        $this->addSql('DROP TABLE suggestion_ia');
        $this->addSql('DROP TABLE "user"');
    }
}
