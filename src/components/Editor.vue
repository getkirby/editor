<template>
  <div class="k-editor" ref="editor">
    <div class="k-editor-blocks" :key="modified">

      <k-draggable :list="blocks" :handle="true" :options="{delay: 2}">
        <div
          v-for="(block, index) in blocks"
          v-if="blockTypeExists(block.type)"
          :key="block.id"
          :class="['k-editor-block', 'k-editor-' + block.type + '-block']"
          :data-indent="block.attrs.indent"
          @click="focus(index)"
          @focusin="onFocus(index)"
          @focusout="onBlur(index)"
          @keydown.meta.d.prevent="duplicate"
          @keydown.meta.shift.o="openOptions(index)"
        >
          <k-editor-options
            v-if="selected === index"
            :ref="'block-options-' + index"
            :blocks="$options.blocks"
            :block="$options.blocks[block.type]"
            :menu="menu"
            @add="add($event)"
            @convert="convertTo($event)"
            @duplicate="duplicate"
            @remove="remove"
          />
          <component
            :is="'k-editor-' + block.type + '-block'"
            :ref="'block-' + index"
            :attrs="block.attrs"
            :content="block.content"
            :endpoints="endpoints"
            v-bind="$options.blocks[block.type].bind"
            @click.native.stop="closeOptions(index)"
            @append="onAppend(index, $event)"
            @back="onBack(index, $event)"
            @convert="onConvert(index, $event)"
            @input="onInput(index, $event)"
            @next="onNext"
            @paste="onPaste(index, $event)"
            @prepend="onPrepend(index, $event)"
            @prev="onPrev"
            @remove="onRemove(index, $event)"
            @selectAll="onSelectAll(index, $event)"
            @split="onSplit(index, $event)"
            @update="onUpdate(index, $event)"
          />
        </div>
      </k-draggable>
    </div>
  </div>
</template>

<script>
import Options from "./Options.vue";

import "./Plugins.js";
import "./Blocks.js";

