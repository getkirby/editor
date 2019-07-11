<figure>
    <img src="<?= $attrs->src() ?>" alt="<?= $attrs->alt() ?>">
    <?php if ($attrs->caption()->isNotEmpty()): ?>
    <figcaption>
        <?= $attrs->caption() ?>
    </figcaption>
    <?php endif ?>
</figure>
