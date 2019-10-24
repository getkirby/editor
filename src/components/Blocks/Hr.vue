<template>
  <hr
    class="k-editor-hr-block-divider"
    ref="hr"
    tabindex="0"
    @keydown.enter="$emit('append')"
    @keydown.up="$emit('prev')"
    @keydown.down="$emit('next')"
    @keydown.delete="$emit('remove')"
  />
</template>

<script>
export default {
  icon: "dots",
  methods: {
    focus() {
      this.$refs.hr.focus();
    }
  }
};
</script>

<style lang="scss">
.k-editor-hr-block-divider {
  position: relative;
  height: 1.5rem;
  border: 0;
  margin-bottom: .75rem;
  color: #ddd;

  &:focus {
    outline: 0;
  }

  &:after {
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    content: "";
    height: 1px;
    background: currentColor;
  }

  &:focus {
    color: rgba(#4271ae, 0.25);
  }
  &:focus:after {
    outline: 1px solid rgba(#4271ae, 0.25);
  }

}
</style>
