export default {
  h1(element) {
    return {
      type: "h1",
      content: element.innerHTML
    };
  },
  h2(element) {
    return {
      type: "h2",
      content: element.innerHTML
    };
  },
  h3(element) {
    return {
      type: "h3",
      content: element.innerHTML
    };
  },
  blockquote(element) {
    return {
      type: "blockquote",
      content: element.innerHTML
    };
  },
  hr() {
    return {
      type: "hr"
    };
  },
  p(element) {
    if (element.innerText.length === 0) {
      return false;
    }

    return {
      type: "paragraph",
      content: element.innerHTML
    };
  },
  br() {
    return false;
  },
  img(element) {
    return {
      type: "image",
      attrs: {
        alt: element.getAttribute("alt"),
        src: element.getAttribute("src")
      }
    };
  },
  pre(element) {

    const code = element.querySelector("code");

    if (!code) {
      return {
        type: "paragraph",
        content: element.innerHTML
      };
    }

    const className = code.getAttribute("class");
    let language = null;

    if (className.match(/^language-([a-z_-]+)$/)) {
      language = className.replace("language-", "");
    }

    return {
      type: "code",
      content: code.innerHTML,
      attrs: {
        language: language
      }
    };
  },
  li(element) {
    const type = element.parentElement && element.parentElement.tagName === "OL" ? "ol" : "ul";
    return {
      type: type,
      content: element.innerHTML
    };
  },
  tr(element) {
    return {
      type: "paragraph",
      content: element.innerHTML
    }
  },
  figure(element) {
    const img     = element.querySelector("img");
    const vid     = element.querySelector("iframe");
    const caption = element.querySelector("figcaption");

    if (img) {
      return {
        type: "image",
        attrs: {
          alt: img.getAttribute("alt"),
          src: img.getAttribute("src"),
          caption: caption ? caption.innerText : null
        }
      };
    } else {
      return {
        type: "video",
        attrs: {
          src: vid.getAttribute("src"),
          caption: caption ? caption.innerText : null
        }
      };
    }
  }
};
