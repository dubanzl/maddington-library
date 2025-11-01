<?php
namespace Core\CLI\Handlers;

use Core\CLI\ConsoleUI;
use Core\Controllers\OtherResourceController;

class OtherResourceMenuHandler
{
    public static function add(): void
    {
        ConsoleUI::title(title: "Add New Resource");

        $description = ConsoleUI::ask(question: "Resource Description");
        $brand = ConsoleUI::ask(question: "Brand");

        OtherResourceController::addResource(description: $description, brand: $brand);
        ConsoleUI::success(message: "Resource added successfully!");
        ConsoleUI::info(text: "Press Enter to continue...");
        fgets(stream: STDIN);
    }

    public static function list(): void
    {
        ConsoleUI::title(title: "All Resources");
        $resources = OtherResourceController::listResources();

        if (empty($resources)) {
            ConsoleUI::warning(text: "No resources available.");
        } else {
            $rows = array_map(
                callback: fn($r): array => [
                    $r['resourceId'],
                    $r['resourceCategory'],
                    $r['res_brand'],
                    $r['addedDate']
                ],
                array: $resources
            );
            ConsoleUI::table(headers: ['ID', 'Description', 'Brand', 'Added Date'], rows: $rows);
        }

        ConsoleUI::info(text: "Press Enter to go back...");
        fgets(stream: STDIN);
    }

    public static function edit(): void
    {
        ConsoleUI::title(title: "Edit Resource");
        $resources = OtherResourceController::listResources();

        if (empty($resources)) {
            ConsoleUI::warning(text: "No resources available to edit.");
            ConsoleUI::info(text: "Press Enter to continue...");
            fgets(stream: STDIN);
            return;
        }

        self::displayResourcesTable(resources: $resources);

        $id = ConsoleUI::ask(question: "Enter Resource ID to edit");
        $resource = OtherResourceController::getResource(id: $id);

        if (!$resource) {
            ConsoleUI::warning(text: "Resource not found!");
            ConsoleUI::info(text: "Press Enter to continue...");
            fgets(stream: STDIN);
            return;
        }

        $description = ConsoleUI::ask(question: "Resource Description", default: $resource['resourceCategory']);
        $brand = ConsoleUI::ask(question: "Brand", default: $resource['res_brand']);

        $success = OtherResourceController::editResource(
            id: $id,
            description: $description,
            brand: $brand
        );

        if ($success) {
            ConsoleUI::success(message: "Resource updated successfully!");
        } else {
            ConsoleUI::warning(text: "Failed to update resource!");
        }

        ConsoleUI::info(text: "Press Enter to continue...");
        fgets(stream: STDIN);
    }

    public static function delete(): void
    {
        ConsoleUI::title(title: "Delete Resource");
        $resources = OtherResourceController::listResources();

        if (empty($resources)) {
            ConsoleUI::warning(text: "No resources available to delete.");
            ConsoleUI::info(text: "Press Enter to continue...");
            fgets(stream: STDIN);
            return;
        }

        self::displayResourcesTable(resources: $resources);

        $id = ConsoleUI::ask(question: "Enter Resource ID to delete");
        $resource = OtherResourceController::getResource(id: $id);

        if (!$resource) {
            ConsoleUI::warning(text: "Resource not found!");
            ConsoleUI::info(text: "Press Enter to continue...");
            fgets(stream: STDIN);
            return;
        }

        $confirm = ConsoleUI::ask(
            question: "Are you sure you want to delete '{$resource['resourceCategory']}'? (yes/no)",
            default: "no"
        );

        if (strtolower(string: $confirm) === 'yes') {
            $success = OtherResourceController::deleteResource(id: $id);

            if ($success) {
                ConsoleUI::success(message: "Resource deleted successfully!");
            } else {
                ConsoleUI::warning(text: "Failed to delete resource!");
            }
        } else {
            ConsoleUI::info(text: "Delete cancelled.");
        }

        ConsoleUI::info(text: "Press Enter to continue...");
        fgets(stream: STDIN);
    }

    private static function displayResourcesTable(array $resources): void
    {
        $rows = array_map(
            callback: fn($r): array => [
                $r['resourceId'],
                $r['resourceCategory'],
                $r['res_brand'],
                $r['addedDate']
            ],
            array: $resources
        );
        ConsoleUI::table(headers: ['ID', 'Description', 'Brand', 'Added Date'], rows: $rows);
    }
}

