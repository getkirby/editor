<script>
import Paragraph from "./Paragraph.vue";

export default {
  extends: Paragraph,
  label: "Code",
  icon: "code",
  marks: [],
  code: true,
  breaks: false,
  methods: {
    insertBreak() {
      this.dispatch(this.tr().insertText("\n").scrollIntoView());
    },
    onEnter() {
      this.insertBreak();
    },
    onShiftEnter() {
      this.$emit("append");
    },
    setLanguage(language) {
      alert(language);
    }
  }
};
</script>

<style lang="scss">

.k-editor-code-block pre {
  background: #000;
  color: #fff;
  font-size: .875rem;
  padding: 1rem;
  line-height: 1.5em;
  border-radius: 3px;
  overflow-y: scroll;
  margin-bottom: .75rem;
  white-space: pre;
}
.k-editor-code-block code {
  font-family: SFMono-Regular, Consolas, Liberation Mono, Menlo, Courier, monospace;
}
</style>
