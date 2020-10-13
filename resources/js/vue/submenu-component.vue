<template>
  <div class="submenu">
    <a
      class="text-primary mx-2"
      :class="{ 'text-danger': category.id == active }"
      v-for="category in categories"
      :key="category.id"
      @click="selected(category.id)"
    >
      {{ __(category.title) }}
    </a>
  </div>
</template>
<style scoped>
.submenu {
  overflow: auto;
  white-space: nowrap;
}
.submenu a {
  margin-bottom: 5px;
  font-size: 1.1rem;
  font-weight: bold;
  cursor: pointer;
}
.submenu a:hover {
  text-decoration: none;
}
@media (min-width: 768px) {
  .submenu {
    white-space: normal;
    display: inline;
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
      this.$emit("submenu-selected", id);
      this.active = id;
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