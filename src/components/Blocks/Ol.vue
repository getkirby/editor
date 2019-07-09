<script>
import Ul from "./Ul.vue";

export default {
  ...Ul,
  label: "Ordered List",
  append: "ol",
  icon: "list-numbers",
};
</script>

<style lang="scss">
.k-editor-block:not(.k-editor-ol-block) {
  counter-reset: list;
}
.k-editor-ol-block .ProseMirror {
  position: relative;
  padding-left: 1.25rem;
  margin-bottom: .75rem;
  line-height: 1.5em;
  counter-increment: list;
}
.k-editor-ol-block[data-indent="1"] .ProseMirror {
  margin-left: 1.25rem;
}
.k-editor-ol-block .ProseMirror:before {
  position: absolute;
  content: counter(list) ".";
  top: 0;
  left: 0;
}
</style>
