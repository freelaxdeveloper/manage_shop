<template>
    <div>
        {{ item.name }}
        ( план -
        <span v-if="item.forecastService" v-number_format="item.forecastService.plan"></span>
        <span v-else>не указан</span>
        <span v-if="item.forecastService">{{ item.unit }}</span>)
        <a
            v-if="!show_form && isCurrentDate && item.forecastService"
            href="#"
            @click.prevent="show_form = true"
            class="badge badge-info"
            style="color: #fff;"
        >
            +
        </a>
        <span v-else-if="isCurrentDate && item.forecastService">
            <input
                v-model="money"
                type="text"
                size="3"
                class="form-control form-control-sm"
                style="display: inline-block; width: 80px;"
            >
            <button @click="makeMoney" class="btn btn-primary btn-sm">Добавить</button>
            <a href="#" @click.prevent="close" class="btn btn-light">Отмена</a>
        </span><br/>
        <small v-if="item.forecastService">
            Факт <span v-number_format="item.forecastService.performanceCurrent"></span> {{ item.unit }},
            Прогноз {{ item.forecastService.forecast }}%
            (<span v-number_format="item.forecastService.forecastMoney"></span> {{ item.unit }}),<br>
            Рекомендовано: <span v-number_format="item.forecastService.performanceToDay"></span> {{ item.unit }} в день
        </small>
        <div v-if="show_form || !isCurrentDate">
            <span
                v-for="(stat, i) in item.statistics"
                :key="`stat-item-${i}`"
                class="stat-item"
                data-toggle="tooltip"
                data-placement="top"
                :title="stat.date"
                style="cursor: pointer;"
            >
                <span v-number_format="stat.count"></span>{{ item.unit }}
            </span>
        </div>
        <div class="progress" v-if="item.forecastService">
            <div
                class="progress-bar"
                role="progressbar"
                :style="`width: ${item.forecastService.currentlyCompleted}%;`"
                :aria-valuenow="item.forecastService.currentlyCompleted"
                aria-valuemin="0"
                aria-valuemax="100"
            >
                {{ item.forecastService.currentlyCompleted }}%
            </div>
        </div>
        <hr>
    </div>
</template>

<style scoped>
    .stat-item {
        display: inline-block;
        padding: 5px;
        background-color: aliceblue;
        margin: 3px;
    }
</style>

<script>
  import axios from 'axios'

  export default {
    props: ['item', 'isCurrentDate'],
    name: "Item",
    data () {
      return {
        show_form: false,
        money: '',
      }
    },
    methods: {
      makeMoney () {
        axios.post('/api/statistics', {
          category_id: this.item.id,
          count: this.money,
        }).then(() => {
          this.$emit('update-items');
        });

        this.close();
      },
      close () {
        this.money = '';
        this.show_form = false;
      }
    }
  }
</script>

<style scoped>

</style>
