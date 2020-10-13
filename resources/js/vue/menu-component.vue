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
      this.submenus.push(event);
      this.$emit('menu-selected', event);
    },
  },
};
</script>