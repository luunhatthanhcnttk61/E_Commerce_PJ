<?php

namespace App\Services;

use App\Repositories\Interfaces\SettingRepositoryInterface as SettingRepository;
use App\Services\Interfaces\SettingServiceInterface;

class SettingService implements SettingServiceInterface
{
    protected $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function getAllSettings()
    {
        return $this->settingRepository->getAll();
    }

    public function updateSettings($data)
    {
        return $this->settingRepository->updateMultiple($data);
    }
}