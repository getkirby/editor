import Blockquote from "./Blocks/Blockquote.vue";
import Code from "./Blocks/Code.vue";
import H1 from "./Blocks/H1.vue";
import H2 from "./Blocks/H2.vue";
import H3 from "./Blocks/H3.vue";
import Hr from "./Blocks/Hr.vue";
import Image from "./Blocks/Image.vue";
import Kirbytext from "./Blocks/Kirbytext.vue";
import Paragraph from "./Blocks/Paragraph.vue";
import Ul from "./Blocks/Ul.vue";
import Ol from "./Blocks/Ol.vue";
import Video from "./Blocks/Video.vue";

const components = {
  h1: H1,
  h2: H2,
  h3: H3,
  paragraph: Paragraph,
  ul: Ul,
  ol: Ol,
  blockquote: Blockquote,
  hr: Hr,
  code: Code,
  image: Image,
  video: Video,
  kirbytext: Kirbytext,
};

let blocks = {};

Object.keys(components).forEach(blockType => {
  const component = components[blockType];

  blocks[blockType] = {
    label: component.label,
    icon: component.icon,
    type: blockType,
    component: component,
    options: {
      append: component.append,
      breaks: component.breaks,
      code: component.code,
      marks: component.marks,
      placeholder: component.placeholder,
    }
  };
});

export default blocks;
