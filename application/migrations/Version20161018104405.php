<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Rougin\SparkPlug\Instance;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161018104405 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $table = $schema->createTable('admins');
        $table->addColumn('id', 'integer', ['autoincrement' => true, 'unsigned' => true]);
        $table->addColumn('first_name', 'string', ['length' => 100, 'notnull' => false]);
        $table->addColumn('last_name', 'string', ['length' => 100, 'notnull' => false]);
        $table->addColumn('email', 'string', ['length' => 150]);
        $table->addColumn('username', 'string', ['length' => 100, 'notnull' => false]);
        $table->addColumn('password', 'string', ['length' => 100]);
        $table->addColumn('type', 'integer', ['notnull' => false, 'default' => 1]);
        $table->addColumn('last_login', 'datetime', ['default' => 'CURRENT_TIMESTAMP']);
        $table->addColumn('created_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
        ]);
        $table->addColumn('updated_at', 'datetime', [
            'columnDefinition' => 'TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP'
        ]);
        $table->addColumn('status', 'integer', ['notnull' => false, 'default' => 0]);
        $table->addColumn('profile_pic', 'string', ['length' => 100, 'default' => 'no_profile.jpg']);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['id', 'username', 'email']);

    }

    public function postUp(Schema $schema)
    {
        $ci = Instance::create(ROOT_PATH);
        $ci->load->library('encrypt');

        $qb = $this->connection->createQueryBuilder();
        $qb->insert('admins')
            ->values([
                'username' => '?',
                'password' => '?',
                'email' => '?',
                'type' => '?',
                'status' => '?',
                'first_name' => '?',
                'last_name' => '?'
            ])
            ->setParameter(0, 'admin')
            ->setParameter(1, $ci->encrypt->encode('Admin123'))
            ->setParameter(2, 'admin@skillagogo.com')
            ->setParameter(3, \AdminStatic::TYPE_ADMIN)
            ->setParameter(4, \AdminStatic::STATUS_ACTIVE)
            ->setParameter(5, 'Skillagogo')
            ->setParameter(6, 'Administrator');
        $qb->execute();
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('admins');
    }
}
