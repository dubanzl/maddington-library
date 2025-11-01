<?php
namespace Core\Repositories;

class OtherResourceRepository
{
    private static $file = __DIR__ . '/../data/otherResources.json';

    public static function findAll(): mixed
    {
        return DataStore::read(path: self::$file);
    }

    public static function add($resource): void
    {
        $resources = self::findAll();
        $resources[] = $resource;
        DataStore::write(path: self::$file, data: $resources);
    }

    public static function findById($id): mixed
    {
        $resources = self::findAll();
        foreach ($resources as $resource) {
            if ($resource['resourceId'] == $id) {
                return $resource;
            }
        }
        return null;
    }

    public static function update($id, $updatedResource): bool
    {
        $resources = self::findAll();
        foreach ($resources as $index => $resource) {
            if ($resource['resourceId'] == $id) {
                $resources[$index] = $updatedResource;
                DataStore::write(path: self::$file, data: $resources);
                return true;
            }
        }
        return false;
    }

    public static function delete($id): bool
    {
        $resources = self::findAll();
        foreach ($resources as $index => $resource) {
            if ($resource['resourceId'] == $id) {
                unset($resources[$index]);
                DataStore::write(path: self::$file, data: array_values($resources));
                return true;
            }
        }
        return false;
    }
}

