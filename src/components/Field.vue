<template>
  <k-field
    :label="label"
    :required="required"
    :disabled="disabled"
  >
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
    allowed: [Array, Object],
    disabled: Boolean,
    endpoints: Object,
    label: String,
    required: Boolean,
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
