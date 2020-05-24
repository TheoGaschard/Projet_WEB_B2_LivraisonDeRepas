<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200522155058 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE plat_commande DROP FOREIGN KEY FK_5003802682EA2E54');
        $this->addSql('ALTER TABLE plat_commande DROP FOREIGN KEY FK_50038026D73DB560');
        $this->addSql('ALTER TABLE plat_commande ADD id INT AUTO_INCREMENT NOT NULL, ADD quantit INT NOT NULL, CHANGE plat_id plat_id INT DEFAULT NULL, CHANGE commande_id commande_id INT DEFAULT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE plat_commande ADD CONSTRAINT FK_5003802682EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE plat_commande ADD CONSTRAINT FK_50038026D73DB560 FOREIGN KEY (plat_id) REFERENCES plat (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE plat_commande MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE plat_commande DROP FOREIGN KEY FK_50038026D73DB560');
        $this->addSql('ALTER TABLE plat_commande DROP FOREIGN KEY FK_5003802682EA2E54');
        $this->addSql('ALTER TABLE plat_commande DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE plat_commande DROP id, DROP quantit, CHANGE plat_id plat_id INT NOT NULL, CHANGE commande_id commande_id INT NOT NULL');
        $this->addSql('ALTER TABLE plat_commande ADD CONSTRAINT FK_50038026D73DB560 FOREIGN KEY (plat_id) REFERENCES plat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plat_commande ADD CONSTRAINT FK_5003802682EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plat_commande ADD PRIMARY KEY (plat_id, commande_id)');
    }
}
