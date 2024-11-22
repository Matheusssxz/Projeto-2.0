<?php
try {
    // Conectar ao banco de dados SQLite usando SQLite3
    $db = new SQLite3("./users.db");
    
} catch (Exception $e) {
    echo "Erro ao conectar ao SQLite: " . $e->getMessage();
}
?>