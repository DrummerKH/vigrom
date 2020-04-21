<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200421183427 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE account (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7D3656A45E237E06 ON account (name)');
        $this->addSql('CREATE TABLE currency (id SERIAL NOT NULL, code VARCHAR(3) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6956883F77153098 ON currency (code)');
        $this->addSql('CREATE TABLE rates (id SERIAL NOT NULL, currency_id INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, rate NUMERIC(12, 6) NOT NULL CHECK (rate >= 0), PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_44D4AB3C38248176 ON rates (currency_id)');
        $this->addSql('CREATE TABLE reason (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3BB8880C5E237E06 ON reason (name)');
        $this->addSql('CREATE TABLE transaction (id SERIAL NOT NULL, wallet_id INT NOT NULL, reason_id INT NOT NULL, amount INT NOT NULL CHECK (amount != 0), created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_723705D1712520F3 ON transaction (wallet_id)');
        $this->addSql('CREATE INDEX IDX_723705D159BB1592 ON transaction (reason_id)');
        $this->addSql('CREATE TABLE wallet (id SERIAL NOT NULL, currency_id INT NOT NULL, account_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7C68921F38248176 ON wallet (currency_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7C68921F9B6B5FBA ON wallet (account_id)');
        $this->addSql('CREATE TABLE cron_job (id INT NOT NULL, name VARCHAR(191) NOT NULL, command VARCHAR(1024) NOT NULL, schedule VARCHAR(191) NOT NULL, description VARCHAR(191) NOT NULL, enabled BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX un_name ON cron_job (name)');
        $this->addSql('CREATE TABLE cron_report (id SERIAL NOT NULL, job_id INT DEFAULT NULL, run_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, run_time DOUBLE PRECISION NOT NULL, exit_code INT NOT NULL, output TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B6C6A7F5BE04EA9 ON cron_report (job_id)');
        $this->addSql('ALTER TABLE rates ADD CONSTRAINT FK_44D4AB3C38248176 FOREIGN KEY (currency_id) REFERENCES currency (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1712520F3 FOREIGN KEY (wallet_id) REFERENCES wallet (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D159BB1592 FOREIGN KEY (reason_id) REFERENCES reason (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE wallet ADD CONSTRAINT FK_7C68921F38248176 FOREIGN KEY (currency_id) REFERENCES currency (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE wallet ADD CONSTRAINT FK_7C68921F9B6B5FBA FOREIGN KEY (account_id) REFERENCES account (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cron_report ADD CONSTRAINT FK_B6C6A7F5BE04EA9 FOREIGN KEY (job_id) REFERENCES cron_job (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_44D4AB3CAA9E377A38248176 ON rates (date, currency_id)');
        $this->addSql("INSERT INTO cron_job (id, name, command, schedule, description, enabled) VALUES (1, 'currency', 'currency:get-rates', '* * * * *', '', true)");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE wallet DROP CONSTRAINT FK_7C68921F9B6B5FBA');
        $this->addSql('ALTER TABLE rates DROP CONSTRAINT FK_44D4AB3C38248176');
        $this->addSql('ALTER TABLE wallet DROP CONSTRAINT FK_7C68921F38248176');
        $this->addSql('ALTER TABLE transaction DROP CONSTRAINT FK_723705D159BB1592');
        $this->addSql('ALTER TABLE transaction DROP CONSTRAINT FK_723705D1712520F3');
        $this->addSql('ALTER TABLE cron_report DROP CONSTRAINT FK_B6C6A7F5BE04EA9');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE currency');
        $this->addSql('DROP TABLE rates');
        $this->addSql('DROP TABLE reason');
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE wallet');
        $this->addSql('DROP TABLE cron_job');
        $this->addSql('DROP TABLE cron_report');
    }
}
