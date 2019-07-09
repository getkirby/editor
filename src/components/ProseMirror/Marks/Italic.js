export default {
  parseDOM: [
    { tag: "i" },
    { tag: "em" },
    { style: "font-style=italic" }
  ],
  toDOM() {
    return ["em", 0];
  }
};
