<template>
  <div>
    <template v-if="selectedTab == '1 класс'">
      <ul class="build__list">
        <li
          class="build__item"
          v-for="(subject, index) in subjects"
          :key="index"
          @click="selectedsubject = subject.title"
          :class="{ active: selectedsubject == subject.title }"
        >
          {{ subject.title }}
        </li>
      </ul>
    </template>
    <template v-if="selectedTab == '2 класс'"><h1>2</h1> </template>
    <SubjectProgram :selectedsubject="selectedsubject"></SubjectProgram>
  </div>
</template>
<script>
import SubjectProgram from "../landing/SubjectProgram.vue";
export default {
  props: ["selectedTab"],
  components: {
    SubjectProgram,
  },
  data: () => ({
    subjects: [
      {
        title: "Русский язык",
      },
      {
        title: "Алгебра",
      },
      {
        title: "Биология",
      },
      {
        title: "Иностранный язык",
      },
      {
        title: "География",
      },
      {
        title: "Обществознание",
      },
      {
        title: "Химия",
      },
      {
        title: "Литература",
      },
      {
        title: "Геометрия",
      },
      {
        title: "Информатика",
      },
      {
        title: "История",
      },
      {
        title: "Физика",
      },
    ],
    selectedsubject: "Русский язык",
  }),
  methods: {
    selectsubject() {
      this.selectedsubject = this.subject.title;
    },
  },
};
</script>