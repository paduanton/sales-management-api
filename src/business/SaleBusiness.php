<?php

include_once __DIR__ . '/../repository/SaleRepository.php';

class SaleBusiness
{
    private $saleRepository;

    public function __construct()
    {
        $this->saleRepository = new SaleRepository();
    }

    public function getSalePreview($productIds): array
    {
        $ids = explode(",",$productIds);
        $parsedProductAmountInfo = [];
        $parsedProductIds = [];

        foreach ($ids as $key => $id) {
            $parsedProductId = [];

            if(str_contains($id, '*')) {
                $parsedProductId = explode("*", $id);
                $parsedProductId = [
                    "productId" => $parsedProductId[0],
                    "quantity" => intval($parsedProductId[1])
                ];

            } else {
                $parsedProductId = [
                    "productId" => $id,
                    "quantity" => 1
                ];
            }

            array_push($parsedProductIds, $parsedProductId["productId"]);
            array_push($parsedProductAmountInfo, $parsedProductId);
        }


        
        return [];
    }

    function searchForProductId($id, $productList) {

        foreach ($productList as $key => $value) {
            if ($value->id == $id) {
                return $productList[$key];
            }
        }
        return null;
    }

    public function getAllSales(): array
    {
        $sales = $this->saleRepository->find();

        foreach ($sales as $key => $sale) {
            $products = json_decode($sale['products']);
            
            $getProductId = function ($product)
            {
                return $product->id;
            };

            $productIds = array_map($getProductId, $products);
            $productIds = implode(',', $productIds);

            $productsMoneyInfo = $this->saleRepository->getProductsMoneyData(
                $productIds
            );

            foreach ($productsMoneyInfo as $productKey => $productMoneyInfo) {
                $productsMoneyInfo[$productKey]['price_per_item'] = floatval(
                    $productsMoneyInfo[$productKey]['price']
                );
                $productsMoneyInfo[$productKey]['tax_percentage'] = floatval(
                    $productsMoneyInfo[$productKey]['tax_percentage']
                );
                $productsMoneyInfo[$productKey]['tax_value_per_item'] =
                    $productsMoneyInfo[$productKey]['tax_percentage'] *
                    $productsMoneyInfo[$productKey]['price'];
              
                $product = $this->searchForProductId($productMoneyInfo['product_id'], $products);

                $productsMoneyInfo[$productKey]['total_tax_value'] = $productsMoneyInfo[$productKey]['tax_value_per_item'] * $product->quantity;
                $productsMoneyInfo[$productKey]['total_price'] = $productsMoneyInfo[$productKey]['price_per_item'] * $product->quantity;
                $productsMoneyInfo[$productKey]['total_items'] = $product->quantity;

                unset($productsMoneyInfo[$productKey]['price']);
            }

            $sales[$key]['products'] = $productsMoneyInfo;
        }

        return $sales;
    }

    public function storeSale($saleData = []): array
    {
        $sale = $this->saleRepository->create($saleData);
        $sale["products"] = json_decode($sale['products']);

        return $sale;
    }
}
