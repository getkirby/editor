<template>
  <nav class="k-editor-block-options">
    <button type="button" class="k-editor-block-option k-sort-handle">
      <k-icon type="sort" />
    </button>
    <k-dropdown>
      <button type="button" class="k-editor-block-option k-editor-block-options-sort" @mousedown.stop="$refs.blockOptions.toggle()">
        <k-icon type="angle-down" />
      </button>
      <k-dropdown-content ref="blockOptions" class="k-editor-block-option-dropdown" @mousedown.native.stop>
        <h4>Turn into …</h4>
        <ul>
          <li v-for="definition in blocks" :key="definition.type">
            <k-dropdown-item @click="$emit('convert', definition.type)" :icon="definition.icon">{{ definition.label }}</k-dropdown-item>
          </li>
        </ul>
        <hr>
        <k-dropdown-item icon="add" @click="$emit('add', 'paragraph')">Insert block below</k-dropdown-item>
        <k-dropdown-item icon="trash" @click="$emit('remove')">Delete</k-dropdown-item>
      </k-dropdown-content>
    </k-dropdown>
  </nav>
</template>

<script>
export default {
  props: {
    blocks: Object
  },
};
</script>

<style lang="scss">
.k-editor-block-options {
  position: absolute;
  left: 0;
  display: flex;
  top: -3px;
  width: 4rem;
  padding: .25rem 0;
  align-items: center;
  justify-content: center;
}
.k-editor-block-option {
  cursor: pointer;
}
.k-editor-block-option span {
  display: flex;
  width: 1.5rem;
  height: 1.5rem;
  border-radius: 3px;
  align-items: center;
  justify-content: center;
  color: #999;
}
.k-editor-block-option:hover {
  background: #efefef;
}
.k-editor-block-option:focus {
  outline: 0;
}
.k-editor-block-options .k-sort-handle {
  padding: 0;
  width: auto;
  height: auto;
}
.k-editor-block-option-dropdown ul {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
}
.k-editor-block-option-dropdown h4 {
  padding: .75rem 1rem;
  font-size: .875rem;
  font-weight: 600;
}
</style>
