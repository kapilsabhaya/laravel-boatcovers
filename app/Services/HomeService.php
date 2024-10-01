<?php

namespace App\Services;
use App\Repositories\HomeRepository;


class HomeService
{
    public function __construct(
        protected HomeRepository $home
    ) {
    }

    public function index() {
        return $this->home->index();
    }
    
    public function handleSlug(array $data,$slug) {
        return $this->home->handleSlug($data,$slug);
    }

    public function getYear($makeId){
        return $this->home->getYear($makeId);
    }

    public function getModel($makeId ,$catId) {
        return $this->home->getModel($makeId,$catId);
    }
}