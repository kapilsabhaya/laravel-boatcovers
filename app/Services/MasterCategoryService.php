<?php

namespace App\Services;
use App\Repositories\MasterCategoryRepository;


class MasterCategoryService
{
    public function __construct(
        protected MasterCategoryRepository $masterCategory
    ) {
    }
    public function store(array $data){
        return $this->masterCategory->store($data);
    }
    public function update(array $data,$id){
        return $this->masterCategory->update($data,$id);
    }
    public function destroy($id){
        return $this->masterCategory->destroy($id);
    }
}