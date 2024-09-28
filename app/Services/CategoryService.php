<?php

namespace App\Services;
use App\Repositories\CategoryRepository;


class CategoryService
{
    public function __construct(
        protected CategoryRepository $category
    ) {
    }
    
    public function store(array $data) {
        return $this->category->store($data);
    }
    public function update(array $data,$id) {
        return $this->category->update($data,$id);
    }
    public function destroy($id){
        return $this->category->destroy($id);
    }
}