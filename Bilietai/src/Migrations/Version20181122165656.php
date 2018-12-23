<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181122165656 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE ticket_ticket_time');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ticket_ticket_time (ticket_id INT NOT NULL, ticket_time_id INT NOT NULL, INDEX IDX_31DF8B02700047D2 (ticket_id), INDEX IDX_31DF8B0252268469 (ticket_time_id), PRIMARY KEY(ticket_id, ticket_time_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ticket_ticket_time ADD CONSTRAINT FK_31DF8B0252268469 FOREIGN KEY (ticket_time_id) REFERENCES times (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ticket_ticket_time ADD CONSTRAINT FK_31DF8B02700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id) ON DELETE CASCADE');
    }
}
