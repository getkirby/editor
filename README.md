# Kirby Editor

Kirby Editor is a new type of WYSIWYG editor for Kirby. It's a mixture between a regular WYSIWYG and a block editor to bring together the best parts of both worlds in a user-friendly interface. 

## Features

- Block types: 
  - Code
  - Heading 1
  - Heading 2
  - Heading 3
  - Image
  - Line
  - Numbered List
  - Ordered List
  - Quote
  - Text
  - Video
- Markdown shortcuts
- Drag & Drop sorting of blocks
- Full control over the created HTML for each individual block
- Save copy & paste without messed up and unwanted formats

## Installation

### Download

Download and copy this repository to `/site/plugins/editor`.

### Git submodule

```
git submodule add https://github.com/bastianallgeier/editor.git site/plugins/editor
```

## Setup

Once the plugin is installed, you can use the new `editor` field type in your blueprints:

```yaml
fields:
  text:
    label: Editor
    type: editor
```

## In your templates

The editor stores its content in a YAML format. To convert it to HTML you can use the new `blocks` method in your templates.

```
<?= $page->text()->blocks() ?>
```

## Customizing blocks

You can customize the result of the blocks field method by overwriting individual block snippets.

Create a new `editor` folder in `site/snippets`. Each block type can have its own snippet inside the folder. The following block types are currently available.

- code
- blockquote
- h1
- h2
- h3
- hr
- image
- ol
- paragraph
- ul
- video

Inside a block snippet you get the following variables:

- `$block`
- `$content`
- `$attrs`

Here's an example how the image block is built:

```php
<figure>
  <img src="<?= $attrs->src() ?>" alt="<?= $attrs->alt() ?>">
  <?php if ($attrs->caption()->isNotEmpty()): ?>
  <figcaption>
    <?= $attrs->caption() ?>
  </figcaption>
  <?php endif ?>
</figure>
```

Check out the other default block snippets in the snippets folder of the editor plugin, to get a better overview of how the blocks are made.

## License

MIT

## Credits

- [Bastian Allgeier](https://getkirby.com)
