import Blocks from "./Blocks.js";

let components = {};

/* Create component definitions dynamically */
Object.values(Blocks).forEach(block => {
  components["k-editor-" + block.type + "-block"] = block.component;
});

export default components;
