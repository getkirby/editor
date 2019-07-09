export default {
  parseDOM: [
    { tag: "u" },
    { style: "text-decoration=underline" }
  ],
  toDOM() {
    return ["u", 0];
  }
};
