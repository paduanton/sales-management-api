<?php

include_once __DIR__ . '/../repository/SaleRepository.php';

class SaleBusiness
{
    private $saleRepository;

    public function __construct()
    {
        $this->saleRepository = new SaleRepository();
    }

    public function getAllSales(): array
    {
        $sales = $this->saleRepository->find();

        // return $sales;

        foreach ($sales as $key => $sale) {
            $productIds = json_decode($sale['products']);
            $productIds = implode(',', $productIds);
            $moneyInfo = $this->saleRepository->getProductsMoneyData(
                $productIds
            );


            $sales[$key]["products"] = $moneyInfo;
        }


        return $sales;
    }

    public function storeSale($saleData = []): array
    {
        return $this->saleRepository->create($saleData);
    }
}
