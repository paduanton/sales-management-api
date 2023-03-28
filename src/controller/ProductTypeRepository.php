<?php

include_once 'ProductyTypeModel.php';
include_once 'DatabaseWrapper.php';

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
