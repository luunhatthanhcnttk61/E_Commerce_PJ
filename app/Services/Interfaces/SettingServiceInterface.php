<?php

namespace App\Services\Interfaces;

interface SettingServiceInterface
{
    public function getAllSettings();
    public function updateSettings($data);
}