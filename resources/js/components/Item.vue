<template>
    <div>
        <div
            class="float-md-right card-subtitle mb-2 text-muted"
            style="font-size: 15px;"
            v-if="item.efficiencyService && item.efficiency"
        >
            Факт. КПД: {{ item.efficiencyService.calculateEfficiency }}%
        </div>
        {{ item.name }}
        ( план -
        <span v-if="item.forecastService" v-number_format="item.forecastService.plan"></span>
        <span v-else>не указан</span>
        <span v-if="item.forecastService">{{ item.unit }}</span>)
        <img
            v-if="show_smile"
            :src="`/images/smiles/${smile.src}`"
            :style="`width: ${smile.width}px; float: right; position: absolute;left: 57%;`"
            alt="smile"
        >
        <a
            v-if="!show_form && isCurrentDate && item.forecastService"
            href="#"
            @click.prevent="show_form = true"
            class="badge badge-info"
            style="color: #fff;"
        >
            +
        </a>
        <div
            v-else-if="isCurrentDate && item.forecastService"
            style="margin-bottom: -25px;"
        >
            <input
                v-model="money"
                type="text"
                size="3"
                class="form-control form-control-sm"
                style="display: inline-block; width: 80px;"
            >
            <button
                @click="makeMoney"
                class="btn btn-primary btn-sm"
            >Добавить</button>
            <a href="#" @click.prevent="close" class="btn btn-light">Отмена</a>
        </div><br/>
        <small v-if="item.forecastService">
            Факт <span v-number_format="item.forecastService.performanceCurrent"></span> {{ item.unit }},
            Прогноз {{ item.forecastService.forecast }}%
            (<span v-number_format="item.forecastService.forecastMoney"></span> {{ item.unit }}),<br>
            Рекомендовано: <span v-number_format="item.forecastService.performanceToDay"></span> {{ item.unit }} в день,
            Вес КПД: {{ item.efficiency }}%
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
                :class="`progress-bar ${progressColor}`"
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
    .bg-warning {
        color: #6b5f5f;
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
        show_smile: false,
        money: '',
        smile: {
          src: '',
          width: 60,
        },
        smiles: {
          good: [
            {src: '1.gif', width: 60},
            {src: '2.gif', width: 60},
            {src: '161950406.gif', width: 60},
            {src: '271980162.gif', width: 60},
            {src: '858131397.gif', width: 60},
            {src: '883429311.gif', width: 60},
          ],
          bad: [
            {src: '0.jpg', width: 60},
            {src: '42786011.gif', width: 60},
            {src: '229178515.gif', width: 60},
            {src: '328835943.gif', width: 115},
            {src: '471769675.png', width: 60},
            {src: '675057070.gif', width: 60},
            {src: '718532537.gif', width: 60},
            {src: '733595102.gif', width: 60},
            {src: '753043402.gif', width: 60},
            {src: '784715539.gif', width: 42},
            {src: '811110244.gif', width: 60},
            {src: '903437111.gif', width: 60},
          ]
        }
      }
    },
    watch: {
      show_smile: function (val) {
        if (!val) {
          return;
        }
        setTimeout(() => {
          this.show_smile = false
        }, 6000)
      }
    },
    computed: {
      progressColor: function () {
        if (!this.item.forecastService) {
          return 'bg-primary';
        }
        if (this.item.forecastService.forecast > 100) {
          return 'bg-primary';
        }
        if (this.item.forecastService.forecast > 75) {
          return 'bg-success';
        }
        if (this.item.forecastService.forecast > 50) {
          return 'bg-warning';
        }

        return 'bg-danger';
      }
    },
    methods: {
      makeMoney () {
        if (!this.show_smile) {
          this.smile = this.getSmile();
          this.show_smile = true;
        }
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
      },
      getSmile () {
        if (Number(this.money) !== parseFloat(this.money)) {
          return null;
        }

        let dir = 'good';

        if  (this.money < this.item.forecastService.performanceToDay) {
          dir = 'bad';
        }
        const smiles = this.smiles[dir];
        const smile = smiles[Math.floor(Math.random() * smiles.length)];

        return {
          src: dir + '/' + smile.src,
          width: smile.width,
        };
      },
    }
  }
</script>

<style scoped>

</style>
