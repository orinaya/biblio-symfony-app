<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250421125559 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE category (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE category_book (category_id INT NOT NULL, book_id INT NOT NULL, PRIMARY KEY(category_id, book_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_407ED97612469DE2 ON category_book (category_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_407ED97616A2B381 ON category_book (book_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE language (id SERIAL NOT NULL, language VARCHAR(50) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE language_book (language_id INT NOT NULL, book_id INT NOT NULL, PRIMARY KEY(language_id, book_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_F9EC497D82F1BAF4 ON language_book (language_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_F9EC497D16A2B381 ON language_book (book_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE tag (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE tag_book (tag_id INT NOT NULL, book_id INT NOT NULL, PRIMARY KEY(tag_id, book_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_25EA1C87BAD26311 ON tag_book (tag_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_25EA1C8716A2B381 ON tag_book (book_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE category_book ADD CONSTRAINT FK_407ED97612469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE category_book ADD CONSTRAINT FK_407ED97616A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE language_book ADD CONSTRAINT FK_F9EC497D82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE language_book ADD CONSTRAINT FK_F9EC497D16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tag_book ADD CONSTRAINT FK_25EA1C87BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tag_book ADD CONSTRAINT FK_25EA1C8716A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE category_book DROP CONSTRAINT FK_407ED97612469DE2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE category_book DROP CONSTRAINT FK_407ED97616A2B381
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE language_book DROP CONSTRAINT FK_F9EC497D82F1BAF4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE language_book DROP CONSTRAINT FK_F9EC497D16A2B381
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tag_book DROP CONSTRAINT FK_25EA1C87BAD26311
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE tag_book DROP CONSTRAINT FK_25EA1C8716A2B381
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE category
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE category_book
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE language
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE language_book
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE tag
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE tag_book
        SQL);
    }
}
