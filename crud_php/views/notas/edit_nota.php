<?php include __DIR__ . '/../includes/header.php'; ?>
<h1>Editar Nota</h1>
<form method="POST">
    <label for="titulo">Título</label>
    <input type="text" name="titulo" id="titulo" value="<?= htmlspecialchars($notaData['titulo']); ?>" required>

    <label for="conteudo">Conteúdo</label>
    <textarea name="conteudo" id="conteudo" rows="5" required><?= htmlspecialchars($notaData['conteudo']); ?></textarea>

    <label for="produto_id">Prato</label>
    <select name="produto_id" id="produto_id" required>
        <?php while ($p = $produtos->fetch(PDO::FETCH_ASSOC)): ?>
            <option value="<?= $p['id']; ?>" <?= ($p['id'] == $notaData['produto_id']) ? 'selected' : ''; ?>>
                <?= htmlspecialchars($p['nome']); ?>
            </option>
        <?php endwhile; ?>
    </select>

    <button type="submit">Atualizar</button>
</form>
<?php include __DIR__ . '/../includes/footer.php'; ?>
