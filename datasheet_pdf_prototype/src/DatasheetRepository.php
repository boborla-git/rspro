<?php

class DatasheetRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getProduct(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM datasheet_prodotti WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function getSpecifications(int $productId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT sezione, attributo, valore, ordinamento
             FROM datasheet_specifiche
             WHERE prodotto_id = :id
             ORDER BY sezione_ordinamento, ordinamento, id'
        );
        $stmt->execute(['id' => $productId]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $sections = [];
        foreach ($rows as $row) {
            $sections[$row['sezione']][] = $row;
        }
        return $sections;
    }

    public function getSimilarProducts(int $productId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT stock_no, brand, product_name, attribute_1, attribute_2, attribute_3
             FROM datasheet_prodotti_simili
             WHERE prodotto_id = :id
             ORDER BY ordinamento, id'
        );
        $stmt->execute(['id' => $productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
