<?php if ($block->isNotEmpty()): ?>
<figure<?= attr(['class' => $attrs->css()->value()], ' ') ?>>
  <?php if ($attrs->link()->isNotEmpty()): ?>
  <a href="<?= $attrs->link()->toUrl() ?>">
    <amp-img
      src="<?= $src ?>"
      alt="<?= $attrs->alt() ?>"
      layout="responsive"
      width="<?= $width ?>"
      height="<?= $height ?>"
    ></amp-img>
  </a>
  <?php else: ?>
  <amp-img
    src="<?= $src ?>"
    alt="<?= $attrs->alt() ?>"
    layout="responsive"
    width="<?= $width ?>"
    height="<?= $height ?>"
  ></amp-img>
  <?php endif ?>

  <?php if ($attrs->caption()->isNotEmpty()): ?>
  <figcaption>
    <?= $attrs->caption() ?>
  </figcaption>
  <?php endif ?>
</figure>
<?php endif ?>
