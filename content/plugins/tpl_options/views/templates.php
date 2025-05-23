<?php
defined('EMLOG_ROOT') || exit('access denied!');
?>
<div class="containertitle2">
    <a class="navi3" href="<?= $this->url(); ?>"><?= lang('tpl_list') ?></a>
    <?php if ($toSetTemplate != ''): ?><a class="navi4" href="<?= $this->url(array('template' => $toSetTemplate)); ?>"><?=lang('tpl_options')?></a><?php endif; ?>
    <?php include $this->view('message'); ?>
</div>
<table class="adm__list">
    <?php
    $i = 0;
    foreach ($templates as $name => $template):
        if ($i++ % 3 == 0) {
            if ($i > 1) {
                echo '</tr>';
            }
            echo "<tr>";
        }
        ?>
        <td>
            <?php if ($template['support'] !== false): ?>
                <a href="<?= $this->url(array('template' => $name)); ?>">
                    <img alt="<?=lang('tpl_set')?>" title="<?=lang('tpl_set')?>" src="<?= $template['preview']; ?>" width="180" height="150" border="0"/>
                    <br/>
                    <?= $template['name']; ?>
                </a>
            <?php else: ?>
                <img title="<?=lang('tpl_option_not_support')?>" src="<?= $template['preview']; ?>" width="180" height="150" border="0"/>
                <br/>
                <?= $template['name']; ?>
            <?php endif; ?>
        </td>
    <?php
    endforeach;
    for ($j = $i + 3 - $i % 3; $i < $j; $i++) {
        echo '<td>&nbsp;</td>';
    }
    echo '</tr>';
    ?>
</table>