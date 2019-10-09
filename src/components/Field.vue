<template>
  <k-field
    :label="label"
    :required="required"
    :disabled="disabled"
  >
    <k-editor
      :autofocus="autofocus"
      :allowed="allowed"
      :endpoints="endpoints"
      :spellcheck="spellcheck"
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
    autofocus: Boolean,
    disabled: Boolean,
    endpoints: Object,
    spellcheck: Boolean,
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
