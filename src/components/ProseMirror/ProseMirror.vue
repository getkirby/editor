<template>
  <div
    ref="editor"
    :spellcheck="spellcheck"
    class="k-editable"
    @focusin="onFocus"
    @focusout="onBlur"
  >
    <span class="k-editable-placeholder" v-if="placeholder && editor && isEmpty()">{{ placeholder }}</span>
  </div>
</template>

<script>
/** ProseMirror */
import { TextSelection, AllSelection } from "prosemirror-state";
import { DOMSerializer } from "prosemirror-model";

/** Editor wrapper */
import Editor from "./Editor/View.js";

/** Commands */
import { toggleMark } from "prosemirror-commands";

/** Utils */
import {
  getActiveMarks,
  getMarkAttrs,
  getHTML,
} from "./Utils.js";

export default {
  inheritAttrs: false,
  props: {
    content: String,
    breaks: Boolean,
    code: Boolean,
    spellcheck: Boolean,
    placeholder: String,
    marks: {
      type: Array,
      default() {
        return [
          "bold",
          "code",
          "italic",
          "link",
          "strikeThrough",
          "underline",
        ];
      }
    }
  },
  data() {
    return {
      editor: null,
    };
  },
  mounted() {
    this.editor = Editor({
      breaks: this.breaks,
      code: this.code,
      content: this.content,
      element: this.$el,
      marks: this.marks,
      onUpdate: this.onUpdate,
      onSplit: this.onSplit,
      onBack: this.onBack,
      onBold: this.onBold,
      onConvert: this.onConvert,
      onItalic: this.onItalic,
      onNext: this.onNext,
      onPrev: this.onPrev,
      onEnter: this.onEnter,
      onShiftEnter: this.onShiftEnter,
      onShiftTab: this.onShiftTab,
      onStrikeThrough: this.onStrikeThrough,
      onTab: this.onTab,
      onUnderline: this.onUnderline,
    });
  },
  destroyed() {
    this.editor.destroy();
  },
  methods: {
    addMark(type, attrs) {
      const { from, to } = this.selection();
      const mark = this.mark(type);

      if (mark) {
        return this.dispatch(this.tr().addMark(from, to, mark.create(attrs)))
      }
    },
    coordsAtPos(pos) {
      return this.editor.coordsAtPos(pos);
    },
    coordsAtEnd() {
      return this.editor.coordsAtPos(this.cursorPositionAtEnd());
    },
    coordsAtStart() {
      return this.editor.coordsAtPos(0);
    },
    coordsAtCursor() {
      return this.coordsAtPos(this.cursorPosition());
    },
    posAtCoords(coords) {
      return this.editor.posAtCoords(coords);
    },
    cursor() {
      let { $cursor } = this.selection();
      return $cursor;
    },
    cursorAtEnd() {
      let { $cursor } = this.selectionAtEnd();
      return $cursor;
    },
    cursorAtStart() {
      let { $cursor } = this.selectionAtStart();
      return $cursor;
    },
    cursorPosition() {
      const $cursor = this.cursor();
      return $cursor ? $cursor.pos : 0;
    },
    cursorPositionAtEnd() {
      const $cursor = this.cursorAtEnd();
      return $cursor ? $cursor.pos : 0;
    },
    cursorPositionAtStart() {
      return 0;
    },
    dispatch(tr) {
      this.editor.dispatch(tr);
    },
    doc() {
      return this.editor.state.doc;
    },
    focus(cursor) {

      if (cursor) {

        let selection = null;

        switch (cursor) {
          case "start":
            selection = TextSelection.atStart(this.doc());
            break;
          case "end":
            selection = TextSelection.atEnd(this.doc());
            break;
          default:
            try {
              selection = TextSelection.near(this.doc().resolve(cursor));
            } catch (e) {
              selection = TextSelection.atStart(this.doc());
            }
            break;
        }

        this.dispatch(this.tr().setSelection(selection));

      }

      setTimeout(() => {
        this.editor.focus();
      }, 1);

    },
    getActiveMarks() {
      return getActiveMarks(this.editor.state.schema, this.editor.state, this.marks);
    },
    getMarkAttrs(type) {
      return getMarkAttrs(this.state(), type);
    },
    hasFocus() {
      return this.editor.hasFocus;
    },
    hasMark(type) {
      return this.editor.state.schema.marks[type] !== undefined;
    },
    htmlAtSelection(selection) {
      return this.nodeToHtml(this.nodeAtSelection(selection));
    },
    htmlBeforeCursor() {
      return this.htmlAtSelection(this.selectionBeforeCursor());
    },
    htmlAfterCursor() {
      return this.htmlAtSelection(this.selectionAfterCursor());
    },
    insertBreak() {
      if (this.breaks !== true) {
        return false;
      }

      this.dispatch(
        this.tr()
          .replaceSelectionWith(this.schema().nodes.hard_break.create())
          .scrollIntoView()
      );
    },
    isEmpty() {
      return this.doc().content.size === 0;
    },
    isSelected() {
      const selection = this.selection();
      const end       = this.cursorPositionAtEnd();

      return selection.from === 0 && selection.to === end;
    },
    nodeAtSelection(selection) {
      return this.doc().cut(selection.from, selection.to);
    },
    nodeToHtml(node) {
      const result = DOMSerializer
        .fromSchema(this.editor.state.schema)
        .serializeFragment(node);

      let dom = document.createElement("div");
      dom.append(result);

      return dom.innerHTML;
    },
    mark(type) {
      return this.editor.state.schema.marks[type];
    },
    onBack() {
      this.$emit("back", {
        html: this.htmlAfterCursor()
      });
    },
    onBold() {
      this.toggleMark("bold");
    },
    onBlur() {
      this.$emit("blur");
    },
    onConvert(type) {
      this.$emit("convert", type);
    },
    onEnter() {
      this.$emit("enter", event);
    },
    onFocus() {
      this.$emit("focus", event);
    },
    onInput(html) {
      this.$emit("input", html);
    },
    onItalic() {
      this.toggleMark("italic");
    },
    onMarks(marks) {
      this.$emit("marks", marks);
    },
    onNext() {
      this.$emit("next");
    },
    onPrev() {
      this.$emit("prev");
    },
    onShiftEnter() {
      this.$emit("shiftEnter");
      this.insertBreak();
    },
    onShiftTab() {
      this.$emit("shiftTab");
    },
    onStrikeThrough() {
      this.toggleMark("strikeThrough");
    },
    onSplit() {
      this.$emit("split", {
        cursor: this.cursorPosition(),
        before: this.htmlBeforeCursor(),
        after: this.htmlAfterCursor()
      });
    },
    onTab() {
      this.$emit("tab");
    },
    onUnderline() {
      this.toggleMark("underline");
    },
    onUpdate() {
      this.onInput(this.toHTML());
      this.onMarks(this.getActiveMarks());
    },
    removeMark(type) {
      const { from, to } = this.selection();
      const mark = this.mark(type);

      if (mark) {
        return this.dispatch(this.tr().removeMark(from, to, mark));
      }
    },
    schema() {
      return this.editor.state.schema;
    },
    selection() {
      return this.editor.state.selection;
    },
    selectionAtEnd() {
      return TextSelection.atEnd(this.doc());
    },
    selectionAtStart() {
      return TextSelection.atStart(this.doc());
    },
    selectionBeforeCursor() {
      return new TextSelection(this.doc().resolve(0), this.selection().$from);
    },
    selectionAfterCursor() {
      return new TextSelection(this.selection().$to, this.selectionAtEnd().$to);
    },
    state() {
      return this.editor.state;
    },
    toggleMark(type, attrs) {
      const mark = this.mark(type);

      if (mark) {
        toggleMark(mark, attrs)(this.editor.state, this.editor.dispatch);
      }

      this.editor.focus();
    },
    toHTML() {
      return getHTML(this.editor.state, this.code);
    },
    toJSON() {
      return this.doc().toJSON();
    },
    tr() {
      return this.editor.state.tr;
    },
    view() {
      return this.editor;
    }
  }
};
</script>

<style>
.k-editable {
  position: relative;
}
.k-editable-placeholder {
  position: absolute;
  top: 0;
  left: 0;
  color: #bbb;
  pointer-events: none;
}
</style>
