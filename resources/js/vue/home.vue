<template>
  <div class="container">
    <menu-component @menu-selected="selected($event)"></menu-component>
    <div class="my-4 row">
      <div
        class="col-12 col-md-6 col-lg-4 py-2"
        v-for="product in products"
        :key="product.id"
      >
        <product-component class="h-100" :product="product"></product-component>
      </div>
    </div>
    <infinite-loading
      :identifier="category"
      spinner="waveDots"
      @infinite="loader"
    >
      <div slot="no-more"></div>
      <div slot="no-results">
        {{ __("Category is empty!") }}
      </div>
      </infinite-loading
    >
  </div>
</template>
<script>
export default {
  name: "Home",
  data: function () {
    return {
      page: 1,
      products: [],
      category: "latest",
    };
  },
  methods: {
    selected: function (event) {
      if (this.category != event) {
        this.category = event;
        this.products = [];
        this.page = 1;
      }
    },
    loader($state) {
      axios
        .get("/api/products/" + this.category, {
          params: {
            page: this.page,
          },
        })
        .then(({ data }) => {
          if (data.data.length > 0 || Object.values(data.data).length > 0) {
            this.products = this.products.concat(Object.values(data.data));
            this.page += 1;
            $state.loaded();
          } else {
            $state.complete();
          }
        });
    },
  },
};
</script>