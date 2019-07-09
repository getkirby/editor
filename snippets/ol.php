<?php if ($block->prev() && $block->prev()->type() !== 'ol'): ?>
<ol>
<?php endif ?>
<li><?= $block->content() ?></li>
<?php if ($block->next() && $block->next()->type() !== 'ol'): ?>
</ol>
<?php endif ?>
