<template>
  <k-dialog ref="dialog" @submit="submit">
    <k-form
      ref="linkForm"
      :fields="$options.fields"
      v-model="link"
      @submit="submit"
    />
  </k-dialog>
</template>

<script>
export default {
  fields: {
    href: {
      label: "URL",
      type: "text",
      icon: "url"
    }
  },
  data() {
    return {
      link: {
        href: null
      }
    };
  },
  methods: {
    open(href) {
      this.link.href = href;
      this.$refs.dialog.open();
    },
    submit() {
      this.$emit("submit", this.link.href);
      this.$refs.dialog.close();
    }
  }
};
</script>
