<template>
  <div class="menu">
    <submenu-component
      v-for="(submenu, index) in submenus"
      :key="index"
      :id="submenu"
      @submenu-selected="selected(index, $event)"
    ></submenu-component>
  </div>
</template>
<script>
export default {
  data: function () {
    return {
      submenus: [""],
    };
  },
  methods: {
    selected: function (id, event) {
      this.submenus.splice(id + 1);
      if (id == 0 && event == -1) {
        this.$emit('menu-selected', 'latest');
      } else if (event == -1) {
        this.$emit('menu-selected', this.submenus[this.submenus.length -1]);
      } else {
        this.submenus.push(event);
        this.$emit('menu-selected', event);
      }
    },
  },
};
</script>