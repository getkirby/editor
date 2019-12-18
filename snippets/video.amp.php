<?php if ($iframe): ?>

<figure<?= attr(['class' => $attrs->css()->value()], ' ') ?>>

  <?php
  preg_match('/src="([^"]+)"/', $iframe, $match);
  $url = $match[1];
  ?>
  
  <?php if (preg_match('!youtu!i', $url) === 1):      /* YouTube video */ ?>
    <?php
    $id = null;
    if (preg_match('!' . '\/embed\/([a-zA-Z0-9_-]+)' . '!i', $url, $array) === 1) {
      $id = $array[1];
    }
    ?>
    <amp-youtube
      data-videoid="<?= $id ?>"
      layout="responsive"
      width="480"
      height="270"
    ></amp-youtube>
  <?php elseif (preg_match('!vimeo!i', $url) === 1):  /* Vimeo video */ ?>
    <?php
    $id = null;
    if (preg_match('!' . '\/video\/([0-9]+)' . '!i', $url, $array) === 1) {
      $id = $array[1];
    }
    ?>
    <amp-vimeo
      data-videoid="<?= $id ?>"
      layout="responsive"
      width="480"
      height="270"
    ></amp-vimeo>
  <?php endif ?>

  <?php if ($attrs->caption()->isNotEmpty()): ?>
  <figcaption><?= $attrs->caption() ?></figcaption>
  <?php endif ?>
</figure>

<?php endif ?>
