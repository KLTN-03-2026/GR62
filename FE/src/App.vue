<template>
  <component :is="layout">
      <router-view></router-view>
  </component>
</template>

<script>
const default_layout = "default";
export default {
  computed: {
    layout() {
      return (this.$route.meta.layout || default_layout) + "-layout";
    },
  },
};
</script>
<style>
.partner-dashboard-wrapper .main-layout {
  display: flex;
  width: 100%;
  min-width: 0;
}

.partner-dashboard-wrapper .sidebar-business {
  flex: 0 0 320px;
  width: 320px;
  min-width: 320px;
  max-width: 320px;
}

.partner-dashboard-wrapper main {
  flex: 1 1 auto;
  min-width: 0;
}
</style>
