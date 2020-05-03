import Vue from 'vue'
import Vuex from 'vuex'
import { mutations, KEY_TOKEN, KEY_JWT } from './mutations'
import actions from './actions'
import getters from './getters'

Vue.use(Vuex)
export const store = new Vuex.Store({
  state: {
    message: 'Hello =)',
    loader: false,
    getMonth: (new Date).getMonth() + 1,
    getYear: (new Date).getFullYear(),
    currentMonth: (new Date).getMonth() + 1,
    currentDay: (new Date).getDate(),
    currentYear: (new Date).getFullYear(),
    statistic: {
      percentCurrent: 0,
      percentForecast: 0,
      sumCurrent: 0,
      sumEfficiency: 0,
      sumForecast: 0,
      sumPlan: 0,
    }
  },
  getters,
  actions,
  mutations,
})
