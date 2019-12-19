<?php if ($iframe && $videoSourceType): ?>

<figure<?= attr(['class' => $attrs->css()->value()], ' ') ?>>

  <?php
  preg_match('/src="([^"]+)"/', $iframe, $match);
  $url = $match[1]; // grab from iframe because it's already been normalized (instead of $attrs->src())
  ?>

  <?php if ($videoSourceType === 'youtube'): ?>
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
  <?php elseif ($videoSourceType === 'vimeo'): ?>
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
