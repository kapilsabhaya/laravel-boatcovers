<?php

namespace App\Services;
use App\Repositories\ProductRepository;


class ProductService
{
    public function __construct(
        protected ProductRepository $product
    ) {
    }
    public function store(array $data){
        return $this->product->store($data);
    }
    public function update(array $data,$id){
        return $this->product->update($data,$id);
    }
    public function destroy($id) {
        return $this->product->destroy($id);
    }
}