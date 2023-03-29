<template>
  <div class="w-full p-6 bg-teal-100 text-right font-bold">Your wallet has: {{ coins }} coins</div>
</template>

<script>
import { EventBus } from '../event-bus';

export default {
  name: "CoinsCounter",
  data() {
    return {
      coins: 0
    }
  },
  mounted() {
    this.fetchCoins();
  },
  methods: {
    async fetchCoins() {
      const response = await axios
          .get('http://localhost:8080/coins-count')

      this.coins = response.data.coins
    }
  },
  beforeMount() {
    EventBus.$on('update-coins', this.fetchCoins);
  },
  beforeDestroy() {
    EventBus.$off('update-coins', this.fetchCoins);
  }
}
</script>
