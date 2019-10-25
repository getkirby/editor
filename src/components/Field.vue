<template>
  <k-field
    :disabled="disabled"
    :label="label"
    :name="name"
    :required="required"
    :type="type"
  >
    <k-editor
      :autofocus="autofocus"
      :allowed="allowed"
      :disabled="disabled"
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
  inheritAttrs: false,
  components: {
    "k-editor": Editor
  },
  props: {
    allowed: [Array, Object],
    autofocus: Boolean,
    disabled: Boolean,
    endpoints: Object,
    label: String,
    name: String,
    required: Boolean,
    spellcheck: Boolean,
    type: String,
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
