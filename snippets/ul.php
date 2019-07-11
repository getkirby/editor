<?php if ($prev && $prev->type() !== 'ul'): ?>
<ul>
<?php endif ?>
<li><?= $content ?></li>
<?php if ($next && $next->type() !== 'ul'): ?>
</ul>
<?php endif ?>
