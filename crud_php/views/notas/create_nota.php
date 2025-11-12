<?php include __DIR__ . '/../includes/header.php'; ?>
<h1>Criar Nova Nota</h1>
<form method="POST">
    <label for="titulo">Título</label>
    <input type="text" name="titulo" id="titulo" required>

    <label for="conteudo">Conteúdo</label>
    <textarea name="conteudo" id="conteudo" rows="5" required></textarea>

    <label for="produto_id">Prato</label>
    <select name="produto_id" id="produto_id" required>
        <option value="">Selecione um prato</option>
        <?php while ($p = $produtos->fetch(PDO::FETCH_ASSOC)): ?>
            <option value="<?= $p['id']; ?>"><?= htmlspecialchars($p['nome']); ?></option>
        <?php endwhile; ?>
    </select>

    <button type="submit">Salvar</button>
</form>
<?php include __DIR__ . '/../includes/footer.php'; ?>
