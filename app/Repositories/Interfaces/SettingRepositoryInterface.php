<?php

namespace App\Repositories\Interfaces;

interface SettingRepositoryInterface 
{
    public function getAll();
    public function getByKey($key);
    public function updateMultiple(array $data);
    public function updateByKey($key, $value);
}