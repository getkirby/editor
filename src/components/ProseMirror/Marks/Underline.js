export default {
  toolbar: {
    icon: "u",
    label: "Underline",
    action: "toggleMark",
    args: ["underline"]
  },
  parseDOM: [
    { tag: "u" },
    { style: "text-decoration=underline" }
  ],
  toDOM() {
    return ["u", 0];
  }
};
