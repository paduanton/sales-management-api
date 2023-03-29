<?php

include_once __DIR__ . '/../database/DatabaseWrapper.php';
include_once __DIR__ . '/../model/ProductModel.php';

class ProductRepository
{
    private $productModel;
    private $databaseWrapper;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->databaseWrapper = new DatabaseWrapper();
    }

    public function create($data = []): array
    {
        return $this->databaseWrapper->insert(
            $this->productModel->tableName,
            $data
        );
    }

    public function find(): array
    {
        return $this->databaseWrapper->select($this->productModel->tableName);
    }

    public function findById($id): array
    {
        $conditions = [
            'where' => [
                'id' => $id,
            ],
            'limit' => 1,
        ];
        $databaseData = $this->databaseWrapper->select(
            $this->productModel->tableName,
            $conditions
        );

        return $databaseData[0];
    }

}
