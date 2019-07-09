<script>
import Paragraph from "./Paragraph.vue";

export default {
  label: "Quote",
  icon: "quote",
  extends: Paragraph,
  breaks: true,
  placeholder: "Quote"
};
</script>

<style lang="scss">

.k-editor-blockquote-block {
  font-size: 1.25rem;
  line-height: 1.5em;
  padding: 0 0 0 1rem;
  margin-top: 1.5rem;
  margin-bottom: 1.5rem;
  border-left: 4px solid #000;
}
.k-editor-blockquote-block code {
  position: relative;
  font-size: .875em;
  display: inline-block;
  line-height: 1.325;
  padding: .05em .5em;
  background: rgba(#000, .1);
  border-radius: 3px;
  font-family: SFMono-Regular, Consolas, Liberation Mono, Menlo, Courier, monospace;
}

</style>
