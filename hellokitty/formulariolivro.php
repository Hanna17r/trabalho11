<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Buscar por Livro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Buscar informações sobre um livro</h1>

    <form action="resultado.php" method="GET">
        <label for="livro">Digite o título, autor ou ISBN:</label>
        <input type="text" id="livro" name="livro" required>
        <button type="submit">Buscar</button>
    </form>
</body>
</html>
