<script>
import ProseMirror from "../ProseMirror/ProseMirror.vue";

/* Marks */
import Bold from "./Options/Bold.js";
import Code from "./Options/Code.js";
import Italic from "./Options/Italic.js";
import Link from "./Options/Link.js";
import Underline from "./Options/Underline.js";
import StrikeThrough from "./Options/StrikeThrough.js";

const availableOptions = {
  bold: Bold,
  code: Code,
  italic: Italic,
  link: Link,
  strikeThrough: StrikeThrough,
  underline: Underline,
};

export default {
  extends: ProseMirror,
  append: "paragraph",
  label: "Text",
  icon: "text",
  breaks: true,
  code: false,
  marks: [
    'bold',
    'italic',
    // 'strikeThrough',
    // 'underline',
    'code',
    'link',
  ],
  placeholder: null,
  props: {
    attrs: {
      type: Object,
      default() {
        return {}
      }
    }
  },
  methods: {
    menu(marks) {
      marks = marks || [];
      let menu = {};

      this.$options.marks.forEach(mark => {
        if (availableOptions[mark]) {
          menu[mark] = availableOptions[mark];
          menu[mark].isActive = marks.includes(mark);
        }
      });

      return menu;
    },
    onEnter() {
      this.$emit("append", {
        type: this.$options.append
      });
    },
    onInput(html) {
      this.$emit("input", {
        content: html
      });
    },
    onMarks(marks) {
      this.$nextTick(() => {
        this.$emit("menu", this.menu(marks));
      });
    },
    onShiftTab() {
      this.$emit("prev");
    },
    onSplit() {
      const cursor = this.cursorPosition();

      if (cursor === 0) {
        this.$emit("prepend");
      } else {
        this.$emit("split", {
          cursor: cursor,
          before: this.htmlBeforeCursor(),
          after: this.htmlAfterCursor(),
          type: this.$options.append
        });
      }
    },
    onTab() {
      this.$emit("next");
    },
  }
};
</script>

<style lang="scss">
.k-editor-paragraph-block {
  margin-bottom: .75rem;
}
.k-editor-paragraph-block .ProseMirror {
  line-height: 1.5em;
}
.k-editor-paragraph-block .ProseMirror strong {
  font-weight: 600;
}
.k-editor-paragraph-block .ProseMirror code {
  position: relative;
  font-size: .875rem;
  display: inline-block;
  line-height: 1.325;
  padding: .05em .5em;
  background: rgba(#000, .1);
  border-radius: 3px;
  font-family: SFMono-Regular, Consolas, Liberation Mono, Menlo, Courier, monospace;
}
</style>
