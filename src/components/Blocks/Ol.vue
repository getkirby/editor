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
.k-editor-ol-block {
  position: relative;
  padding-left: 1.25rem;
  line-height: 1.5em;
  margin-bottom: .75rem;
  counter-increment: list;
}
.k-editor-block:not(.k-editor-ol-block) {
  counter-reset: list;
}
.k-editor-ol-block[data-indent="1"] {
  margin-left: 1.25rem;
}
.k-editor-ol-block:before {
  position: absolute;
  content: counter(list) ".";
  top: 0;
  left: 0;
}
</style>
