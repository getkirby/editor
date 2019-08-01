<template>
  <k-field :label="label">
    <k-editor
      :allowed="allowed"
      :endpoints="endpoints"
      :value="value"
      @input="onInput"
    />
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
    allowed: [Array, Object],
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
