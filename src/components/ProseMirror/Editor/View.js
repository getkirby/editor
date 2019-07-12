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
      this.updateState(this.state.apply(transaction));
      if (props.onUpdate) {
        props.onUpdate();
      }
    },
    handlePaste(view, event, slice) {
      const html = event.clipboardData.getData('text/html');
      let result = true;

      if (props.onPaste) {
        result = props.onPaste(html);
      }

      return true;
    }
  });
};


