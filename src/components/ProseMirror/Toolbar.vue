<template>
  <div class="k-editable-toolbar">
    <k-button
      v-for="(mark, markType) in options"
      :key="markType"
      :class="{'k-editable-toolbar-button': true, 'k-editable-toolbar-button-active': marks.includes(markType)}"
      :icon="mark.spec.toolbar.icon"
      @mousedown.prevent="$emit('option', mark.spec.toolbar)"
    />
  </div>
</template>

<script>
export default {
  props: {
    marks: {
      type: Array,
      default() {
        return []
      }
    },
    options: Object
  },
};
</script>

<style lang="scss">
.k-editable-toolbar {
  position: absolute;
  display: flex;
  border-bottom: 1px solid #ddd;
  background: #000;
  height: 37px;
  transform: translateX(-50%) translateY(-.75rem);
  z-index: 1;
  box-shadow: rgba(0, 0, 0, 0.05) 0 2px 5px;
  border-bottom: 1px solid rgba(#000, 0.1);
  color: #fff;
  border-radius: 3px;
}
.k-editable-toolbar-button {
  display: flex;
  align-items: center;
  height: 36px;
  padding: 0 .75rem;
  font-size: .875rem !important;
  color: currentColor;
}
.k-editable-toolbar-button.k-editable-toolbar-button-active {
  color: #81a2be;
}
</style>
