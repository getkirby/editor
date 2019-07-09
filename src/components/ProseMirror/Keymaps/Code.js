
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
    "Enter": onEnter,
    "Shift-Enter": onShiftEnter,
  };

};
