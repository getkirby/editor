<script>
import ProseMirror from "../ProseMirror/ProseMirror.vue";

export default {
  extends: ProseMirror,
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
.k-editor-kirbytext-block .k-editable-code pre {
  background: #efefef;
  padding: 1.5rem;
  border-radius: 3px;
  white-space: pre-wrap;
}
</style>
