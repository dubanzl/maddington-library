<?php
namespace Core\Controllers;

use Core\Models\OtherResource;
use Core\Repositories\OtherResourceRepository;

class OtherResourceController
{
    public static function addResource($description, $brand): void
    {
        $resources = OtherResourceRepository::findAll();
        $resource = new OtherResource(
            id: count(value: $resources) + 1,
            res_des: $description,
            res_brand: $brand,
            addedDate: date(format: 'Y-m-d')
        );
        OtherResourceRepository::add(resource: $resource);
        echo "Resource '{$resource->res_des}' added successfully.\n";
    }

    public static function listResources(): mixed
    {
        $resources = OtherResourceRepository::findAll();
        if (empty($resources)) {
            echo "No resources found.\n";
            return [];
        }
        return $resources;
    }

    public static function getResource($id): mixed
    {
        return OtherResourceRepository::findById(id: $id);
    }

    public static function editResource($id, $description, $brand): bool
    {
        $resource = self::getResource(id: $id);
        if (!$resource) {
            return false;
        }

        $updatedResource = new OtherResource(
            id: $id,
            res_des: $description,
            res_brand: $brand,
            addedDate: $resource['addedDate']
        );

        return OtherResourceRepository::update(id: $id, updatedResource: $updatedResource);
    }

    public static function deleteResource($id): bool
    {
        return OtherResourceRepository::delete(id: $id);
    }
}

