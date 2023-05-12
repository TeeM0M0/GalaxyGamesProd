<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230512080055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ajout_commandes (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, commande_id INT NOT NULL, qte INT NOT NULL, prix_unit DOUBLE PRECISION NOT NULL, INDEX IDX_32AFF1E77294869C (article_id), INDEX IDX_32AFF1E782EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ajouter (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, panier_id INT NOT NULL, qte INT NOT NULL, INDEX IDX_AB384B5F7294869C (article_id), INDEX IDX_AB384B5FF77D927C (panier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles (id INT AUTO_INCREMENT NOT NULL, classe_age_id INT NOT NULL, genre_id INT NOT NULL, platforme_id INT NOT NULL, libelle VARCHAR(50) NOT NULL, prix DOUBLE PRECISION NOT NULL, description LONGTEXT NOT NULL, editeur VARCHAR(50) NOT NULL, dev VARCHAR(50) NOT NULL, qte_stock INT NOT NULL, qte_vendu INT NOT NULL, date_sortie DATE NOT NULL, INDEX IDX_BFDD3168E4CB02D8 (classe_age_id), INDEX IDX_BFDD31684296D31F (genre_id), INDEX IDX_BFDD31684FF12FE6 (platforme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articles_langues (articles_id INT NOT NULL, langues_id INT NOT NULL, INDEX IDX_54F852F81EBAF6CC (articles_id), INDEX IDX_54F852F828EAE92 (langues_id), PRIMARY KEY(articles_id, langues_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carousel (id INT AUTO_INCREMENT NOT NULL, nom_jeu VARCHAR(255) NOT NULL, nom_image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carousel_collector (id INT AUTO_INCREMENT NOT NULL, nom_jeu VARCHAR(255) NOT NULL, nom_image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carousel_licence (id INT AUTO_INCREMENT NOT NULL, nom_jeu VARCHAR(255) NOT NULL, nom_image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classe_age (id INT AUTO_INCREMENT NOT NULL, pegi VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commandes (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, date DATETIME NOT NULL, total_prix DOUBLE PRECISION NOT NULL, INDEX IDX_35D4282CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, sujet VARCHAR(50) NOT NULL, email VARCHAR(100) NOT NULL, message LONGTEXT NOT NULL, statut SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fichier (id INT AUTO_INCREMENT NOT NULL, nom_original VARCHAR(255) NOT NULL, nom_serveur VARCHAR(255) NOT NULL, date_envoi DATETIME NOT NULL, extention VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genres (id INT AUTO_INCREMENT NOT NULL, genre VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image_article (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_972A59BA7294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE info_commande (id INT AUTO_INCREMENT NOT NULL, commande_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, code_postal VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_79DFDD1782EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE langues (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE platforme (id INT AUTO_INCREMENT NOT NULL, platforme VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, panier_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, prenom VARCHAR(20) DEFAULT NULL, nom VARCHAR(20) DEFAULT NULL, ville VARCHAR(20) DEFAULT NULL, code_postal INT DEFAULT NULL, adresse VARCHAR(150) DEFAULT NULL, num_tel INT DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649F77D927C (panier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_articles (user_id INT NOT NULL, articles_id INT NOT NULL, INDEX IDX_5F50D568A76ED395 (user_id), INDEX IDX_5F50D5681EBAF6CC (articles_id), PRIMARY KEY(user_id, articles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ajout_commandes ADD CONSTRAINT FK_32AFF1E77294869C FOREIGN KEY (article_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE ajout_commandes ADD CONSTRAINT FK_32AFF1E782EA2E54 FOREIGN KEY (commande_id) REFERENCES commandes (id)');
        $this->addSql('ALTER TABLE ajouter ADD CONSTRAINT FK_AB384B5F7294869C FOREIGN KEY (article_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE ajouter ADD CONSTRAINT FK_AB384B5FF77D927C FOREIGN KEY (panier_id) REFERENCES panier (id)');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD3168E4CB02D8 FOREIGN KEY (classe_age_id) REFERENCES classe_age (id)');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD31684296D31F FOREIGN KEY (genre_id) REFERENCES genres (id)');
        $this->addSql('ALTER TABLE articles ADD CONSTRAINT FK_BFDD31684FF12FE6 FOREIGN KEY (platforme_id) REFERENCES platforme (id)');
        $this->addSql('ALTER TABLE articles_langues ADD CONSTRAINT FK_54F852F81EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE articles_langues ADD CONSTRAINT FK_54F852F828EAE92 FOREIGN KEY (langues_id) REFERENCES langues (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commandes ADD CONSTRAINT FK_35D4282CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE image_article ADD CONSTRAINT FK_972A59BA7294869C FOREIGN KEY (article_id) REFERENCES articles (id)');
        $this->addSql('ALTER TABLE info_commande ADD CONSTRAINT FK_79DFDD1782EA2E54 FOREIGN KEY (commande_id) REFERENCES commandes (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id)');
        $this->addSql('ALTER TABLE user_articles ADD CONSTRAINT FK_5F50D568A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_articles ADD CONSTRAINT FK_5F50D5681EBAF6CC FOREIGN KEY (articles_id) REFERENCES articles (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ajout_commandes DROP FOREIGN KEY FK_32AFF1E77294869C');
        $this->addSql('ALTER TABLE ajout_commandes DROP FOREIGN KEY FK_32AFF1E782EA2E54');
        $this->addSql('ALTER TABLE ajouter DROP FOREIGN KEY FK_AB384B5F7294869C');
        $this->addSql('ALTER TABLE ajouter DROP FOREIGN KEY FK_AB384B5FF77D927C');
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD3168E4CB02D8');
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD31684296D31F');
        $this->addSql('ALTER TABLE articles DROP FOREIGN KEY FK_BFDD31684FF12FE6');
        $this->addSql('ALTER TABLE articles_langues DROP FOREIGN KEY FK_54F852F81EBAF6CC');
        $this->addSql('ALTER TABLE articles_langues DROP FOREIGN KEY FK_54F852F828EAE92');
        $this->addSql('ALTER TABLE commandes DROP FOREIGN KEY FK_35D4282CA76ED395');
        $this->addSql('ALTER TABLE image_article DROP FOREIGN KEY FK_972A59BA7294869C');
        $this->addSql('ALTER TABLE info_commande DROP FOREIGN KEY FK_79DFDD1782EA2E54');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F77D927C');
        $this->addSql('ALTER TABLE user_articles DROP FOREIGN KEY FK_5F50D568A76ED395');
        $this->addSql('ALTER TABLE user_articles DROP FOREIGN KEY FK_5F50D5681EBAF6CC');
        $this->addSql('DROP TABLE ajout_commandes');
        $this->addSql('DROP TABLE ajouter');
        $this->addSql('DROP TABLE articles');
        $this->addSql('DROP TABLE articles_langues');
        $this->addSql('DROP TABLE carousel');
        $this->addSql('DROP TABLE carousel_collector');
        $this->addSql('DROP TABLE carousel_licence');
        $this->addSql('DROP TABLE classe_age');
        $this->addSql('DROP TABLE commandes');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE fichier');
        $this->addSql('DROP TABLE genres');
        $this->addSql('DROP TABLE image_article');
        $this->addSql('DROP TABLE info_commande');
        $this->addSql('DROP TABLE langues');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE platforme');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_articles');
    }
}
