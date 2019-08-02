editor.block("table", {
  // will appear as title in the blocks dropdown
  label: "Table",

  // icon for the blocks dropdown
  icon: "menu",

  // the type is required and will be used to
  // load the right component and snippet
  type: "table",

  // get the content and attrs of the block as props
  props: {
    content: String,
    attrs: [Array, Object],
  },

  data() {
    return {
      columns: this.attrs.columns || [
        {
          id: this.uuid(),
          label: ""
        },
        {
          id: this.uuid(),
          label: ""
        }
      ],
      rows: this.attrs.rows || [
        ["", ""],
        ["", ""]
      ]
    };
  },

  watch: {
    columns: {
      handler() {
        if (this.columns.length === 0) {
          this.columns = [{
            id: this.uuid(),
            label: ""
          }];
        }
      },
      immediate: true
    }
  },

  // block methods
  methods: {
    prependColumn(before) {
      this.insertColumn(before);
    },
    appendColumn(after) {
      this.insertColumn(after + 1);
    },
    insertColumn(index) {
      this.columns.splice(index, 0, {
        id: this.uuid(),
        label: ""
      });

      this.rows.forEach(row => {
        row.splice(index, 0, "");
      });
    },
    appendRow(after) {
      this.rows.push([]);
    },
    deleteColumn(index) {
      this.columns.splice(index, 1);
      this.rows.forEach(row => {
        this.$delete(row, index);
      });
    },
    update() {
      this.$emit("input", {
        attrs: {
          columns: this.columns,
          rows: this.rows
        }
      });
    },
    updateColumn(html, column) {
      this.$set(this.columns[column], "label", html);
      this.update();
    },
    updateCell(html, row, cell) {
      this.$set(this.rows[row], cell, html);
      this.update();
    },
    uuid() {
      return '_' + Math.random().toString(36).substr(2, 9);
    }
  },
  template: `
    <div>
      <table>
        <tr>
          <th v-for="(column, columnKey) in columns" :key="column.id">
            <div>
              <k-editable
                :content="column.label"
                :marks="[]"
                placeholder="New column …"
                @input="updateColumn($event, columnKey)"
              />
              <k-dropdown>
                <k-button class="k-editor-table-block-column-settings" icon="angle-down" @click="$refs['columnSettings-' + column.id][0].toggle()" />
                <k-dropdown-content :ref="'columnSettings-' + column.id" align="right">
                  <k-dropdown-item icon="angle-left" @click="prependColumn(columnKey)">Insert left</k-dropdown-item>
                  <k-dropdown-item icon="angle-right" @click="appendColumn(columnKey)">Insert right</k-dropdown-item>
                  <hr>
                  <k-dropdown-item icon="trash" @click="deleteColumn(columnKey)">Delete column</k-dropdown-item>
                </k-dropdown-content>
              </k-dropdown>
            </div>
          </th>
        </tr>
        <tr v-for="(row, rowIndex) in rows" :key="rowIndex">
          <td v-for="(column, columnIndex) in columns" :key="column.id + '-' + rowIndex">
            <k-editable
              :breaks="true"
              :content="row[columnIndex]"
              @input="updateCell($event, rowIndex, columnIndex)"
              @enter="appendRow(rowIndex)"
            />
          </td>
        </tr>
      </table>
    </div>
  `,
});

