<template>
  <div class="submenu">
    <a
      :class="{ 'selected': category.id == active }"
      v-for="category in categories"
      :key="category.id"
      @click="selected(category.id)"
    >
      {{ __(category.title) }}
    </a>
  </div>
</template>
<style>
.submenu {
  overflow: auto;
  white-space: nowrap;
  line-height: 3rem;
}
.submenu a {
  font-size: 1.1rem;
  font-weight: bold;
  cursor: pointer;
  padding: 0 0.5rem;
  background: #ecf0fa;
  color: black !important;
  margin-right: 1rem;
  margin-bottom: 0.5rem;
  border-radius: 5px;
  display: inline-block;
}
.submenu a.selected {
  background: #85c1ff !important;
  color: white !important;
}
.submenu a:hover {
  text-decoration: none;
  color: #85c1ff !important;
}
.submenu a.selected:hover {
  color: white !important;
}
@media (min-width: 768px) {
  .submenu {
    white-space: normal;
    display: inline;
    overflow: hidden;
  }
}
</style>
<script>
export default {
  props: ["id"],
  data: function () {
    return {
      active: -1,
      categories: [],
    };
  },
  methods: {
    selected: function (id) {
      if (this.active == id) {
        this.active = -1;
      } else {
        this.active = id;
      }
      this.$emit("submenu-selected", this.active);
    },
  },
  watch: {
    id: function (val) {
      this.active = -1;
      axios
        .get("/api/category/" + val)
        .then((response) => (this.categories = response.data));
    },
  },
  mounted() {
    this.active = -1;
    axios
      .get("/api/category/" + this.id)
      .then((response) => (this.categories = response.data));
  },
};
</script>