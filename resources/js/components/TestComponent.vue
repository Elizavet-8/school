<template>
    <div class="row">
        <div class="col-12 mt-2 mb-2" v-if="!loading && !completed">
            <span>
                до окончания теста
            </span>
            <Timer
                :hours="hours"
                :minutes="minutes"
                :seconds="seconds"
                v-on:late="submit"
            />
        </div>
        <div class="col-12" v-if="!loading && completed">
            <div v-if="test_good" class="alert alert-success" role="alert">
                Тест сдан! Вы дали верные ответы на {{ correct_answers }} из
                {{ questions.length }}
            </div>
            <div v-if="test_bad" class="alert alert-danger" role="alert">
                Тест не сдан! Вы дали верные ответы на {{ correct_answers }} из
                {{ questions.length }} (необходимо не менее
                {{ test.min_correct }} верных ответов)
            </div>
            <div v-for="(item, index) in answer_list" :key="index + 'o'">
                {{ ++index }}. {{ item.answer ? "верно" : "неверно" }}
            </div>
            <button
                @click="repeat"
                type="button"
                class="btn btn-outline-primary"
            >
                Сдать еще раз
            </button>
        </div>
        <div class="col-12" v-if="!loading && !completed">
            <form v-on:submit.prevent="submit">
                <div class="row">
                    <div
                        class="col-12"
                        v-for="(question, index) in questions"
                        :key="index"
                    >
                        <question-one
                            v-if="question.type == 'one'"
                            :question="question"
                            :index="++index"
                            v-on:answer="handlerAnswers"
                        ></question-one>
                        <question-many
                            v-if="question.type == 'many'"
                            :question="question"
                            :index="++index"
                            v-on:answer="handlerAnswers"
                        ></question-many>
                        <question-write
                            v-if="question.type == 'write'"
                            :question="question"
                            :index="++index"
                            v-on:answer="handlerAnswers"
                        ></question-write>
                    </div>
                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-outline-primary">
                            Завершить тест
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div
            v-if="loading"
            class="col-md-12"
            style="display:flex;justify-content:center"
        >
            <h4>Загрузка...</h4>
        </div>
    </div>
</template>

<script>
import QuestionOne from "./QuestionOne.vue";
import QuestionMany from "./QuestionMany.vue";
import QuestionWrite from "./QuestionWrite.vue";
import Timer from "./Timer";

export default {
    props: ["user", "test"],
    components: {
        QuestionOne,
        QuestionMany,
        QuestionWrite,
        Timer
    },
    created() {
        this.getQuestions();
        this.setTimeInMinutes();
    },
    data: function() {
        return {
            loading: false,
            completed: false,
            questions: [],
            answer_list: [],
            test_good: false,
            test_bad: false,
            correct_answers: "",
            // for timer
            hours: 1,
            minutes: 30,
            seconds: 0
        };
    },
    methods: {
        repeat() {
            this.questions = [];
            this.getQuestions();
            this.setTimeInMinutes();
            this.test_good = false;
            this.test_bad = false;
            this.completed = false;
        },
        submit() {
            this.completed = true;
            const neededCorrect = this.test.min_correct;
            let actualCorrect = 0;

            this.answer_list.forEach(item => {
                if (item.answer) {
                    actualCorrect++;
                }
            });

            if (neededCorrect <= actualCorrect) {
                this.test_good = true;
            } else {
                this.test_bad = true;
            }

            this.correct_answers = actualCorrect;

            axios
                .post("/attempt", {
                    user_id: this.user.id,
                    test_id: this.test.id,
                    correct: actualCorrect,
                    questions: this.questions.length,
                    is_passed: this.test_good
                })
                .then(res => {
                    console.log(res);
                })
                .catch(err => {
                    console.log(err);
                });
        },
        setTimeInMinutes() {
            let tempMin = this.test.minutes;
            let tempHour = 0;
            while (tempMin >= 60) {
                tempMin -= 60;
                tempHour++;
            }

            if (!isNaN(tempHour) && tempHour >= 0) {
                this.hours = tempHour;
            }

            if (!isNaN(tempMin) && tempMin >= 0) {
                this.minutes = tempMin;
            }
        },
        getQuestions() {
            this.loading = true;
            axios
                .get(`/test/${this.test.id}/json`)
                .then(res => {
                    console.log(res);
                    let questions = res.data.data.questions;

                    questions.forEach(question => {
                        question.answers = JSON.parse(question.answers);
                        this.questions.push(question);
                    });

                    this.loading = false;
                })
                .catch(err => {
                    this.loading = false;
                });
        },
        handlerAnswers(data) {
            const index = this.answer_list
                .map(item => item.question_index)
                .indexOf(data.question_index);

            console.log(this.answer_list);

            if (index === -1) {
                return this.answer_list.push(data);
            }

            return (this.answer_list[index] = data);
        }
    }
};
</script>
