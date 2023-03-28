<?php


include __DIR__ . '/../database/DatabaseWrapper.php';
include __DIR__ . '/../model/ProductyTypeModel.php';

class ProductTypeRepository
{
    private $productTypeModel;
    private $databaseWrapper;

    public function __construct()
    {
        $this->productTypeModel = new ProductyTypeModel();
        $this->databaseWrapper = new DatabaseWrapper();
    }

    public function create($data = []): array
    {
        return $this->databaseWrapper->insert(
            $this->productTypeModel->tableName,
            $data
        );
    }

    public function find(): array
    {
        return $this->databaseWrapper->select(
            $this->productTypeModel->tableName
        );
    }
}
