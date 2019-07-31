import { undo, redo } from "prosemirror-history";

export default function (props) {

  const trigger = function (event) {
    if (props[event]) {
      props[event]();
    }
  }

  const onEnter = function () {
    trigger("onEnter");
  };

  const onShiftEnter = function () {
    trigger("onShiftEnter");
  };

  return {
    "Cmd-z": undo,
    "Cmd-Shift-z": redo,
    "Enter": onEnter,
    "Shift-Enter": onShiftEnter,
  };

};
