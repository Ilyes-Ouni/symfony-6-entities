<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230307142742 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->getTable('article');
        $table->addColumn('category_id', Types::INTEGER);
        
        // Check if the foreign key constraint exists and drop it if it does
        if ($table->hasForeignKey('fk_article_category')) {
            $table->removeForeignKey('fk_article_category');
        }
    
        $table->addForeignKeyConstraint(
            'category',
            ['category_id'],
            ['id'],
            ['onDelete' => 'CASCADE'],
            'fk_article_category'
        );

    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE article DROP CONSTRAINT FK_article_category');
        $this->addSql('ALTER TABLE article DROP category_id');
    }
}
