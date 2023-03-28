<?php

include __DIR__ . '/../database/DatabaseWrapper.php';
include __DIR__ . '/../model/SaleModel.php';

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
}
