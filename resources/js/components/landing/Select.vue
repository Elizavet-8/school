<template>
  <div class="register__select" @click="toggle()">
    <div class="register__input">
      <div class="register__label" v-if="!label">
        <span>{{ select.value }}</span>
      </div>
      <div class="register__label" v-else>
        <span> {{ label }}</span>
      </div>
      <svg
        class="arrow"
        :class="{ active: !visible, visible }"
        width="12"
        height="7"
        viewBox="0 0 12 7"
        fill="none"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          d="M12 0.524487C12 0.583584 11.9884 0.642109 11.9658 0.696717C11.9432 0.751325 11.91 0.800946 11.8682 0.842747L6.31841 6.38877C6.23398 6.47312 6.11948 6.52051 6.00009 6.52051C5.88071 6.52051 5.76621 6.47312 5.68178 6.38877L0.131955 0.842747C0.0901343 0.800972 0.0569561 0.751375 0.0343152 0.696786C0.0116743 0.642197 1.39498e-05 0.583685 1.25089e-08 0.524593C-1.39248e-05 0.4655 0.0116188 0.406984 0.034234 0.352384C0.0568492 0.297784 0.090004 0.24817 0.131805 0.206375C0.173607 0.164581 0.223236 0.131424 0.27786 0.108798C0.332483 0.0861707 0.391031 0.0745173 0.450161 0.0745034C0.509291 0.0744891 0.567845 0.0861149 0.622479 0.108716C0.677114 0.131317 0.726759 0.164451 0.76858 0.206226L5.99994 5.43429L11.2313 0.206226C11.2943 0.143259 11.3745 0.100373 11.4619 0.0829945C11.5492 0.0656166 11.6398 0.0745268 11.7221 0.108599C11.8044 0.142671 11.8747 0.200374 11.9242 0.274405C11.9737 0.348435 12 0.435466 12 0.524487Z"
          fill="#14134F"
        />
      </svg>
    </div>
    <ul class="register__options" :class="{ hidden: !visible, visible }">
      <li v-for="item in select.list" @click="selectItem(item)" :key="item">
        {{ item }}
      </li>
    </ul>
  </div>
</template>
<script>
export default {
  props: ["select"],
  data: () => ({
    visible: false,
    label: null,
  }),
  methods: {
    toggle() {
      this.visible = !this.visible;
    },
    selectItem(item) {
      console.log(item);
      this.label = item;
      this.$emit("result", item);
    },
  },
};
</script>