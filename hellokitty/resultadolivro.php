<?php
$livro = isset($_GET['livro']) ? urlencode($_GET['livro']) : '';

// Validar se o termo de busca foi fornecido
if (empty($livro)) {
    echo "Por favor, forneça um título, autor ou ISBN.";
    exit;
}

// URL da API Open Library
$api_url = "https://openlibrary.org/search.json?q={$livro}";

// Realizar a requisição à API
$response = file_get_contents($api_url);

// Verificar se a resposta é válida
if ($response === FALSE) {
    echo "Não foi possível obter informações sobre o livro.";
    exit;
}

// Decodificar a resposta JSON
$data = json_decode($response, true);

// Verificar se algum livro foi encontrado
if (isset($data['docs'][0])) {
    $livro_info = $data['docs'][0];

    // Extração de dados do livro
    $titulo = $livro_info['title'] ?? 'Título não disponível';
    $autor = isset($livro_info['author_name']) ? implode(', ', $livro_info['author_name']) : 'Autor não disponível';
    $ano_publicacao = $livro_info['first_publish_year'] ?? 'Ano não disponível';
    $isbn = isset($livro_info['isbn'][0]) ? $livro_info['isbn'][0] : 'ISBN não disponível';
    $imagem_capa = isset($livro_info['cover_i']) ? "https://covers.openlibrary.org/b/id/{$livro_info['cover_i']}-L.jpg" : 'https://via.placeholder.com/150?text=Capa+não+disponível';

    // Exibir os dados do livro
    echo "<h1>Informações sobre o livro: $titulo</h1>";
    echo "<ul class='resultados'>";
    echo "<li><strong>Autor(es):</strong> $autor</li>";
    echo "<li><strong>Ano de publicação:</strong> $ano_publicacao</li>";
    echo "<li><strong>ISBN:</strong> $isbn</li>";
    echo "</ul>";

    // Exibir a capa do livro, se disponível
    echo "<div class='capa-livro'><img src='$imagem_capa' alt='Capa do livro'></div>";
} else {
    echo "<p>Nenhum livro encontrado para '$livro'. Tente novamente.</p>";
}

// Link para voltar ao formulário
echo "<br><a href='formulario.php'>Voltar à pesquisa</a>";
?>