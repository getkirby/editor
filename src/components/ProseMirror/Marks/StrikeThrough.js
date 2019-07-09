export default {
  parseDOM: [
    { tag: "del" },
    { style: "text-decoration=line-through" }
  ],
  toDOM() {
    return ["del", 0];
  }
};
