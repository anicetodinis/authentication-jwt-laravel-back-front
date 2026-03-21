<?php

return [
    'default' => 'default',
    'documentations' => [
        'default' => [
            'api' => [
                'title' => 'Furo API',
                'version' => 'v1',
            ],
            'routes' => [
                /*
                 * Route for accessing api documentation interface, e.g. `/api/documentation`
                 */
                'api' => 'api/documentation',
            ],
            'paths' => [
                /*
                 * Absolute path to location of comment blocks in your project.
                 * Use this to scan multiple directories or files for API documentation.
                 */
                'annotations' => [
                    base_path('app/Http/Controllers'),
                ],

                /*
                 * absolute path to directory that you want to exclude from scanning.
                 * @example: storage/swagger-ui/excluded-files.php
                 */
                'excluded' => [],

                /*
                 * path from `swagger_path`/`paths` property. Complete path to JSON Schema object.
                 * Used on translation file name resolution.
                 */
                'docs_json' => 'api-docs.json',

                /*
                 * Absolute path to directory where the generated documentation will be stored
                 */
                'docs_dir' => base_path('storage/api-docs'),

                /*
                 * File name of the generated documentation. Default value: 'swagger.json'
                 */
                'swagger_ui_path' => 'api-docs',

                /*
                 * Full path to the folder where to save swagger ui files
                 */
                'swagger_ui_folder' => 'vendor/swagger-api/swagger-ui/dist',
            ],
            'securityDefinitions' => [
                'api_key_security_example' => [ // Unique name of security
                    'type' => 'apiKey', // The type of the security scheme. Valid values are "basic", "apiKey" or "oauth2".
                    'description' => 'A short description for security scheme',
                    'name' => 'api_key', // The name of the header, query or cookie parameter to be used.
                    'in' => 'header', // The location of the API key. Valid values are "query", "header" or "cookie".
                ],
                'sanctum' => [
                    'type' => 'apiKey',
                    'description' => 'Laravel Sanctum token',
                    'name' => 'Authorization',
                    'in' => 'header',
                ],
            ],
            'operationIds' => [
                /*
                 * todo Improve operationIds strategy
                 * @link https://swagger.io/docs/specification/paths-and-operations/
                 * @link https://stackoverflow.com/questions/51744139/what-is-operationid-in-swagger-definition
                 */
                'enabled' => env('L5_SWAGGER_OPERATION_ID_ENABLED', true),
            ],
            'consumes' => [
                'application/json',
            ],
            'produces' => [
                'application/json',
            ],
            'swagger_version' => '3.0',
            'swagger_ui_url' => '/api/documentation',
            'constants' => [
                'L5_SWAGGER_CONST_HOST' => env('L5_SWAGGER_CONST_HOST', ''),
            ],
        ],
    ],
    'defaults' => [
        'controllers_sort' => env('L5_SWAGGER_CONTROLLERS_SORT', 'alpha'),
        'scanOptions' => [
            'analysis' => env('L5_SWAGGER_SCAN_USE_ENUMS', false) ? null : static function(\DocBlockParser\Reflection\ClassReflection $class): bool {
                if ($class->isAbstract()) {
                    return false;
                }
                // Only scan controllers
                return str_contains($class->getName(), 'Controller');
            },
            'patternFilter' => env('L5_SWAGGER_PATTERN_FILTER', '/*Controller.php'),
        ],
        'securityDefinitions' => [
            'securitySchemes' => [
                'bearerAuth' => [
                    'type' => 'http',
                    'scheme' => 'bearer',
                    'bearerFormat' => 'JWT',
                ]
            ]
        ],
        'open_api_strict' => false,
    ],
];
