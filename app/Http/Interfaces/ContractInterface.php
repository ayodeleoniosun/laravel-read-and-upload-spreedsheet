<?php

namespace App\Http\Interfaces;

interface ContractInterface
{
    public function index(object $request): array;

    public function find(int $find, string $status = null): array;
    
    public function upload(object $request): array;

    public function store(array $request);
}
