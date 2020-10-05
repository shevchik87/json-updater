<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201005123944 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $time = time();
        $root = "INSERT INTO myapp.users (id, login, roles, api_token, until, status) VALUES (1, 'root', '[]', '2b8ca411ae31dc27045e50287f74557e', $time, 1)";
        $user = "INSERT INTO myapp.users (id, login, roles, api_token, until, status) VALUES (2, 'user', '[]', '5b8ca411ae31dc27045e50287f74557e', $time, 1)";

        $this->addSql($root);
        $this->addSql($user);

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
