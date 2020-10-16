<template>
  <div class="card">
    <img
      :src="'/storage/' + product.variations[0].photo_url"
      class="card-img-top"
      :alt="__(product.title)"
    />
    <div class="card-body">
      <p class="h5 card-title">
        {{ __(product.title)
        }}<span class="text-danger float-right"
          >{{ product.variations[0].price }} {{ __('currency') }}</span
        >
      </p>
      <p>{{ trunc(__(product.description), 200) }}</p>
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
};
</script>