<script>
import H1 from "./H1.vue";

export default {
  ...H1,
  label: "Heading 2",
  placeholder: "Heading 2"
};
</script>

<style lang="scss">
.k-editor-h2-block .ProseMirror {
  font-size: 1.25rem;
  font-weight: 600;
  line-height: 1.5em;
  display: block;
  margin-bottom: .75rem;
}
</style>
