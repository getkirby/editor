<script>
import Paragraph from "./Paragraph.vue";

export default {
  extends: Paragraph,
  icon: "title",
  label: "Heading 1",
  placeholder: "Heading 1",
  breaks: true,
  marks: [
    'italic',
    // 'strikeThrough',
    'code',
    'link'
  ]
};
</script>

<style lang="scss">

.k-editor-h1-block {
  font-size: 1.75rem;
  font-weight: 600;
  line-height: 1.5em;
  display: block;
  margin-bottom: .75rem;
}
.k-editor-h1-block .ProseMirror:empty {
  background: red;
}
.k-editor-h1-block code,
.k-editor-h2-block code,
.k-editor-h3-block code {
  position: relative;
  font-size: .925em;
  display: inline-block;
  line-height: 1;
  padding: .15em .25em;
  background: rgba(#000, .1);
  border-radius: 3px;
  font-family: SFMono-Regular, Consolas, Liberation Mono, Menlo, Courier, monospace;
}

</style>
