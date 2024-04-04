<?php

namespace AplikasiKas\Repository;
use AplikasiKas\Domain\Kas;

class KasRepository
{
    private \mysqli $connection;

    public function __construct(\mysqli $connection)
    {
        $this->connection = $connection;
    }
    public function save(Kas $kas): Kas
    {
        $statement = $this->connection->prepare('INSERT INTO kas (nama, tanggal_pembayaran, nominal) VALUES (?,?,?)');
        $statement->bind_param('ssi', $kas->nama, $kas->tanggal_pembayaran, $kas->nominal);
        if($statement->execute()) {
            $kas->id = $statement->insert_id;
        } else {
            echo 'ERROR';
            return $kas;
        }
        
        return $kas;
    }
    public function update(Kas $kas): Kas
    {
        $statement = $this->connection->prepare('UPDATE kas SET nama = ?, tanggal_pembayaran = ?, nominal = ? WHERE id = ?');
        $statement->bind_param('ssii', $kas->nama, $kas->tanggal_pembayaran, $kas->nominal, $kas->id);
        $statement->execute();

        return $kas;
    }
    public function remove(int $id): void
    {
        $statement = $this->connection->prepare('DELETE FROM kas WHERE id=? ');
        $statement->bind_param('i', $id);
        $statement->execute();
    }
    public function findAll(): array
    {
        $result = $this->connection->query('SELECT * FROM kas ORDER BY tanggal_pembayaran ASC');
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        $result->free_result();
        return $rows;
    }
    public function sumPerMonth(): array
    {
        $result = $this->connection->query(
            <<<SQL
                SELECT EXTRACT(MONTH FROM tanggal_pembayaran) AS bulan, SUM(nominal) AS total FROM kas
                GROUP BY EXTRACT(MONTH FROM tanggal_pembayaran)
                ORDER BY EXTRACT(MONTH FROM tanggal_pembayaran);
            SQL
        );
        $sum = $result->fetch_all(MYSQLI_ASSOC);
        $result->free_result();
        return $sum;
    }
}