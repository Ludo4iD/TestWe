<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221124120456 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie_has_type DROP FOREIGN KEY fk_Movie_has_Type_Movie1');
        $this->addSql('ALTER TABLE movie_has_type DROP FOREIGN KEY fk_Movie_has_Type_Type1');
        $this->addSql('ALTER TABLE movie_has_type ADD CONSTRAINT FK_D7417FB8F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movie_has_type ADD CONSTRAINT FK_D7417FBC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
        //$this->addSql('ALTER TABLE movie_has_type RENAME INDEX idx_d7417fb76e5d4aa TO IDX_D7417FB8F93B6FC');
        $this->addSql('ALTER TABLE movie_has_type RENAME INDEX FK_D7417FBC54C8C93 TO IDX_D7417FBC54C8C93');
        $this->addSql('ALTER TABLE movie_has_people CHANGE significance significance ENUM(\'principal\', \'secondaire\') NULL COMMENT \'(DC2Type:enum_significance)\'');
        //$this->addSql('ALTER TABLE movie_has_people RENAME INDEX idx_edc40d8176e5d4aa TO IDX_EDC40D818F93B6FC');
        $this->addSql('ALTER TABLE movie_has_people RENAME INDEX fk_Movie_has_People_People1 TO IDX_EDC40D813147C936');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie_has_people CHANGE significance significance VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE movie_has_people RENAME INDEX idx_edc40d813147c936 TO fk_Movie_has_People_People1');
        $this->addSql('ALTER TABLE movie_has_people RENAME INDEX idx_edc40d818f93b6fc TO IDX_EDC40D8176E5D4AA');
        $this->addSql('ALTER TABLE movie_has_type DROP FOREIGN KEY FK_D7417FB8F93B6FC');
        $this->addSql('ALTER TABLE movie_has_type DROP FOREIGN KEY FK_D7417FBC54C8C93');
        $this->addSql('ALTER TABLE movie_has_type ADD CONSTRAINT fk_Movie_has_Type_Movie1 FOREIGN KEY (Movie_id) REFERENCES movie (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE movie_has_type ADD CONSTRAINT fk_Movie_has_Type_Type1 FOREIGN KEY (Type_id) REFERENCES type (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE movie_has_type RENAME INDEX idx_d7417fbc54c8c93 TO fk_Movie_has_Type_Type1');
        $this->addSql('ALTER TABLE movie_has_type RENAME INDEX idx_d7417fb8f93b6fc TO IDX_D7417FB76E5D4AA');
    }
}
