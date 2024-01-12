<?php

namespace App\DTO\Permissions;

class UpdatePermissionDTO extends CreatePermissionDTO
{
    public function __construct(
        readonly public string $id,
        readonly public string $name,
        readonly public string $description,
    ) {
    }
}