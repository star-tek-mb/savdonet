<template>
  <div class="card">
    <img
      :src="'/storage/' + product.variations[0].photo_url"
      class="card-img-top"
      :alt="__(product.title)"
    />
    <div class="card-body">
      <p class="h5 card-title">
        {{ __(product.title) }}
        <price inline-template :sale-price="get_sale_price(product)" :price="get_price(product)">
          <div v-if="salePrice[0] != price[0] || salePrice[1] != price[1]">
            <del v-if="price[0] == price[1]" class="font-weight-bold">{{ price[0] | currency }} {{ __('currency') }}</del>
            <del v-if="price[0] != price[1]" class="font-weight-bold">{{ price[0] | currency }} - {{ price[1] | currency }}  {{ __('currency') }}</del>
            <br>
            <span v-if="salePrice[0] == salePrice[1]" class="font-weight-bold">{{ salePrice[0] | currency }} {{ __('currency') }}</span>
            <span v-else-if="salePrice[0] != salePrice[1]" class="font-weight-bold">{{ salePrice[0] | currency }} - {{ salePrice[1] | currency }}  {{ __('currency') }}</span>
          </div>
          <div v-else>
            <span v-if="price[0] == price[1]" class="font-weight-bold">{{ price[0]  | currency }} {{ __('currency') }}</span>
            <span v-if="price[0] != price[1]" class="font-weight-bold">{{ price[0]  | currency }} - {{ price[1] | currency }}  {{ __('currency') }}</span>
          </div>
        </price>
      </p>
      <p>{{ __(product.description) | strip | trunc(200) }}</p>
    </div>
    <div class="mb-4 mr-4 text-right">
      <a v-if="product.options.length == 0" class="btn btn-primary" :href="'/' + documentLanguage + '/cart/' + product.variations[0].id">{{ __("To Cart") }}</a>
      <a class="btn btn-info" :href="'/' + documentLanguage + '/product/' + product.id">{{ __("More") }}</a>
    </div>
  </div>
</template>
<script>
export default {
  props: ["product"],
  components: {
    price: {
      props: ["salePrice", "price"]
    }
  },
  methods: {
    get_date: function(date) {
      var dateParts = date.split("-");
      return new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0, 2));
    },
    get_price: function(product) {
      var min = 999999999;
      var max = 0;
      for (let i = 0; i < product.variations.length; i++) {
        var p = product.variations[i];
        var price = p.price;
        if (price < min) {
          min = price;
        }
        if (price > max) {
          max = price;
        }
      }
      return [min, max];
    },
    get_sale_price: function(product) {
      var min = 999999999;
      var max = 0;
      for (let i = 0; i < product.variations.length; i++) {
        var p = product.variations[i];
        var price = p.sale_price;
        var now = Date.now();
        if (!p.sale_price || !product.variations[i].sale_start || !product.variations[i].sale_start) {
          price = p.price;
        } else {
          var sale_start = this.get_date(product.variations[i].sale_start).getTime();
          var sale_end = this.get_date(product.variations[i].sale_end).getTime();
          if (sale_start > now || now > sale_end) {
            price = p.price;
          }
        }
        if (price < min) {
          min = price;
        }
        if (price > max) {
          max = price;
        }
      }
      return [min, max];
    }
  }
};
</script>