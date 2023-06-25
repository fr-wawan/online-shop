const mixins = {
  methods: {
    formatPrice(value) {
      const formatter = new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "USD",
      });
      return formatter.format(value);
    },
    uppercaseLetter(value) {
      return value.charAt(0).toUpperCase() + value.slice(1);
    },
  },
};

export default mixins;
