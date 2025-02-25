<template>
  <ol class="breadcrumbs">
    <li class="link" v-for="(item, index) in items" :key="index">
      <span class="text"> / </span>
      <router-link v-if="item.to" class="link" :to="item.to">
        <span v-if="item.icon" class="icon" v-html="item.icon"></span>
        {{ item.text }}
      </router-link>
      <span v-else class="text">
        <span v-if="item.icon" class="icon" v-html="item.icon"></span>
        {{ item.text }}
      </span>
    </li>
  </ol>
</template>

<script>
import Logo from '@/components/base/logo/Logo.vue'
export default {
  name: 'Breadcrumbs',
  components: {
    Logo
  },
  props: {
    items: {
      type: Array,
      required: false,
      default: () => [{ text: 'Item', to: '/' }]
    },
    color: {
      type: String,
      required: false,
      default: 'black'
    }
  }
}
</script>

<style lang="scss" scoped>
@import '@/utilities/css/vars/vars.scss';

.breadcrumbs {
  display: flex;
  align-items: center;
  width: 100%;
  gap: 0.5rem;
  font-size: 18px;
}

.link {
  font-family: $FONT-BOLD;
  text-decoration: none;
  white-space: nowrap;
  color: v-bind(color);
  padding-inline-start: 3px;
  display: flex;
  align-items: center;
}

.text {
  font-family: $FONT-REGULAR;
  text-decoration: none;
  white-space: nowrap;
  color: v-bind(color);
  display: flex;
  align-items: center;
}

.icon {
  display: inline-flex;
  align-items: center;
  margin-right: 4px;

  :deep(svg) {
    width: 24px;
    height: 24px;
    fill: currentColor;
  }
}
</style>
