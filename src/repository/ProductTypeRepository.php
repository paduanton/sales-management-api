<?php

include_once __DIR__ . '/../database/DatabaseWrapper.php';
include_once __DIR__ . '/../model/ProductTypeModel.php';

class ProductTypeRepository
{
    private $productTypeModel;
    private $databaseWrapper;

    public function __construct()
    {
        $this->productTypeModel = new ProductTypeModel();
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
