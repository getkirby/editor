<template>
  <div>
    <figure
      ref="figure"
      @keydown.enter="onAppend"
      @keydown.up.prevent="$emit('prev')"
      @keydown.down.prevent="$emit('next')"
      @keydown.delete="$emit('remove')"
    >
      <template v-if="attrs.src">
        <div class="k-editor-image-block-wrapper">
          <k-button class="k-editor-image-block-options" icon="cog" @click="settings" />
          <img ref="element" tabindex="0" :src="attrs.src" @dblclick="selectFile">
        </div>
        <figcaption v-if="attrs.caption" @dblclick="settings">
          {{ attrs.caption }}
        </figcaption>
      </template>
      <template v-else>
        <div class="k-editor-image-block-placeholder">
          <k-button ref="element" icon="image" @click="selectFile">Add an image</k-button>
        </div>
      </template>
    </figure>

    <k-files-dialog ref="fileDialog" @submit="insertFile($event)" />
    <k-upload ref="fileUpload" @success="insertUpload" />

    <k-dialog ref="settings" @submit="saveSettings" size="medium">
      <k-form :fields="$options.fields" v-model="attrs" @submit="saveSettings" />
    </k-dialog>

  </div>
</template>

<script>
export default {
  label: "Image",
  icon: "image",
  props: {
    endpoints: Object,
    attrs: {
      type: Object,
      default() {
        return {};
      }
    }
  },
  fields: {
    alt: {
      label: "Alt",
      type: "text",
    },
    caption: {
      label: "Caption",
      type: "textarea",
      buttons: false
    }
  },
  methods: {
    focus() {
      this.$refs.element.focus();
    },
    menu() {
      return {
        upload: {
          icon: "upload",
          label: "Upload",
          action: "selectFile",
        },
        text: {
          icon: "text",
          label: "Settings",
          action: "settings",
        },
      };
    },
    onAppend() {
      this.$emit("append");
    },
    input(data) {
      this.$emit("input", {
        attrs: {
          ...this.attrs,
          ...data
        }
      });

      this.$nextTick(() => {
        this.$emit("menu", this.menu());
      });
    },
    insertFile(file) {
      this.input({ src: file[0].url });
    },
    selectFile() {
      this.$refs.fileDialog.open({
        endpoint: this.endpoints.field + "/files",
        multiple: false
      });
    },
    settings() {
      this.$refs.settings.open();
    },
    saveSettings() {
      this.$refs.settings.close();
    }
  }
};
</script>

<style lang="scss">
.k-editor-image-block {
  margin: 1.5rem 0;
}
.k-editor-image-block figure {
  line-height: 0;
  text-align: center;
}
.k-editor-image-block img:focus {
  outline: 2px solid rgba(#4271ae, 0.25);
  outline-offset: 2px;
}
.k-editor-image-block img {
  display: block;
  max-width: 100%;
}
.k-editor-image-block-wrapper {
  display: inline-block;
  position: relative;
  margin: 0 auto;
}
.k-editor-image-block figcaption {
  display: block;
  line-height: 1.5em;
  font-size: .875rem;
  padding-top: .75rem;
  text-align: center;
}
.k-editor-image-block-placeholder {
  line-height: 1;
  width: 100%;
}
.k-editor-image-block-placeholder button {
  padding: .75rem;
  display: block;
  width: 100%;
  border-radius: 3px;
  border: 1px dashed #ddd;
}
.k-editor-image-block-options {
  position: absolute;
  top: .75rem;
  right: .75rem;
  background: #fff;
  width: 1.75rem;
  height: 1.75rem;
  border-radius: 2px;
}
</style>
