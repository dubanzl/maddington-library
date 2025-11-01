<?php
namespace Core\Repositories;

class DataStore {
    public static function read($path): mixed {
        if (!file_exists(filename: $path)) return [];
        $data = file_get_contents(filename: $path);
        return json_decode(json: $data, associative: true) ?: [];
    }

    public static function write($path, $data): void {
        file_put_contents(filename: $path, data: json_encode(value: $data, flags: JSON_PRETTY_PRINT));
  }
}
