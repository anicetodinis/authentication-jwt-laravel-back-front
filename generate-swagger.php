<?php

require_once __DIR__ . '/vendor/autoload.php';

// Diretório para armazenar os arquivos gerados
$docsDir = __DIR__ . '/storage/api-docs';
if (!is_dir($docsDir)) {
    mkdir($docsDir, 0755, true);
}

try {
    // Usar o analysisger do swagger-php para processar as anotações
    $openapi = \OpenAPI\Generator::scan([base_path('app/Http/Controllers')]);

    // Guardar o arquivo JSON
    file_put_contents(
        $docsDir . '/api-docs.json',
        json_encode($openapi, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
    );

    echo "✓ Documentação Swagger gerada com sucesso!\n";
    echo "  Arquivo: {$docsDir}/api-docs.json\n";
} catch (\Exception $e) {
    echo "✗ Erro ao gerar documentação Swagger: " . $e->getMessage() . "\n";
    exit(1);
}

