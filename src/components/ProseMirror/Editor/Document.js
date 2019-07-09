import { DOMParser } from "prosemirror-model";

export default function (schema, html, code) {

  let dom = document.createElement("div");

  html = html || "";

  if (code) {
    html = "<pre><code>" + html + "</code></pre>";
  }

  dom.innerHTML = html;

  return DOMParser.fromSchema(schema).parse(dom);

};
