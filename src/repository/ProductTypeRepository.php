<?php

include_once '../model/ProductyTypeModel.php';
include_once '../database/DatabaseWrapper.php';

class ProductTypeRepository
{
    private $productTypeModel;
    private $databaseWrapper;

    public function __construct(
        ProductyTypeModel $productTypeModel,
        DatabaseWrapper $databaseWrapper
    ) {
        $this->productTypeModel = $productTypeModel;
        $this->databaseWrapper = $databaseWrapper;
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
