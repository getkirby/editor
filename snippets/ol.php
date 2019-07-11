<?php if ($prev && $prev->type() !== 'ol'): ?>
<ol>
<?php endif ?>
<li><?= $content ?></li>
<?php if ($next && $next->type() !== 'ol'): ?>
</ol>
<?php endif ?>
