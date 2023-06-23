const mixins = {
  methods: {
    formatPrice(value) {
      const formatter = new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
      });
      return formatter.format(value);
    },
  },
};

export default mixins;
