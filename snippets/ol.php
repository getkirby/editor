<?php if (is_null($prev) || $prev->type() !== 'ol'): ?>
<ol>
<?php endif ?>
<li><?= $content ?></li>
<?php if (is_null($next) || $next->type() !== 'ol'): ?>
</ol>
<?php endif ?>
