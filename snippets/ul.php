<?php if (is_null($prev) || $prev->type() !== 'ul'): ?>
<ul>
<?php endif ?>
<li><?= $content ?></li>
<?php if (is_null($next) || $next->type() !== 'ul'): ?>
</ul>
<?php endif ?>
