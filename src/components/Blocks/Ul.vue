<script>
import Paragraph from "./Paragraph.vue";

export default {
  extends: Paragraph,
  label: "Bulleted List",
  append: "ul",
  icon: "list-bullet",
  breaks: true,
  placeholder: "List",
  methods: {
    indent(indent) {
      this.$emit("update", {
        attrs: {
          indent: indent
        }
      });
    },
    onEnter() {
      if (this.isEmpty()) {
        this.$emit("convert", "paragraph");
      } else {
        this.$emit("append", {
          type: this.$options.append,
          attrs: {
            indent: this.attrs.indent || 0
          }
        });
      }
    },
    onTab() {
      const currentIndent = Number(this.attrs.indent || 0);

      if (currentIndent < 1) {
        this.indent(1);
      } else {
        this.$emit("next");
      }
    },
    onShiftTab() {
      const currentIndent = Number(this.attrs.indent || 0);

      if (currentIndent > 0) {
        this.indent(0);
      } else {
        this.$emit("prev");
      }
    }
  }
};
</script>

<style lang="scss">
.k-editor-ul-block .ProseMirror {
  position: relative;
  padding-left: 1.25rem;
  margin-bottom: .75rem;
  line-height: 1.5em;
}
.k-editor-ul-block[data-indent="1"] .ProseMirror {
  margin-left: 1.25rem;
}
.k-editor-ul-block .ProseMirror:before {
  position: absolute;
  content: "";
  top: .55em;
  left: 0;
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: currentColor;
}
</style>
