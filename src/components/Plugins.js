window.editor = {
  blocks: [],
  block(type, params, position) {
    const defaults = {
      type: type,
      icon: "page",
    };
    const positionMatch = /(after|before):(\S+)/.exec(position);

    // extend the params with the defaults
    params = {
      ...defaults,
      ...params
    };

    // content editable options
    params.bind = {
      append: params.append,
      breaks: params.breaks,
      code: params.code,
      marks: params.marks,
      placeholder: params.placeholder,
    };

    // add block to blocks array
    if (position && positionMatch !== null && this.blocks.findIndex(b => b[0] === positionMatch[2]) !== -1) {
      // add after/before a given type if position parameter is given and sibling block isset
      // find position of siblings type
      let siblingsIndex = this.blocks.findIndex(b => b[0] === positionMatch[2]);

      // add new block before/after sibling
      switch (positionMatch[1]) {
        case 'before':
          this.blocks.splice(siblingsIndex, 0, [type,params])
          break;
        case 'after':
        default:
          this.blocks.splice(siblingsIndex + 1, 0, [type,params])
      }
    } else {
      // add block add the end of blocks
      this.blocks.push([type, params]);
    }
  }
};
