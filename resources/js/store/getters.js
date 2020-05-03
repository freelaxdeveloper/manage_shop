export default {
  message: state => state.message,
  getMonth: state => state.getMonth,
  getYear: state => state.getYear,
  currentDay: state => state.currentDay,
  currentMonth: state => state.currentMonth,
  currentYear: state => state.currentYear,
  statistic: state => state.statistic,
  isCurrentDate: state => state.getMonth === state.currentMonth && state.getYear === state.currentYear
}
