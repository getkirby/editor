<figure<?= attr(['class' => $attrs->css()], ' ') ?>>
  <?php if ($attrs->link()->isNotEmpty()): ?>
  <a href="<?= $attrs->link()->toUrl() ?>">
    <img src="<?= $attrs->src() ?>" alt="<?= $attrs->alt() ?>">
  </a>
  <?php else: ?>
  <img src="<?= $attrs->src() ?>" alt="<?= $attrs->alt() ?>">
  <?php endif ?>

  <?php if ($attrs->caption()->isNotEmpty()): ?>
  <figcaption>
    <?= $attrs->caption() ?>
  </figcaption>
  <?php endif ?>
</figure>
