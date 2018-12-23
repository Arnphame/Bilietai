<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181122165325 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ticket_ticket_time (ticket_id INT NOT NULL, ticket_time_id INT NOT NULL, INDEX IDX_31DF8B02700047D2 (ticket_id), INDEX IDX_31DF8B0252268469 (ticket_time_id), PRIMARY KEY(ticket_id, ticket_time_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_ticket (user_id INT NOT NULL, ticket_id INT NOT NULL, INDEX IDX_F2F2B69EA76ED395 (user_id), INDEX IDX_F2F2B69E700047D2 (ticket_id), PRIMARY KEY(user_id, ticket_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ticket_ticket_time ADD CONSTRAINT FK_31DF8B02700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ticket_ticket_time ADD CONSTRAINT FK_31DF8B0252268469 FOREIGN KEY (ticket_time_id) REFERENCES times (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_ticket ADD CONSTRAINT FK_F2F2B69EA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_ticket ADD CONSTRAINT FK_F2F2B69E700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE user_tickets');
        $this->addSql('ALTER TABLE times CHANGE name name VARCHAR(6) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_tickets (user_id INT NOT NULL, ticket_id INT NOT NULL, time_id INT NOT NULL, INDEX IDX_C4B83FEA76ED395 (user_id), INDEX IDX_C4B83FE700047D2 (ticket_id), INDEX IDX_C4B83FE700047D3 (time_id), PRIMARY KEY(user_id, ticket_id, time_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_tickets ADD CONSTRAINT FK_C4B83FE700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
        $this->addSql('ALTER TABLE user_tickets ADD CONSTRAINT FK_C4B83FEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_tickets ADD CONSTRAINT FK_C4B83FEA76ED396 FOREIGN KEY (time_id) REFERENCES times (id)');
        $this->addSql('DROP TABLE ticket_ticket_time');
        $this->addSql('DROP TABLE user_ticket');
        $this->addSql('ALTER TABLE times CHANGE name name DATETIME NOT NULL');
    }
}
