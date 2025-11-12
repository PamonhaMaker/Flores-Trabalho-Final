<?php include __DIR__ . '/../includes/header.php'; ?>
<h1>Notas dos Pratos</h1>
<a href="index.php?page=notas&action=create" class="button">+ Nova Nota</a>
<table>
    <thead>
        <tr>
            <th>Prato</th>
            <th>Título</th>
            <th>Conteúdo</th>
            <th>Data</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?= htmlspecialchars($row['produto_nome']); ?></td>
                <td><?= htmlspecialchars($row['titulo']); ?></td>
                <td><?= htmlspecialchars($row['conteudo']); ?></td>
                <td><?= $row['data_criacao']; ?></td>
                <td>
                    <a href="index.php?page=notas&action=edit&id=<?= $row['id']; ?>" class="button edit">Editar</a>
                    <a href="index.php?page=notas&action=delete&id=<?= $row['id']; ?>" class="button delete" onclick="return confirm('Deseja excluir esta nota?')">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php include __DIR__ . '/../includes/footer.php'; ?>
