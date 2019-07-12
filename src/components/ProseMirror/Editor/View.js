import { EditorView } from "prosemirror-view";

import Document from "./Document.js";
import Keymap from "./Keymap.js";
import Schema from "./Schema.js";
import State from "./State.js";

export default function (props) {
  const schema   = Schema(props.marks, props.code);
  const document = Document(schema, props.content, props.code);
  const keymap   = Keymap(props)
  const state    = State(document, keymap, props);

  return new EditorView(props.element, {
    state: state,
    dispatchTransaction(transaction) {

      const lastState = this.state;
      const nextState = this.state.apply(transaction);

      this.updateState(nextState);
      if (props.onUpdate) {
        props.onUpdate();
      }

      if (!props.onSelect) {
        return;
      }

      // Don't do anything if the document/selection didn't change
      if (lastState && lastState.doc.eq(this.state.doc) && lastState.selection.eq(this.state.selection)) {
        return;
      }

      props.onSelect();

    },
    handlePaste(view, event, slice) {
      const html = event.clipboardData.getData('text/html');
      const text = event.clipboardData.getData('text/plain');

      if (html.length === 0) {
        return false;
      }

      if (props.onPaste) {
        result = props.onPaste(html, text);
      }

      return true;
    }
  });
};


