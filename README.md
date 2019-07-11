# Kirby Editor

## Installation

### Download

Download and copy this repository to `/site/plugins/{{ plugin-name }}`.

### Git submodule

```
git submodule add https://github.com/{{ your-name }}/{{ plugin-name }}.git site/plugins/{{ plugin-name }}
```

### Composer

```
composer require {{ your-name }}/{{ plugin-name }}
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

## Todos

- [ ] History
- [ ] Better Copy & Paste
- [ ] Sortable blocks
- [ ] Plugin system for custom blocks

## License

MIT

## Credits

- [Bastian Allgeier](https://getkirby.com)
