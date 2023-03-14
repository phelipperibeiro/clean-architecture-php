<?php

declare(strict_types=1);

namespace App\Infra\Adapters;

use App\Application\Contracts\Storage;

final class LocalStorageAdapter implements Storage
{
    public function store(string $fileName, string $path, string $content)
    {
        if (!is_dir($path = $path . DIRECTORY_SEPARATOR)) {
            mkdir($path, 0777, true);
        }
        file_put_contents($path . $fileName, $content);
    }
}
