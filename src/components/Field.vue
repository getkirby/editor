<template>
  <k-field :label="label">
    <k-editor @input="onInput" :value="value" :endpoints="endpoints" />
  </k-field>
</template>

<script>
import Editor from "./Editor.vue";

export default {
  components: {
    "k-editor": Editor
  },
  props: {
    endpoints: Object,
    label: String,
    value: {
      type: [Array, Object],
      default() {
        return [];
      }
    }
  },
  methods: {
    onInput(blocks) {
      this.$emit("input", blocks);
    }
  }
};
</script>

<style lang="scss">
/** put your css here **/
</style>
