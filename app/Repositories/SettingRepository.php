<?php

namespace App\Repositories;

use App\Models\Setting;
use App\Repositories\Interfaces\SettingRepositoryInterface;

class SettingRepository implements SettingRepositoryInterface
{
    protected $model;

    public function __construct(Setting $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getByKey($key)
    {
        return $this->model->where('key', $key)->first();
    }

    public function updateMultiple(array $data)
    {
        try {
            foreach($data as $key => $value) {
                $this->model->updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function updateByKey($key, $value)
    {
        $setting = $this->getByKey($key);
        if($setting) {
            return $setting->update(['value' => $value]);
        }
        return false;
    }
}