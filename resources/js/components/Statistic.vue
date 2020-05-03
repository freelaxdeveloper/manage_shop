<template>
  <div class="thermometer_content">
      <div :class="[`thermometer_${index}`, 'thermometer']">

        <div class="track">
          <div :class="['goal', 'goal_' + index]">
            <div :class="['amount', 'amount_' + index]"> {{ goal }} </div>
          </div>
          <div :class="['progress', 'progress_' + index]">
            <div :class="['amount', 'amount_' + index]"> {{ progress }} </div>
          </div>
        </div>
        <div style="margin-top: 20px;min-width: 250px;">
          {{ title }}
        </div>

      </div>

  </div>
</template>

<script>
  import $ from 'jquery'

  export default {
    name: "Statistic",
    props: ['index', 'goal', 'progress', 'title', 'symbol'],
    data () {
      return {
        test: false,
      }
    },
    watch: {
      progress: function (val) {
        this.thermometer();
      },
      goal: function (val) {
        this.thermometer();
      }
    },
    mounted() {
      this.thermometer();
    },
    methods: {
      thermometer (goalAmount, progressAmount, animate) {
        var $thermo = $(".thermometer_" + this.index),
          $progress = $(".progress_" + this.index, $thermo),
          $goal = $(".goal_" + this.index, $thermo),
          percentageAmount;

        goalAmount = goalAmount || parseFloat( this.goal ),
          progressAmount = progressAmount || parseFloat( this.progress ),
          percentageAmount =  Math.min( Math.round(progressAmount / goalAmount * 1000) / 10, 100); //make sure we have 1 decimal point
        console.log('percentageAmount', percentageAmount)
        //let's format the numbers and put them back in the DOM
        $goal.find(".amount_" + this.index).text( this.formatCurrency( goalAmount ) + this.symbol );
        $progress.find(".amount_" + this.index).text( this.formatCurrency( progressAmount ) + this.symbol );


        //let's set the progress indicator
        $progress.find(".amount_" + this.index).hide();
        if (animate !== false) {
          $progress.animate({
            "height": percentageAmount + "%"
          }, 1200, () => {
            $progress.find(".amount_" + this.index).fadeIn(500);
          });
        }
        else {
          $progress.css({
            "height": percentageAmount + "%"
          });
          $progress.find(".amount_" + this.index).fadeIn(500);
        }
      },
      formatCurrency (n, c, d, t) {
        var s, i, j;

        c = isNaN(c = Math.abs(c)) ? 2 : c;
        d = d === undefined ? "." : d;
        t = t === undefined ? "," : t;

        s = n < 0 ? "-" : "";
        i = parseInt(n = Math.abs(+n || 0).toFixed(c), 10) + "";
        j = (j = i.length) > 3 ? j % 3 : 0;

        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
      }
    }
  }
</script>

<style lang="scss" scoped>
  .thermometer_content {
    width:200px;
    margin:30px 0;
    /*display: inline-flex;*/
  }

  .thermometer {
    width:70px;
    height:300px;
    position: relative;
    background: #fff;
    border:1px solid #fff;
    -webkit-border-radius: 12px;
    -moz-border-radius: 12px;
    -ms-border-radius: 12px;
    -o-border-radius: 12px;
    border-radius: 12px;

    -webkit-box-shadow: 1px 1px 4px #fff, 5px 0 20px #d6d5d5;
    -moz-box-shadow: 1px 1px 4px #fff, 5px 0 20px #d6d5d5;
    -ms-box-shadow: 1px 1px 4px #fff, 5px 0 20px #d6d5d5;
    -o-box-shadow: 1px 1px 4px #fff, 5px 0 20px #d6d5d5;
    box-shadow: 1px 1px 4px #fff, 5px 0 20px #d6d5d5;
  }

  .thermometer .track {
    height:280px;
    top:10px;
    width:20px;
    border: 1px solid #aaa;
    position: relative;
    margin:0 auto;
    background: rgb(255,255,255);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgb(0,0,0)), color-stop(1%,rgb(255,255,255)));
    background: -webkit-linear-gradient(top, rgb(0,0,0) 0%,rgb(255,255,255) 10%);
    background:      -o-linear-gradient(top, rgb(0,0,0) 0%,rgb(255,255,255) 10%);
    background:     -ms-linear-gradient(top, rgb(0,0,0) 0%,rgb(255,255,255) 10%);
    background:    -moz-linear-gradient(top, rgb(0,0,0) 0%,rgb(255,255,255) 10%);
    background:   linear-gradient(to bottom, rgb(0,0,0) 0%,rgb(255,255,255) 10%);
    background-position: 0 -1px;
    background-size: 100% 5%;
  }

  .thermometer .progress {
    font-size: 0.875rem;
    overflow: visible;
    height:0%;
    width:100%;
    background: rgba(7, 172, 228, 0.67);
    position: absolute;
    bottom:0;
    left:0;
  }

  .thermometer .goal {
    position:absolute;
    top:0;
  }

  .thermometer .amount {
    disply: inline-block;
    padding:0 5px 0 60px;
    border-top:1px solid #b1b0b0;
    font-family: Trebuchet MS;
    font-weight: bold;
    color:#404142;
  }

  .thermometer .progress .amount {
    padding:0 60px 0 5px;
    position: absolute;
    border-top:1px solid #060;
    color:#060;
    right:0;
  }

</style>
