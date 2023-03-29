<?php

include_once __DIR__ . '/../database/DatabaseWrapper.php';
include_once __DIR__ . '/../model/SaleModel.php';

class SaleRepository
{
    private $saleModel;
    private $databaseWrapper;

    public function __construct()
    {
        $this->saleModel = new SaleModel();
        $this->databaseWrapper = new DatabaseWrapper();
    }

    public function create($data = []): array
    {
        return $this->databaseWrapper->insert(
            $this->saleModel->tableName,
            $data
        );
    }

    public function find(): array
    {
        return $this->databaseWrapper->select($this->saleModel->tableName);
    }

    public function getProductsMoneyData($productIds): array
    {
        $query = <<<EOT
            SELECT
                products.id as product_id,
                products.price as price,
                product_types.tax_percentage as tax_percentage,
                products.name as product_name
            FROM
                products
            INNER JOIN product_types
                ON products.product_type_id = product_types.id
            WHERE products.id IN ($productIds);
        EOT;

        $databaseData = $this->databaseWrapper->runCustomQuery($query);

        return $databaseData;
    }
}
