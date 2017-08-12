<h1>Permissões</h1>

<div class="tabarea">
    <div class="tabitem" id="tabitem1">
        Grupos de permissões
    </div>
    <div class="tabitem" id="tabitem2">
        Permissões

    </div>
</div>
<div class="tabcontent">
    <div class="tabbody" style="display:block">
        <a href="<?php echo BASE_URL;?>/permissions/add_group">
            <div class="button">
                Adicionar Grupo de Permissões
            </div>
        </a>

        <table border="0" width="100%">
            <tr>
                <th>Nome do Grupo de Permissões</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($permissions_groups_list as $p): ?>
                <tr>
                    <td><?php echo utf8_encode($p['name']); ?></td>
                    <td width="160">
                        <a href="<?php echo BASE_URL; ?>/permissions/edit_group/<?php echo $p['id']; ?>">
                            <div class="button button_small">Editar</div>
                        </a>
                        <a href="<?php echo BASE_URL; ?>/permissions/delete_group/<?php echo $p['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?')">
                            <div class="button button_small">Excluir</div>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="tabbody">


        <a href="<?php echo BASE_URL;?>/permissions/add"><div class="button">Adicionar Permissão</div></a>

        <table border="0" width="100%">
            <tr>
                <th>Nome da Permissão</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($permissions_list as $p): ?>
                <tr>
                    <td><?php echo $p['name']; ?></td>
                    <td width="50">
                        <a href="<?php echo BASE_URL; ?>/permissions/delete/<?php echo $p['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?')">
                            <div class="button button_small">Excluir</div>
                        </a></td>
                    </tr>
            <?php endforeach; ?>


        </table>
    </div>
</div>