<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181122163625 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX times_id ON user_tickets');
        $this->addSql('ALTER TABLE user_tickets DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE user_tickets DROP times_id');
        $this->addSql('ALTER TABLE user_tickets ADD PRIMARY KEY (user_id, ticket_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_tickets DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE user_tickets ADD times_id INT NOT NULL');
        $this->addSql('CREATE INDEX times_id ON user_tickets (times_id)');
        $this->addSql('ALTER TABLE user_tickets ADD PRIMARY KEY (ticket_id)');
    }
}
