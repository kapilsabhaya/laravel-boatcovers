<?php

namespace App\Services;
use App\Repositories\DisplayProductRepository;


class DisplayProductService
{
    public function __construct(
        protected DisplayProductRepository $displayProduct
    ) {
    }

    public function getProduct(array $data , $make , $model , $year) {
        return $this->displayProduct->getProduct($data , $make , $model ,$year);
    }

    public function singleProduct($slug) {
        return $this->displayProduct->singleProduct($slug);
    }

    public function subCatPatio($param){
        return $this->displayProduct->subCatPatio($param);
    }

    public function customizeProduct($slug) {
        return $this->displayProduct->customizeProduct($slug);
    }

    public function price_increment(array $data){
        return $this->displayProduct->price_increment($data);
    }
}