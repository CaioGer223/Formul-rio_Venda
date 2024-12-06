<?php
// Configurações do banco de dados
$host = 'localhost';
$dbname = 'formularioVenda';
$user = 'root';
$password = '';

try {
    // Conexão com o banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

// Função para criar um registro
function create($pdo, $titulo, $valor, $descricao, $marca, $modelo, $quilometragem, $dataCompra, $cambio, $opcionais) {

    $sql = "INSERT INTO usuarios (titulo, valor, descricao, marca, modelo, quilometragem, dataCompra, cambio, opcionais) 
            VALUES (:titulo, :valor, :descricao, :marca, :modelo, :quilometragem, :dataCompra, :cambio, :opcionais)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        'titulo' => $titulo, 
        'valor' => $valor, 
        'descricao' => $descricao, 
        'marca' => $marca, 
        'modelo' => $modelo, 
        'quilometragem' => $quilometragem, 
        'dataCompra' => $dataCompra, 
        'cambio' => $cambio, 
        'opcionais' => $opcionais
    ]);

    echo "Registro criado com sucesso!";
}

// Função para ler registros
function read($pdo) {

    $sql = "SELECT * FROM usuarios";

    $stmt = $pdo->query($sql);

    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($resultados as $usuario) {
        echo "ID: {$usuario['id']}, Título: {$usuario['titulo']}, Valor: {$usuario['valor']}, Descrição: {$usuario['descricao']}, 
              Marca: {$usuario['marca']}, Modelo: {$usuario['modelo']}, Quilometragem: {$usuario['quilometragem']}, 
              Data de Compra: {$usuario['dataCompra']}, Câmbio: {$usuario['cambio']}, Opcionais: {$usuario['opcionais']}<br>";
    }
}

// Função para atualizar um registro
function update($pdo, $id, $titulo, $valor, $descricao, $marca, $modelo, $quilometragem, $dataCompra, $cambio, $opcionais) {

    $sql = "UPDATE usuarios SET titulo = :titulo, valor = :valor, descricao = :descricao, marca = :marca, modelo = :modelo, quilometragem = :quilometragem, dataCompra = :dataCompra, cambio = :cambio, opcionais = :opcionais WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        'id' => $id, 
        'titulo' => $titulo, 
        'valor' => $valor, 
        'descricao' => $descricao, 
        'marca' => $marca, 
        'modelo' => $modelo, 
        'quilometragem' => $quilometragem, 
        'dataCompra' => $dataCompra, 
        'cambio' => $cambio, 
        'opcionais' => $opcionais
    ]);

    echo "Registro atualizado com sucesso!";
}

// Função para deletar um registro
function delete($pdo, $id) {

    $sql = "DELETE FROM usuarios WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute(['id' => $id]);

    echo "Registro deletado com sucesso!";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $operacao = $_POST['operacao'];

    switch ($operacao) {

        case 'create':
            $titulo = $_POST['titulo'];
            $valor = $_POST['valor'];
            $descricao = $_POST['descricao'];
            $marca = $_POST['marca'];
            $modelo = $_POST['modelo'];
            $quilometragem = $_POST['quilometragem'];
            $dataCompra = $_POST['dataCompra'];
            $cambio = $_POST['cambio'];
            $opcionais = $_POST['opcionais'];
            create($pdo, $titulo, $valor, $descricao, $marca, $modelo, $quilometragem, $dataCompra, $cambio, $opcionais);
            break;

        case 'read':

            read($pdo);
            break;
            
        case 'update':

            $id = $_POST['id'];
            $titulo = $_POST['titulo'];
            $valor = $_POST['valor'];
            $descricao = $_POST['descricao'];
            $marca = $_POST['marca'];
            $modelo = $_POST['modelo'];
            $quilometragem = $_POST['quilometragem'];
            $dataCompra = $_POST['dataCompra'];
            $cambio = $_POST['cambio'];
            $opcionais = $_POST['opcionais'];
            update($pdo, $id, $titulo, $valor, $descricao, $marca, $modelo, $quilometragem, $dataCompra, $cambio, $opcionais);
            break;

        case 'delete':

            $id = $_POST['id'];
            delete($pdo, $id);
            break;

        default:
        
            echo "Operação inválida.<br>";
    }
}
?>
