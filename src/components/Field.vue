<template>
  <k-field
    :disabled="disabled"
    :label="label"
    :name="name"
    :required="required"
    :type="type"
  >
    <k-editor-inline
      v-if="inline"
      :autofocus="autofocus"
      :disabled="disabled"
      :spellcheck="spellcheck"
      :value="value"
      @input="onInput"
    />
    <k-editor
      v-else
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
import EditorInline from "./EditorInline.vue";

export default {
  inheritAttrs: false,
  components: {
    "k-editor": Editor,
    "k-editor-inline": EditorInline,
  },
  props: {
    allowed: [Array, Object],
    autofocus: Boolean,
    disabled: Boolean,
    endpoints: Object,
    inline: Boolean,
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