export default {
  components: {
    "k-editor-options": Options
  },
  blocks: {},
  props: {
    autofocus: Boolean,
    allowed: [Array, Object],
    endpoints: Object,
    value: {
      type: [Array, Object],
      default() {
        return []
      }
    }
  },
  beforeCreate() {

    Object.keys(window.editor.blocks).forEach(key => {

      const block = window.editor.blocks[key];

      if (block.extends && window.editor.blocks[block.extends]) {
        block.extends = window.editor.blocks[block.extends];
      }

      this.$options.blocks[key] = {
        label: this.$t("editor.blocks." + key + ".label", block.label || block.type),
        icon: block.icon,
        type: block.type,
        bind: block.bind || {}
      };

      // inject the translated placeholder
      this.$options.blocks[key].bind.placeholder = this.$t("editor.blocks." + key + ".placeholder", block.placeholder || "");

      this.$options.components["k-editor-" + key + "-block"] = block;
    });

  },
  created() {

    // discard all unallowed block types
    if (this.allowed && this.allowed.length > 0) {
      Object.keys(this.$options.blocks).forEach(type => {
        if (this.allowed.includes(type) === false) {
          delete this.$options.blocks[type];
        }
      });
    }

    if (this.autofocus === true) {
      this.$nextTick(this.focus);
    }

  },
  data() {
    const blocks = this.sanitize(this.value);

    return {
      blocks: blocks,
      modified: new Date(),
      selected: 0,
    };
  },
  computed: {
    selectedBlockDefinition() {
      return this.getSelectedBlockDefinition();
    }
  },
  watch: {
    blocks: {
      handler(blocks) {
        this.$emit("input", blocks);
      },
      deep: true
    },
    selected(value) {
      if (value === undefined || value === null || value === false) {
        this.selected = 0;
      }
    },
    value(value) {
      if (JSON.stringify(value) !== JSON.stringify(this.blocks)) {
        this.blocks = this.sanitize(value);
        this.modified = new Date()
      }
    },
  },
  methods: {
    add(type) {
      this.appendAndFocus({ type: type }, this.selected);
    },
    append(block, after) {
      block = this.createBlock(block);

      let nextIndex = 0;

      if (after === null || after === undefined) {
        this.blocks.push(block);
        nextIndex = this.blocks.length - 1;
      } else {
        nextIndex = after + 1;
        this.blocks.splice(nextIndex, 0, block);
      }

      return nextIndex;
    },
    appendAndFocus(block, after) {
      const next = this.append(block, after);

      this.$nextTick(() => {
        this.focus(next);
      });
    },
    blockTypeExists(type) {
      if (!this.$options.blocks[type]) {
        console.log("block component does not exist: " + type);
        return false;
      }

      return true;
    },
    closeOptions(index) {
      const ref = this.$refs["block-options-" + index];

      if (ref && ref[0] && ref[0].close) {
        ref[0].close();
      }
    },
    convertTo(type) {
      let block          = this.getSelectedBlock();
      let blockComponent = this.getSelectedBlockComponent();

      if (!block) {
        return false;
      }

      if (block.type === type) {
        return true;
      }

      let cursor = 0;

      if (blockComponent.cursorPosition) {
        cursor = blockComponent.cursorPosition();
      }

      block.type = type;
      block.id   = this.uuid();

      this.$nextTick(() => {
        this.focus(this.selected, cursor);
      });

    },
    createBlock(data) {
      const defaults = {
        attrs: {},
        content: "",
        id: this.uuid(),
        type: "paragraph",
      };

      let block = {
        ...defaults,
        ...data
      };

      return block;
    },
    duplicate() {
      const block = JSON.parse(JSON.stringify(this.getSelectedBlock()));

      if (block) {
        block.id = this.uuid();
        this.appendAndFocus(block, this.selected);
      }
    },
    focus(index, cursor) {
      let block = null;

      if (index === null || index === undefined) {
        block = this.getSelectedBlockComponent() || this.getFirstBlockComponent();
      } else {
        block = this.getBlockComponent(index) || this.getFirstBlockComponent();
      }

      if (block && block.focus) {
        block.focus(cursor);
      }
    },
    getBlock(index) {
      return this.blocks[index];
    },
    getBlockComponent(index) {
      if (index === undefined || index === null) {
        return false;
      }

      const block = this.$refs['block-' + index];

      if (block && block[0]) {
        return block[0];
      }

      return false;
    },
    getBlockDefinition(index) {
      const block = this.getBlock(index);

      if (block && this.$options.blocks[block.type]) {
        return this.$options.blocks[block.type];
      }
    },
    getBlockTextLength(index) {
      const block = this.getBlock(index);

      if (block) {
        let div = document.createElement("div");
        div.innerHTML = block.content;
        return div.innerText.length;
      }

      return 0;
    },
    getFirstBlockComponent() {
      return this.getBlockComponent(0);
    },
    getLastBlockComponent() {
      return this.getBlockComponent(this.blocks.length - 1);
    },
    getNextBlock(index) {
      return this.blocks[index + 1];
    },
    getNextBlockComponent() {
      return this.getBlockComponent(this.selected + 1);
    },
    getPreviousBlock(index) {
      return this.blocks[index - 1];
    },
    getPreviousBlockComponent() {
      return this.getBlockComponent(this.selected - 1);
    },
    getSelectedBlock() {
      if (this.selected !== null && this.selected !== undefined) {
        return this.blocks[this.selected];
      }
    },
    getSelectedBlockComponent() {
      return this.getBlockComponent(this.selected);
    },
    getSelectedBlockDefinition() {
      if (this.selected !== null && this.selected !== undefined) {
        return this.getBlockDefinition(this.selected);
      }
    },
    hasNextBlock(index) {
      return this.blocks[index + 1] !== undefined;
    },
    hasPreviousBlock(index) {
      return this.blocks[index - 1] !== undefined;
    },
    menu() {
      const component = this.getSelectedBlockComponent();

      if (component && component.menu) {
        return component.menu();
      }

      return [];
    },
    mergeWithPreviousBlock(index) {

      const block         = this.getBlock(index);
      const previousBlock = this.getPreviousBlock(index);

      if (!block || !previousBlock) {
        return false;
      }

      const previousBlockComponent = this.getPreviousBlockComponent(index);
      const cursorAtEnd            = this.getBlockTextLength(index - 1);

      previousBlock.content += block.content;
      previousBlock.id       = this.uuid();

      this.removeBlock(index);

      this.$nextTick(() => {
        this.focus(index - 1, cursorAtEnd);
      });

    },
    onAppend(index, block) {
      this.appendAndFocus(block, index);
    },
    onBack(index, data) {
      if (data.html.length === 0) {
        this.onRemove(index);
      } else {
        this.mergeWithPreviousBlock(index);
      }
    },
    onBlur(index) {
      this.selected = index;
    },
    onConvert(index, type) {
      const block = this.getBlockComponent(index);
      const cursor = block.cursorPosition ? block.cursorPosition() : 0;

      this.blocks[index].type = type;
      this.blocks[index].id = this.uuid();

      this.$nextTick(() => {
        this.focus(index, cursor);
      });
    },
    onFocus(index) {
      this.selected = index;
      const block = this.getSelectedBlockComponent();
    },
    onInput(index, data) {
      if (data.content !== undefined) {
        this.blocks[index].content = data.content;
      }

      if (data.attrs !== undefined) {
        this.blocks[index].attrs = data.attrs || {};
      }
    },
    onNext(cursor) {
      if (this.hasNextBlock(this.selected)) {
        this.focus(this.selected + 1, cursor);
      }
    },
    onPaste(index, { html, text }) {

      this.$api
        .post(this.endpoints.field + "/paste", { html })
        .then(blocks => {

          if (blocks.length === 0) {
            return;
          }

          if (blocks.length === 1) {
            const selected = this.getSelectedBlockComponent();
            selected.insertHtml(html);
            return;
          }

          const selected = this.getSelectedBlock();

          // append all pasted blocks
          this.blocks.splice(index + 1, 0, ...blocks);

        });

    },
    onPrepend(index, block) {
      this.prepend(block, index);
      this.selected = index + 1;
    },
    onPrev(cursor) {
      if (this.hasPreviousBlock(this.selected)) {
        this.focus(this.selected - 1, cursor);
      }
    },
    onRemove(index) {
      this.remove(index);
    },
    onSelectAll() {
      this.blocks.forEach((block, index) => {
        const component = this.getBlockComponent(index);
        if (component.select) {
          component.select();
        }
      });
    },
    onSplit(index, data) {
      this.split(index, data);
    },
    onUpdate(index, data) {
      let block = this.blocks[index];

      const selected = this.getSelectedBlockComponent();
      const cursor   = selected.cursorPosition ? selected.cursorPosition() : 0;

      this.$set(this.blocks, index, {
        ...block,
        ...data,
        id: this.uuid()
      });

      this.$nextTick(() => {
        this.focus(index, cursor);
      });
    },
    openOptions(index) {
      const ref = this.$refs["block-options-" + index];

      if (ref && ref[0] && ref[0].close) {
        ref[0].open();
      }
    },
    prepend(block, before) {
      block = this.createBlock(block);
      this.blocks.splice(before, 0, block);
      return before;
    },
    prependAndFocus(block, before) {
      const prev = this.prepend(block, before);

      this.$nextTick(() => {
        this.focus(before);
      });
    },
    remove(index) {
      if (index === null || index === undefined) {
        index = this.selected;
      }

      this.removeBlock(index);

      if (this.blocks.length) {
        const previousBlock = this.getPreviousBlockComponent();

        if (previousBlock) {
          this.selected = index - 1;
          previousBlock.focus("end");
        } else {
          this.selected = null;
        }
      } else {
        this.appendAndFocus();
      }

    },
    removeBlock(index) {
      this.blocks.splice(index, 1);
    },
    removeSelectedBlock() {
      this.removeBlock(this.selected);
    },
    sanitize(blocks) {
      if (blocks.length === 0) {
        blocks = [{
          type: "paragraph",
        }];
      }

      // assign a unique ID to each block
      blocks.map(block => {
        block.id = block.id || this.uuid();
        block.attrs = block.attrs || {};
        block.content = block.content || "";
        block.type = this.blockTypeExists(block.type) ? block.type : "paragraph";
        return block;
      });

      return blocks;
    },
    split(index, data) {
      let selectedBlock = this.getSelectedBlock();

      this.append({
        type: data.type || selectedBlock.type,
        content: data.after
      }, index);

      selectedBlock.content = data.before;
      selectedBlock.id      = this.uuid();

      this.$nextTick(() => {
        this.focus(index + 1, "start");
      });

    },
    uuid() {
      return '_' + Math.random().toString(36).substr(2, 9);
    }
  }
};
</script>

<style lang="scss">
.k-editor {
  position: relative;
  background: #fff;
  margin-bottom: 1.5rem;
  box-shadow: rgba(#000, 0.05) 0 2px 5px;
}
.k-editor-blocks {
  position: relative;
  padding: 1.5rem 0;
  max-width: 50rem;
  margin: 0 auto;
}
.k-editor-block {
  position: relative;
  padding: 0 4rem;
}
.k-editor-block:first-child {
  margin-top: 0;
}
.k-editor-block:last-child {
  margin-bottom: 0;
}
</style>
