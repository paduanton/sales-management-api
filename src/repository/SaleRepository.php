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
        var_dump($this->saleModel->tableName);
        return $this->databaseWrapper->select($this->saleModel->tableName);
    }

    public function getProductsMoneyData($productIds): array
    {
        $query = `
            SELECT
                products.id as productId,
                products.price as price,
                product_types.tax_percentage as taxPercentage,
                products.name as productName
            FROM
                products
            INNER JOIN product_types
                ON products.product_type_id = product_types.id
            WHERE products.id IN (:ids);
        `;

        $databaseData = $this->databaseWrapper->runCustomQueryOnSpecificParameter(
            $query,
            $productIds,
            "ids"
        );

        return $databaseData[0];
    }
}
