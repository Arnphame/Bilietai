<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181122165946 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ticket_time_user (ticket_time_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_BA14052E52268469 (ticket_time_id), INDEX IDX_BA14052EA76ED395 (user_id), PRIMARY KEY(ticket_time_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ticket_time_user ADD CONSTRAINT FK_BA14052E52268469 FOREIGN KEY (ticket_time_id) REFERENCES times (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ticket_time_user ADD CONSTRAINT FK_BA14052EA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE times CHANGE name name DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE ticket_time_user');
        $this->addSql('ALTER TABLE times CHANGE name name VARCHAR(6) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
