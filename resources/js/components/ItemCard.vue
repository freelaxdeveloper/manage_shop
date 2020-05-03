<template>
    <div class="coin-box" @dblclick.stop="openDetails" @click="toggle">
        <div class="row no-gutters coin-info">
            <div class="col-7">
                <div class="font-weight-bold">{{ item.name }} <span v-if="!item.forecastService">(план не указан)</span></div>
                <div class="row no-gutters mt-1">
                    <!--                    <div class="box-icon">-->
                    <!--                        <span :style="{ backgroundImage : 'url('+ iconbase +')' }"></span>-->
                    <!--                    </div>-->
                    <div class="col text-left" v-if="item.forecastService">
                        <div><b><span v-number_format="item.forecastService.performanceCurrent"></span> {{ item.unit }}</b>/<span v-if="item.forecastService" v-number_format="item.forecastService.plan"></span> грн.</div>
                        <!--                        <div class="coin-price" v-if="ticker.price">2,666.667<span style="font-size: x-small; font-weight: 700; padding-left: 3px;">грн.</span></div>-->
                    </div>
                </div>
            </div>
            <!--            <div :class="[(ticker.percent < 0)?'down':'up', 'col-5','text-right']" v-if="ticker.price">-->
            <div :class="[color, 'col-5','text-right']" v-if="item.efficiencyService">
                <div class="coin-per"><span class="indicator"></span><span>{{ item.efficiencyService.calculateEfficiency }}%</span></div>
                <div class="coin-chg">{{ item.forecastService.forecast }}%</div>
                <div>
                    <!--                    <span class="text-secondary">Прогноз: </span> -->
                    <span class="text-dark"><span v-number_format="item.forecastService.forecastMoney"></span> {{ item.unit }}</span></div>
            </div>
<!--            <div class="dd-container" :class="[{'show': showDropDown}]" v-click-outside="closeDropDown">-->
<!--                    <span role="button" class="menu-btn" @click.stop="onDropDown">-->
<!--                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>-->
<!--                    </span>-->
<!--                <div class="dd-menu" v-if="showDropDown">-->
<!--                    <span class="dd-item" @click="openDetails">Open</span>-->
<!--                    <span class="dd-item" @click="removeCard">Delete</span>-->
<!--                </div>-->
<!--            </div>-->
        </div>
        <div class="sparkline-chart">
            <pure-vue-chart
                :points="item.statisticData"
                :show-x-axis="true"
                :show-y-axis="false"
                :show-values="false"
                :width="380"
                :height="90"
            />
        </div>
    </div>
</template>

<script>
  import { mapGetters } from 'vuex'

  import PureVueChart from 'pure-vue-chart';

    export default {
        props: ['item', 'info', 'toggle'],
        data() {
            return {
                test: 0,
                showDropDown: false,
                // iconbase: 'https://raw.githubusercontent.com/rainner/binance-watch/master/public/images/icons/' + this.info.base.toLowerCase() + '_.png'
            }
        },
        computed: {
          ...mapGetters([
            'currentDay',
          ]),
          color: function () {
            let offset = 1;

            let current = this.item.statisticData[this.currentDay - offset];
            if (!current) {
              offset = 2;
              current = this.item.statisticData[this.currentDay - offset];
            }
            const previous = this.item.statisticData[this.currentDay - (offset + 1)];

            return current >= previous ? 'up' : 'down';
          }
        },
        mounted() {
            setInterval(() => {
                this.$forceUpdate();
            }, 1000)
            const doSomething = async () => {
                for (const item of [0, 80, 60, 50, 45, 100]) {
                    await this.sleep(5000)
                    this.test = item;
                }
            }

            doSomething()
            // [10, 15, 35, 15].map(item => {
            //   await sleep(2000)
            //   this.test = item;
            // })
            // setInterval(() => {
            //   this.test = Math.ceil(Math.random() * 100)
            // }, 2000)
        },
        methods: {
            sleep(milliseconds) {
                return new Promise(resolve => setTimeout(resolve, milliseconds))
            },
            onDropDown() {
                this.showDropDown = true;
            },
            openDetails() {
                this.showDropDown = false;
                this.$router.push({name: 'infoview', params: { 'symbol': this.info.symbol }})
            },
            closeDropDown() {
                this.showDropDown = false;
            }
        },
        components: {
            PureVueChart
        }
    }
</script>

<style scoped>

</style>
