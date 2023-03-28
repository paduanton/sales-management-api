<?php


include __DIR__ . '/../database/DatabaseWrapper.php';
include __DIR__ . '/../model/ProductModel.php';

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
        return $this->databaseWrapper->select(
            $this->productModel->tableName
        );
    }
}
