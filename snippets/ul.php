<?php if ($block->prev() && $block->prev()->type() !== 'ul'): ?>
<ul>
<?php endif ?>
<li><?= $block->content() ?></li>
<?php if ($block->next() && $block->next()->type() !== 'ul'): ?>
</ul>
<?php endif ?>
