import { undo, redo } from "prosemirror-history";

export default function (props) {

  const trigger = function (event) {
    if (props[event]) {
      props[event]();
    }
  }

  const onBold = function () {
    trigger("onBold");
  };

  const onDelete = function (state) {
    let { $cursor } = state.selection;

    if (!$cursor || $cursor.pos !== 0) {
      return false
    }

    trigger("onBack");
  };

  const onDown = function (state, dispatch, view) {
    if (view.endOfTextblock("down", state)) {
      trigger("onNext");
      return true;
    }
  };

  const onEnter = function (state, dispatch, view) {
    let { $cursor } = state.selection;

    if (!$cursor || !view.endOfTextblock("forward", state)) {
      trigger("onSplit");
    } else {
      trigger("onEnter");
    }
  };

  const onItalic = function () {
    trigger("onItalic");
  };

  const onLink = function () {
    trigger("onLink");
  };

  const onShiftEnter = function () {
    trigger("onShiftEnter");
  };

  const onShiftTab = function () {
    trigger("onShiftTab");
    return true;
  };

  const onStrikeThrough = function () {
    trigger("onStrikeThrough");
  };

  const onTab = function () {
    trigger("onTab");
    return true;
  };

  const onUnderline = function () {
    trigger("onUnderline");
  };

  const onUp = function (state, dispatch, view) {
    if (view.endOfTextblock("up", state)) {
      trigger("onPrev");
      return true;
    }
  };

  return {
    "ArrowUp": onUp,
    "ArrowDown": onDown,
    "Backspace": onDelete,
    "Cmd-b": onBold,
    "Cmd-i": onItalic,
    "Cmd-k": onLink,
    "Cmd-u": onUnderline,
    "Cmd-z": undo,
    "Cmd-Shift-s": onStrikeThrough,
    "Cmd-Shift-z": redo,
    "Delete": onDelete,
    "Enter": onEnter,
    "Mod-Delete": onDelete,
    "Shift-Enter": onShiftEnter,
    "Shift-Tab": onShiftTab,
    "Tab": onTab,
  };

};
