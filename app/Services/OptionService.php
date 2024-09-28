<?php

namespace App\Services;
use App\Repositories\OptionRepository;


class OptionService
{
    public function __construct(
        protected OptionRepository $option
    ) {
    }

    public function store(array $data){
        return $this->option->store($data);
    }
    public function update(array $data,$id){
        return $this->option->update($data,$id);
    }
    public function destroy($id){
        return $this->option->destroy($id);
    }
}