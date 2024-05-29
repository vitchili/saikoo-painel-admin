<template>
  <div class="event-content" :style="{ backgroundColor: event.backgroundColor, color: event.color }">
    <div class="vuecal__event-title" v-html="event.title"></div>
    <hr />
    <em class="vuecal__event-time">
      <strong>{{ event.content }}</strong>
      <br>
      <span>{{ event.descricao }}</span>
    </em>
  </div>
</template>

<script>
export default {
  props: {
    event: Object
  }
}
</script>

<style scoped>
.event-content {
  padding: 1px;
  height: 100%;
  line-height: 1;
}

.vuecal__event-title {
    margin: 3px;
}
</style>
