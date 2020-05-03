<template>
    <div class="card-header" style="font-size: 19px;">
        Прогноз на текущий месяц
        <div
            v-if="spinner"
            class="spinner-grow text-warning"
            style="width: 3rem; height: 3rem; position: absolute;"
            role="status"
        >
                            <span class="sr-only">
                                Loading...
                            </span>
        </div>

        <h6
            v-if="isCurrentDate"
            class="card-subtitle mb-2 text-muted"
        >
            {{ subtitle }}

        </h6>
        <div v-else>
            <button
                @click="$emit('reset')"
                class="btn btn-primary btn-sm"
            >
                Сбросить
            </button>
        </div>

    </div>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    name: "Toolbar",
    props: ['spinner', 'subtitle'],
    computed: {
      ...mapGetters([
        'isCurrentDate'
      ])
    }
  }
</script>

<style scoped>

</style>
