<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250421120158 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE author (id SERIAL NOT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) NOT NULL, birthday DATE DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE author_book (author_id INT NOT NULL, book_id INT NOT NULL, PRIMARY KEY(author_id, book_id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2F0A2BEEF675F31B ON author_book (author_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2F0A2BEE16A2B381 ON author_book (book_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE book (id SERIAL NOT NULL, title VARCHAR(255) NOT NULL, desciption TEXT DEFAULT NULL, date DATE DEFAULT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE author_book ADD CONSTRAINT FK_2F0A2BEEF675F31B FOREIGN KEY (author_id) REFERENCES author (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE author_book ADD CONSTRAINT FK_2F0A2BEE16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE author_book DROP CONSTRAINT FK_2F0A2BEEF675F31B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE author_book DROP CONSTRAINT FK_2F0A2BEE16A2B381
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE author
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE author_book
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE book
        SQL);
    }
}
