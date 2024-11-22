<?php
// Mapeamento de países em português para inglês
$paises_map = [
    "alemanha" => "germany",
    "argentina" => "argentina",
    "brasil" => "brazil",
    "canada" => "canada",
    "chile" => "chile",
    "franca" => "france",
    "estados unidos" => "united states",
    "japao" => "japan",
    "portugal" => "portugal",
    // Adicione mais países conforme necessário
];

// Verificar se o parâmetro 'pais' foi enviado via GET
$pais = isset($_GET['pais']) ? strtolower($_GET['pais']) : '';

// Se o país não for encontrado no mapa, exibir mensagem de erro
if (empty($pais) || !isset($paises_map[$pais])) {
    echo "País não encontrado ou inválido. Tente novamente com o nome em português.";
    exit;
}

// Obter o nome do país no formato em inglês
$pais_ingles = $paises_map[$pais];

// URL da API REST Countries
$api_url = "https://restcountries.com/v3.1/name/{$pais_ingles}?fullText=true";

// Realizar a requisição à API
$response = file_get_contents($api_url);

// Verificar se a requisição foi bem-sucedida
if ($response === FALSE) {
    echo "Não foi possível obter informações sobre o país.";
    exit;
}

// Decodificar a resposta JSON da API
$data = json_decode($response, true);

// Verificar se o país foi encontrado
if (isset($data[0])) {
    // Obter os dados do país
    $country = $data[0];
    $nome_pais = $country['name']['common'] ?? 'Nome não disponível';
    $capital = $country['capital'][0] ?? 'Capital não disponível';
    $populacao = $country['population'] ?? 'População não disponível';
    $area = $country['area'] ?? 'Área não disponível';
    $regiao = $country['region'] ?? 'Região não disponível';
    $subregiao = $country['subregion'] ?? 'Sub-região não disponível';
    $bandeira = $country['flags']['svg'] ?? '#';

    // Exibir os dados do país
    echo "<h1>Informações sobre o país: $nome_pais</h1>";
    echo "<ul class='resultados'>";
    echo "<li><strong>Capital:</strong> $capital</li>";
    echo "<li><strong>População:</strong> $populacao</li>";
    echo "<li><strong>Área:</strong> $area km²</li>";
    echo "<li><strong>Região:</strong> $regiao</li>";
    echo "<li><strong>Sub-região:</strong> $subregiao</li>";
    echo "<li><strong>Bandeira:</strong><br><img src='$bandeira' alt='Bandeira de $nome_pais'></li>";
    echo "</ul>";
} else {
    echo "<p>País não encontrado: '$pais'. Tente novamente.</p>";
}

// Link para voltar ao formulário
echo "<br><a href='buscar_pais.html'>Voltar à pesquisa</a>";
?>