<script>
export default {
  extends: "paragraph",
  append: "ul",
  icon: "list-bullet",
  breaks: true,
  marks: [
    'bold',
    'italic',
    'code',
    'link'
  ],
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
    // onTab() {
    //   const currentIndent = Number(this.attrs.indent || 0);

    //   if (currentIndent < 1) {
    //     this.indent(1);
    //   } else {
    //     this.$emit("next");
    //   }
    // },
    // onShiftTab() {
    //   const currentIndent = Number(this.attrs.indent || 0);

    //   if (currentIndent > 0) {
    //     this.indent(0);
    //   } else {
    //     this.$emit("prev");
    //   }
    // }
  }
};
</script>

<style lang="scss">
.k-editor-ul-block {
  margin-bottom: .75rem;
}
.k-editor-ul-block .k-editable {
  position: relative;
  margin-left: 1.25rem;
  line-height: 1.5em;
}
.k-editor-ul-block .k-editable:before {
  position: absolute;
  content: "";
  top: .625em;
  left: -1.25rem;
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: currentColor;
}
</style>
