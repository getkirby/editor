<template>
  <div>
    <figure>
      <template v-if="attrs.src">
        <div
          ref="element"
          class="k-editor-image-block-wrapper"
          tabindex="0"
          @keydown.delete="$emit('remove')"
          @keydown.enter="onAppend"
          @keydown.up.prevent="$emit('prev')"
          @keydown.down.prevent="$emit('next')"
        >
          <k-dropdown class="k-editor-image-block-options">
            <k-button class="k-editor-image-block-options-toggle" icon="dots" @click="$refs.options.toggle()" />
            <k-dropdown-content ref="options" align="right">
              <k-dropdown-item icon="cog" @click="settings">Image settings</k-dropdown-item>
              <hr>
              <k-dropdown-item icon="open" @click="open">Open in the browser</k-dropdown-item>
              <k-dropdown-item icon="edit" @click="edit" :disabled="!attrs.purl">Open in the panel</k-dropdown-item>
              <hr>
              <k-dropdown-item icon="refresh" @click="replace">Replace</k-dropdown-item>
            </k-dropdown-content>
          </k-dropdown>
          <img :src="attrs.src" @dblclick="selectFile">
        </div>
        <figcaption>
          <k-editable
            :content="attrs.caption"
            :breaks="true"
            placeholder="Add a caption …"
            @input="attrs.caption = $event"
          />
        </figcaption>
      </template>
      <template v-else>
        <div class="k-editor-image-block-placeholder" ref="element" tabindex="0">
          <k-button icon="upload" @click="uploadFile">Upload an image</k-button>
          or
          <k-button icon="image" @click="selectFile">Select an image</k-button>
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
      label: "Alternative text",
      type: "text",
      icon: "text"
    },
    link: {
      label: "Link",
      type: "text",
      icon: "url",
      placeholder: "http://"
    },
    css: {
      label: "CSS class",
      type: "text",
      icon: "code",
    }
  },
  methods: {
    edit() {
      if (this.attrs.purl) {
        this.$router.push(this.attrs.purl);
      }
    },
    focus() {
      this.$refs.element.focus();
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
    },
    insertFile(file) {
      this.input({
        purl: file[0].link,
        src: file[0].url,
        id: file[0].id
      });
    },
    insertUpload(files, response) {
      this.input({
        purl: response[0].link,
        id: response[0].id,
        src: response[0].url
      });
    },
    open() {
      window.open(this.attrs.src);
    },
    replace() {
      this.$emit("input", {
        attrs: {}
      });
    },
    selectFile() {
      this.$refs.fileDialog.open({
        endpoint: this.endpoints.field + "/files",
        multiple: false,
        selected: [this.attrs.id]
      });
    },
    settings() {
      this.$refs.settings.open();
    },
    saveSettings() {
      this.$refs.settings.close();
      this.input(this.attrs);
    },
    uploadFile() {
      this.$refs.fileUpload.open({
        url: window.panel.api + "/" + this.endpoints.field + "/upload",
        multiple: false,
        accept: "image/*"
      });
    },
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
.k-editor-image-block img {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  object-fit: contain;
  width: 100%;
  height: 100%;
}
.k-editor-image-block-wrapper {
  position: relative;
  padding-bottom: 66.66%;
  background: #2d2e36;
}
.k-editor-image-block-wrapper:focus {
  outline: 0;
}
.k-editor-image-block-wrapper:focus img {
  outline: 2px solid rgba(#4271ae, 0.25);
  outline-offset: 2px;
}
.k-editor-image-block figcaption {
  display: block;
  line-height: 1.5em;
  font-size: .875rem;
  padding-top: .75rem;
  text-align: center;
}
.k-editor-image-block-placeholder {
  display: flex;
  line-height: 1;
  justify-content: center;
  align-items: center;
  font-style: italic;
  font-size: .875rem;
  width: 100%;
  border: 1px dashed #ddd;
  border-radius: 3px;
  text-align: center;
  color: #bbb;
}
.k-editor-image-block-placeholder:focus {
  outline: 0;
}
.k-editor-image-block-placeholder .k-button {
  padding: .75rem;
  display: flex;
  align-items: center;
  color: #000;
  margin: 0 .5rem;
}
.k-editor-image-block-options {
  position: absolute;
  top: .75rem;
  right: .75rem;
  z-index: 1;
}
.k-editor-image-block-options-toggle {
  background: #fff;
  width: 1.75rem;
  height: 1.75rem;
  border-radius: 2px;
}
</style>
