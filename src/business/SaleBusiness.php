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

        return $sales;
        foreach ($sales as $sale) {
            $productIds = json_decode($sale['producs']);
            $productIds = implode(",",$productIds);

            $productsData = [];
            var_dump($productIds);
        }
        //     foreach ($productIds as $productId) {
        //         $productTypeData = $this->saleRepository->getProductsMoneyData(
        //             $productId
        //         );
    
        //         array_push($productsData, $productTypeData);
        //     }
        // }


    }

    public function storeSale($saleData = []): array
    {
        return $this->saleRepository->create($saleData);
    }

}
