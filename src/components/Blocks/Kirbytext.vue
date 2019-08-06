<script>
import ProseMirror from "../ProseMirror/ProseMirror.vue";

export default {
  extends: ProseMirror,
  label: "KirbyText",
  icon: "markdown",
  breaks: true,
  code: true,
  props: {
    content: String,
    attrs: [Object, Array]
  },
  methods: {
    onInput(html) {
      this.$emit("input", {
        content: html
      });
    }
  }
};
</script>

<style lang="scss">

.k-editor-kirbytext-block {
  margin: 1.5rem 0;
}
.k-editor-kirbytext-block pre {
  background: #efefef;
  tab-size: 2;
  font-size: .875rem;
  padding: 1.5rem;
  line-height: 2em;
  border-radius: 3px;
  overflow-y: scroll;
  margin-bottom: .75rem;
  white-space: pre-wrap;
}
.k-editor-kirbytext-block code {
  font-family: SFMono-Regular, Consolas, Liberation Mono, Menlo, Courier, monospace;
}
</style>
