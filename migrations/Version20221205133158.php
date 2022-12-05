<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221205133158 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address_number (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE award (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, federation_id INT DEFAULT NULL, business_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, points INT NOT NULL, stock INT NOT NULL, status VARCHAR(255) NOT NULL, img VARCHAR(1024) NOT NULL, interval_day INT NOT NULL, INDEX IDX_8A5B2EE719EB6921 (client_id), INDEX IDX_8A5B2EE76A03EFC5 (federation_id), INDEX IDX_8A5B2EE7A89DB457 (business_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE business (id INT AUTO_INCREMENT NOT NULL, federation_id INT NOT NULL, subcategory_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, mobile VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, location VARCHAR(255) DEFAULT NULL, nif VARCHAR(255) NOT NULL, img VARCHAR(255) NOT NULL, address_number VARCHAR(255) NOT NULL, address_block VARCHAR(255) DEFAULT NULL, address_postal_code VARCHAR(255) NOT NULL, address_city VARCHAR(255) NOT NULL, address_province VARCHAR(255) NOT NULL, address_country VARCHAR(255) NOT NULL, total_points DOUBLE PRECISION NOT NULL, lat VARCHAR(255) DEFAULT NULL, lng VARCHAR(255) DEFAULT NULL, total_trans DOUBLE PRECISION NOT NULL, punctuation DOUBLE PRECISION DEFAULT NULL, total_punctuation DOUBLE PRECISION DEFAULT NULL, description VARCHAR(255) NOT NULL, url_web VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D36E38E7927C74 (email), INDEX IDX_8D36E386A03EFC5 (federation_id), INDEX IDX_8D36E385DC6FE57 (subcategory_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE business_user (business_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_DD08D444A89DB457 (business_id), INDEX IDX_DD08D444A76ED395 (user_id), PRIMARY KEY(business_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE business_client (business_id INT NOT NULL, client_id INT NOT NULL, INDEX IDX_9CE44BAFA89DB457 (business_id), INDEX IDX_9CE44BAF19EB6921 (client_id), PRIMARY KEY(business_id, client_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE business_category (business_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_E7C1757A89DB457 (business_id), INDEX IDX_E7C175712469DE2 (category_id), PRIMARY KEY(business_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, img VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, mobile VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, points DOUBLE PRECISION NOT NULL, gender VARCHAR(255) NOT NULL, date VARCHAR(255) NOT NULL, address_number VARCHAR(255) DEFAULT NULL, block_number VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, province VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, createat DATETIME DEFAULT NULL, lat VARCHAR(255) DEFAULT NULL, lng VARCHAR(255) DEFAULT NULL, lat_geolocation VARCHAR(255) DEFAULT NULL, lng_geolocation VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_C7440455E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client_game (client_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_F2B7F2EE19EB6921 (client_id), INDEX IDX_F2B7F2EEE48FD905 (game_id), PRIMARY KEY(client_id, game_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client_award (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, award_id INT DEFAULT NULL, business_id INT DEFAULT NULL, federation_id INT NOT NULL, date DATETIME NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_2936B25019EB6921 (client_id), INDEX IDX_2936B2503D5282CF (award_id), INDEX IDX_2936B250A89DB457 (business_id), INDEX IDX_2936B2506A03EFC5 (federation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discounts (id INT AUTO_INCREMENT NOT NULL, federation_id INT DEFAULT NULL, business_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, discount DOUBLE PRECISION NOT NULL, min DOUBLE PRECISION NOT NULL, max DOUBLE PRECISION NOT NULL, INDEX IDX_FC5702B86A03EFC5 (federation_id), INDEX IDX_FC5702B8A89DB457 (business_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discounts_business (discounts_id INT NOT NULL, business_id INT NOT NULL, INDEX IDX_13A840FB6A35CCB1 (discounts_id), INDEX IDX_13A840FBA89DB457 (business_id), PRIMARY KEY(discounts_id, business_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE federation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, trade_name VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, mobile VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, address_number VARCHAR(255) NOT NULL, address_block VARCHAR(255) DEFAULT NULL, address_postal_code VARCHAR(255) NOT NULL, address_city VARCHAR(255) NOT NULL, address_province VARCHAR(255) NOT NULL, address_country VARCHAR(255) NOT NULL, point_by_amount DOUBLE PRECISION NOT NULL, total_points DOUBLE PRECISION NOT NULL, lat VARCHAR(255) NOT NULL, lng VARCHAR(255) NOT NULL, total_trans DOUBLE PRECISION NOT NULL, img VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_AD241BCDE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, federation_id INT DEFAULT NULL, gymkhana_id INT DEFAULT NULL, type_id INT DEFAULT NULL, state_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, date_start VARCHAR(255) NOT NULL, date_end VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_232B318C6A03EFC5 (federation_id), UNIQUE INDEX UNIQ_232B318C7FF0DD0E (gymkhana_id), INDEX IDX_232B318CC54C8C93 (type_id), INDEX IDX_232B318C5D83CC1 (state_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_state (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gymkhana (id INT AUTO_INCREMENT NOT NULL, game_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_EA38D0F7E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module_federation (module_id INT NOT NULL, federation_id INT NOT NULL, INDEX IDX_38C13050AFC2B591 (module_id), INDEX IDX_38C130506A03EFC5 (federation_id), PRIMARY KEY(module_id, federation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, business_id INT DEFAULT NULL, award_id INT DEFAULT NULL, federation_id INT DEFAULT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, date DATETIME NOT NULL, checked TINYINT(1) NOT NULL, img VARCHAR(255) NOT NULL, INDEX IDX_BF5476CA19EB6921 (client_id), INDEX IDX_BF5476CAA89DB457 (business_id), INDEX IDX_BF5476CA3D5282CF (award_id), INDEX IDX_BF5476CA6A03EFC5 (federation_id), INDEX IDX_BF5476CAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotion (id INT AUTO_INCREMENT NOT NULL, business_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, img VARCHAR(255) NOT NULL, key_words VARCHAR(255) NOT NULL, date_start VARCHAR(255) NOT NULL, date_end VARCHAR(255) NOT NULL, INDEX IDX_C11D7DD1A89DB457 (business_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rating (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, business_id INT NOT NULL, comment VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, img VARCHAR(255) NOT NULL, punctuation INT NOT NULL, date DATE NOT NULL, INDEX IDX_D889262219EB6921 (client_id), INDEX IDX_D8892622A89DB457 (business_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE route (id INT AUTO_INCREMENT NOT NULL, gymkhana_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, prize VARCHAR(255) NOT NULL, prize_number VARCHAR(255) NOT NULL, INDEX IDX_2C420797FF0DD0E (gymkhana_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE route_business (route_id INT NOT NULL, business_id INT NOT NULL, INDEX IDX_F6FF261334ECB4E6 (route_id), INDEX IDX_F6FF2613A89DB457 (business_id), PRIMARY KEY(route_id, business_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sub_cat (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_A8028D912469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, transaction_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, img VARCHAR(255) NOT NULL, market VARCHAR(255) NOT NULL, date DATETIME NOT NULL, total DOUBLE PRECISION NOT NULL, nif VARCHAR(255) NOT NULL, time VARCHAR(255) NOT NULL, ticket_n VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_97A0ADA319EB6921 (client_id), UNIQUE INDEX UNIQ_97A0ADA32FC0CB0F (transaction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, business_id INT DEFAULT NULL, games_id INT DEFAULT NULL, total DOUBLE PRECISION NOT NULL, location VARCHAR(255) NOT NULL, date DATETIME NOT NULL, points DOUBLE PRECISION NOT NULL, time VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_723705D119EB6921 (client_id), INDEX IDX_723705D1A89DB457 (business_id), INDEX IDX_723705D197FFC673 (games_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_federation (user_id INT NOT NULL, federation_id INT NOT NULL, INDEX IDX_A43DD21A76ED395 (user_id), INDEX IDX_A43DD216A03EFC5 (federation_id), PRIMARY KEY(user_id, federation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE award ADD CONSTRAINT FK_8A5B2EE719EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE award ADD CONSTRAINT FK_8A5B2EE76A03EFC5 FOREIGN KEY (federation_id) REFERENCES federation (id)');
        $this->addSql('ALTER TABLE award ADD CONSTRAINT FK_8A5B2EE7A89DB457 FOREIGN KEY (business_id) REFERENCES business (id)');
        $this->addSql('ALTER TABLE business ADD CONSTRAINT FK_8D36E386A03EFC5 FOREIGN KEY (federation_id) REFERENCES federation (id)');
        $this->addSql('ALTER TABLE business ADD CONSTRAINT FK_8D36E385DC6FE57 FOREIGN KEY (subcategory_id) REFERENCES sub_cat (id)');
        $this->addSql('ALTER TABLE business_user ADD CONSTRAINT FK_DD08D444A89DB457 FOREIGN KEY (business_id) REFERENCES business (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE business_user ADD CONSTRAINT FK_DD08D444A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE business_client ADD CONSTRAINT FK_9CE44BAFA89DB457 FOREIGN KEY (business_id) REFERENCES business (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE business_client ADD CONSTRAINT FK_9CE44BAF19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE business_category ADD CONSTRAINT FK_E7C1757A89DB457 FOREIGN KEY (business_id) REFERENCES business (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE business_category ADD CONSTRAINT FK_E7C175712469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client_game ADD CONSTRAINT FK_F2B7F2EE19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client_game ADD CONSTRAINT FK_F2B7F2EEE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client_award ADD CONSTRAINT FK_2936B25019EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE client_award ADD CONSTRAINT FK_2936B2503D5282CF FOREIGN KEY (award_id) REFERENCES award (id)');
        $this->addSql('ALTER TABLE client_award ADD CONSTRAINT FK_2936B250A89DB457 FOREIGN KEY (business_id) REFERENCES business (id)');
        $this->addSql('ALTER TABLE client_award ADD CONSTRAINT FK_2936B2506A03EFC5 FOREIGN KEY (federation_id) REFERENCES federation (id)');
        $this->addSql('ALTER TABLE discounts ADD CONSTRAINT FK_FC5702B86A03EFC5 FOREIGN KEY (federation_id) REFERENCES federation (id)');
        $this->addSql('ALTER TABLE discounts ADD CONSTRAINT FK_FC5702B8A89DB457 FOREIGN KEY (business_id) REFERENCES business (id)');
        $this->addSql('ALTER TABLE discounts_business ADD CONSTRAINT FK_13A840FB6A35CCB1 FOREIGN KEY (discounts_id) REFERENCES discounts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE discounts_business ADD CONSTRAINT FK_13A840FBA89DB457 FOREIGN KEY (business_id) REFERENCES business (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C6A03EFC5 FOREIGN KEY (federation_id) REFERENCES federation (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C7FF0DD0E FOREIGN KEY (gymkhana_id) REFERENCES gymkhana (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CC54C8C93 FOREIGN KEY (type_id) REFERENCES game_type (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C5D83CC1 FOREIGN KEY (state_id) REFERENCES game_state (id)');
        $this->addSql('ALTER TABLE gymkhana ADD CONSTRAINT FK_EA38D0F7E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE module_federation ADD CONSTRAINT FK_38C13050AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE module_federation ADD CONSTRAINT FK_38C130506A03EFC5 FOREIGN KEY (federation_id) REFERENCES federation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAA89DB457 FOREIGN KEY (business_id) REFERENCES business (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA3D5282CF FOREIGN KEY (award_id) REFERENCES award (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA6A03EFC5 FOREIGN KEY (federation_id) REFERENCES federation (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD1A89DB457 FOREIGN KEY (business_id) REFERENCES business (id)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D889262219EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D8892622A89DB457 FOREIGN KEY (business_id) REFERENCES business (id)');
        $this->addSql('ALTER TABLE route ADD CONSTRAINT FK_2C420797FF0DD0E FOREIGN KEY (gymkhana_id) REFERENCES gymkhana (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE route_business ADD CONSTRAINT FK_F6FF261334ECB4E6 FOREIGN KEY (route_id) REFERENCES route (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE route_business ADD CONSTRAINT FK_F6FF2613A89DB457 FOREIGN KEY (business_id) REFERENCES business (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sub_cat ADD CONSTRAINT FK_A8028D912469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA319EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA32FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transaction (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D119EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1A89DB457 FOREIGN KEY (business_id) REFERENCES business (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D197FFC673 FOREIGN KEY (games_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE user_federation ADD CONSTRAINT FK_A43DD21A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_federation ADD CONSTRAINT FK_A43DD216A03EFC5 FOREIGN KEY (federation_id) REFERENCES federation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD name VARCHAR(255) NOT NULL, ADD phone VARCHAR(255) DEFAULT NULL, ADD address VARCHAR(255) DEFAULT NULL, ADD first_name VARCHAR(255) DEFAULT NULL, ADD last_name VARCHAR(255) DEFAULT NULL, DROP is_verified');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE award DROP FOREIGN KEY FK_8A5B2EE719EB6921');
        $this->addSql('ALTER TABLE award DROP FOREIGN KEY FK_8A5B2EE76A03EFC5');
        $this->addSql('ALTER TABLE award DROP FOREIGN KEY FK_8A5B2EE7A89DB457');
        $this->addSql('ALTER TABLE business DROP FOREIGN KEY FK_8D36E386A03EFC5');
        $this->addSql('ALTER TABLE business DROP FOREIGN KEY FK_8D36E385DC6FE57');
        $this->addSql('ALTER TABLE business_user DROP FOREIGN KEY FK_DD08D444A89DB457');
        $this->addSql('ALTER TABLE business_user DROP FOREIGN KEY FK_DD08D444A76ED395');
        $this->addSql('ALTER TABLE business_client DROP FOREIGN KEY FK_9CE44BAFA89DB457');
        $this->addSql('ALTER TABLE business_client DROP FOREIGN KEY FK_9CE44BAF19EB6921');
        $this->addSql('ALTER TABLE business_category DROP FOREIGN KEY FK_E7C1757A89DB457');
        $this->addSql('ALTER TABLE business_category DROP FOREIGN KEY FK_E7C175712469DE2');
        $this->addSql('ALTER TABLE client_game DROP FOREIGN KEY FK_F2B7F2EE19EB6921');
        $this->addSql('ALTER TABLE client_game DROP FOREIGN KEY FK_F2B7F2EEE48FD905');
        $this->addSql('ALTER TABLE client_award DROP FOREIGN KEY FK_2936B25019EB6921');
        $this->addSql('ALTER TABLE client_award DROP FOREIGN KEY FK_2936B2503D5282CF');
        $this->addSql('ALTER TABLE client_award DROP FOREIGN KEY FK_2936B250A89DB457');
        $this->addSql('ALTER TABLE client_award DROP FOREIGN KEY FK_2936B2506A03EFC5');
        $this->addSql('ALTER TABLE discounts DROP FOREIGN KEY FK_FC5702B86A03EFC5');
        $this->addSql('ALTER TABLE discounts DROP FOREIGN KEY FK_FC5702B8A89DB457');
        $this->addSql('ALTER TABLE discounts_business DROP FOREIGN KEY FK_13A840FB6A35CCB1');
        $this->addSql('ALTER TABLE discounts_business DROP FOREIGN KEY FK_13A840FBA89DB457');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C6A03EFC5');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C7FF0DD0E');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CC54C8C93');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C5D83CC1');
        $this->addSql('ALTER TABLE gymkhana DROP FOREIGN KEY FK_EA38D0F7E48FD905');
        $this->addSql('ALTER TABLE module_federation DROP FOREIGN KEY FK_38C13050AFC2B591');
        $this->addSql('ALTER TABLE module_federation DROP FOREIGN KEY FK_38C130506A03EFC5');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA19EB6921');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAA89DB457');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA3D5282CF');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA6A03EFC5');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAA76ED395');
        $this->addSql('ALTER TABLE promotion DROP FOREIGN KEY FK_C11D7DD1A89DB457');
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D889262219EB6921');
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D8892622A89DB457');
        $this->addSql('ALTER TABLE route DROP FOREIGN KEY FK_2C420797FF0DD0E');
        $this->addSql('ALTER TABLE route_business DROP FOREIGN KEY FK_F6FF261334ECB4E6');
        $this->addSql('ALTER TABLE route_business DROP FOREIGN KEY FK_F6FF2613A89DB457');
        $this->addSql('ALTER TABLE sub_cat DROP FOREIGN KEY FK_A8028D912469DE2');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA319EB6921');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA32FC0CB0F');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D119EB6921');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1A89DB457');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D197FFC673');
        $this->addSql('ALTER TABLE user_federation DROP FOREIGN KEY FK_A43DD21A76ED395');
        $this->addSql('ALTER TABLE user_federation DROP FOREIGN KEY FK_A43DD216A03EFC5');
        $this->addSql('DROP TABLE address_number');
        $this->addSql('DROP TABLE award');
        $this->addSql('DROP TABLE business');
        $this->addSql('DROP TABLE business_user');
        $this->addSql('DROP TABLE business_client');
        $this->addSql('DROP TABLE business_category');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE client_game');
        $this->addSql('DROP TABLE client_award');
        $this->addSql('DROP TABLE discounts');
        $this->addSql('DROP TABLE discounts_business');
        $this->addSql('DROP TABLE federation');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_state');
        $this->addSql('DROP TABLE game_type');
        $this->addSql('DROP TABLE gymkhana');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE module_federation');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE rating');
        $this->addSql('DROP TABLE route');
        $this->addSql('DROP TABLE route_business');
        $this->addSql('DROP TABLE sub_cat');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE user_federation');
        $this->addSql('ALTER TABLE user ADD is_verified TINYINT(1) NOT NULL, DROP name, DROP phone, DROP address, DROP first_name, DROP last_name');
    }
}
