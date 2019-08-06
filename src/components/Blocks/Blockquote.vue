<script>
export default {
  icon: "quote",
  extends: "paragraph",
  breaks: true,
  placeholder: "Quote",
  marks: [
    'bold',
    'italic',
    'code',
    'link'
  ]
};
</script>

<style lang="scss">

.k-editor-blockquote-block {
  margin-top: 1.5rem;
  margin-bottom: 1.5rem;
}
.k-editor-blockquote-block .k-editable-placeholder,
.k-editor-blockquote-block .ProseMirror {
  font-size: 1.25rem;
  line-height: 1.5em;
  padding: 0 0 0 1rem;
  border-left: 3px solid #000;
}
.k-editor-blockquote-block .ProseMirror code {
  position: relative;
  font-size: .875em;
  display: inline-block;
  line-height: 1.325;
  padding: .05em .5em;
  background: rgba(#000, .1);
  border-radius: 3px;
  font-family: SFMono-Regular, Consolas, Liberation Mono, Menlo, Courier, monospace;
}
.k-editor-blockquote-block .k-editor-block-options {
  top: 0;
}
</style>
