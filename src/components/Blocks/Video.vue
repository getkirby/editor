<template>
  <div>
    <figure
      ref="figure"
      @keydown.enter="onAppend"
      @keydown.up.prevent="$emit('prev')"
      @keydown.down.prevent="$emit('next')"
      @keydown.backspace="$emit('remove')"
      @keydown.delete="$emit('remove')"
    >
      <template v-if="embedSrc">
        <div ref="element" tabindex="0" class="k-editor-video-block-embed" @dblclick="settings">
          <iframe :src="embedSrc" />
        </div>
      </template>
      <template v-else>
        <div class="k-editor-video-block-placeholder">
          <k-button ref="element" icon="video" @click="settings">Add Video Url</k-button>
        </div>
      </template>
    </figure>
    <k-dialog ref="settings" @submit="saveSettings" size="medium">
      <k-form :fields="$options.fields" v-model="attrs" @submit="saveSettings" />
    </k-dialog>
  </div>
</template>

<script>
import Image from "./Image.vue";

function getId(url) {
  var youtubePattern = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
  var youtubeMatch   = url.match(youtubePattern);

  if (youtubeMatch) {
    return "https://www.youtube.com/embed/" + youtubeMatch[2];
  }

  var vimeoPattern = /vimeo\.com\/([0-9]+)/;
  var vimeoMatch   = url.match(vimeoPattern);

  if (vimeoMatch) {
    return "https://player.vimeo.com/video/" + vimeoMatch[1];
  }

  return false;
}

export default {
  extends: Image,
  label: "Video",
  icon: "video",
  fields: {
    src: {
      label: "Video-URL",
      type: "url"
    }
  },
  computed: {
    embedSrc() {
      if (!this.attrs.src) {
        return null;
      }

      return getId(this.attrs.src);
    }
  },
  methods: {
    menu() {
      return {
        src: {
          icon: "url",
          label: "Link",
          action: "settings",
        },
      };
    }
  }
};
</script>

<style lang="scss">
.k-editor-video-block {
  margin: 1.5rem 0;
}
.k-editor-video-block figure {
  outline: 0;
  line-height: 0;
  background: #fff;
}
.k-editor-video-block iframe {
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 100%;
  border: 0;
}
.k-editor-video-block-embed {
  position: relative;
  padding-bottom: 56.25%;
  width: 100%;
}
.k-editor-video-block-embed iframe {
  pointer-events: none;
}
.k-editor-video-block .k-editor-video-block-embed:focus {
  outline: 2px solid #b5d7fe;
  outline-offset: 2px;
  pointer-events: all;
}
.k-editor-video-block-placeholder {
  line-height: 1;
}
.k-editor-video-block-placeholder button {
  padding: .75rem;
  display: block;
  width: 100%;
  border-radius: 3px;
  border: 1px dashed #ddd;
}
</style>
