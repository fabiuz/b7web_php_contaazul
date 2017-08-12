<h1>Usuários</h1>
<a href="<?php echo BASE_URL;?>/users/add">
    <div class="button">
        Adicionar Usuario
    </div>
</a>

<table border="0" width="100%">
    <tr>
        <th>E-mail</th>
        <th>Grupo de Permissões</th>
        <th>Ações</th>
    </tr>
    <?php foreach($users_list as $us): ?>

        <tr>
            <td>
                <?php echo $us['email']; ?>
            </td>
            <td width="200">
                <?php echo $us['name']; ?>
            </td>
            <td width="160">
                <a href="<?php echo BASE_URL; ?>/users/edit/<?php echo $us['id']; ?>">
                    <div class="button button_small">Editar</div>
                </a>
                <a href="<?php echo BASE_URL; ?>/users/delete/<?php echo $us['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?')">
                    <div class="button button_small">Excluir</div>
                </a>
            </td>
        </tr>

    <?php endforeach; ?>
</table>