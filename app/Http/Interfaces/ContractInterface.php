<?php

namespace App\Http\Interfaces;

interface ContractInterface
{
    public function upload(object $data): array;

    public function store(array $contracts);
}
