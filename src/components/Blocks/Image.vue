<template>
  <div>
    <figure>
      <template v-if="attrs.src">
        <div
          ref="element"
          :style="'padding-bottom:' + 100 / this.attrs.ratio + '%'"
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
              <k-dropdown-item icon="cog" @click="settings">{{ $t("editor.blocks.image.settings") }}</k-dropdown-item>
              <hr>
              <k-dropdown-item icon="open" @click="open">{{ $t("editor.blocks.image.open.browser") }}</k-dropdown-item>
              <k-dropdown-item icon="edit" @click="edit" :disabled="!attrs.guid">{{ $t("editor.blocks.image.open.panel") }}</k-dropdown-item>
              <hr>
              <k-dropdown-item icon="refresh" @click="replace">{{ $t("replace") }}</k-dropdown-item>
            </k-dropdown-content>
          </k-dropdown>
          <img :src="attrs.src" :key="attrs.src" @dblclick="selectFile">
        </div>
        <figcaption>
          <k-editable
            :content="attrs.caption"
            :breaks="true"
            :placeholder="$t('editor.blocks.image.caption.placeholder') + '…'"
            @input="attrs.caption = $event"
          />
        </figcaption>
      </template>
      <template v-else>
        <div class="k-editor-image-block-placeholder" ref="element" tabindex="0">
          <k-button icon="upload" @click="uploadFile">{{ $t('editor.blocks.image.upload') }}</k-button>
          {{ $t('editor.blocks.image.or') }}
          <k-button icon="image" @click="selectFile">{{ $t('editor.blocks.image.select') }}</k-button>
        </div>
      </template>
    </figure>

    <k-files-dialog ref="fileDialog" @submit="insertFile($event)" />
    <k-upload ref="fileUpload" @success="insertUpload" />

    <k-dialog ref="settings" @submit="saveSettings" size="medium">
      <k-form :fields="fields" v-model="attrs" @submit="saveSettings" />
    </k-dialog>

  </div>
</template>

<script>
export default {
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
  computed: {
    fields() {
      return {
        alt: {
          label: this.$t('editor.blocks.image.alt.label'),
          type: "text",
          icon: "text"
        },
        link: {
          label: this.$t('editor.blocks.image.link.label'),
          type: "text",
          icon: "url",
          placeholder: this.$t('editor.blocks.image.link.placeholder')
        },
        css: {
          label: this.$t('editor.blocks.image.css.label'),
          type: "text",
          icon: "code",
        }
      };
    }
  },
  methods: {
    edit() {
      if (this.attrs.guid) {
        this.$router.push(this.attrs.guid);
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
    fetchFile(link) {
      this.$api.get(link).then(response => {
        this.input({
          guid: response.link,
          src: response.url,
          id: response.id,
          ratio: response.dimensions.ratio
        });
      });
    },
    insertFile(files) {
      const file = files[0];
      this.fetchFile(file.link);
    },
    insertUpload(files, response) {
      this.fetchFile(response[0].link);
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
