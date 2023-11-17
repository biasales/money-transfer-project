<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTransactionsTable extends AbstractMigration
{
    public function change(): void
    {
        $sql = <<< SQL
CREATE TABLE transaction (
        id INT PRIMARY KEY AUTO_INCREMENT,
    payee_id INT NOT NULL,
    payer_id INT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    currency_iso VARCHAR(3) NOT NULL,
    status VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    finished_at TIMESTAMP DEFAULT NULL,
    FOREIGN KEY (payee_id) REFERENCES users(id),
    FOREIGN KEY (payer_id) REFERENCES users(id)
);
SQL;
        $this->execute($sql);
    }
}
