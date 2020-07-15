<?php if ($block->isNotEmpty()): ?>
<figure<?= attr(['class' => $attrs->css()->value()], ' ') ?>>
  <?php if ($attrs->link()->isNotEmpty()): ?>
    <a href="<?= $attrs->link()->toUrl() ?>">
      <?= $image ?>
    </a>
  <?php else: ?>
    <?= $image ?>
  <?php endif ?>

  <?php if ($attrs->caption()->isNotEmpty()): ?>
  <figcaption>
    <?= $attrs->caption() ?>
  </figcaption>
  <?php endif ?>
</figure>
<?php endif ?>
