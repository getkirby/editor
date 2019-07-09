<?php if ($block->prev()->type() !== 'ul'): ?>
<ul>
<?php endif ?>
<li><?= $block->content() ?></li>
<?php if ($block->next()->type() !== 'ul'): ?>
</ul>
<?php endif ?>
