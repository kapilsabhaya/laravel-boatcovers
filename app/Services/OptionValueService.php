<?php

namespace App\Services;
use App\Repositories\OptionValueRepository;


class OptionValueService
{
    public function __construct(
        protected OptionValueRepository $optionValue
    ) {
    }

    public function store(array $data){
        return $this->optionValue->store($data);
    }
    public function update(array $data,$id){
        return $this->optionValue->update($data,$id);
    }
    public function destroy($id){
        return $this->optionValue->destroy($id);
    }
}