<script>
import VueHtmlToPaper from 'vue-html-to-paper';
 
export default {
  data() {
    return {
      output: null
    }
  },
  methods: {
    print() {
      // Pass the element id here
      this.$htmlToPaper('printMe');
    }
  }
}
</script>
 
<template>
  <div>
    <!-- SOURCE -->
    <div id="printMe">
      <h1>Print me!</h1>
    </div>
    <!-- OUTPUT -->
    <button @click="print" type="button">Print</button>
  </div>
</template>