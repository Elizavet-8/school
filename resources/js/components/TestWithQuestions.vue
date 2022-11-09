<template>
    <form
        v-on:submit.prevent="submit"
        class="offset-lg-1 col-lg-7 materials-block pass-tests"
    >
        <p class="tests-title">
            {{ section.title }}. Тест {{ test.order }}.
            {{ test.title }}
        </p>
        <ul class="tests-list">
            <li class="tests-item">
                <p>
                    всего вопросов
                </p>
                <div>
                    {{ questionscount }}
                </div>
            </li>
            <li class="tests-item">
                <p>
                    правильных ответов для зачета
                </p>
                <div>
                    {{ test.min_correct }}
                </div>
            </li>
            <li class="tests-item">
                <p>
                    время на выполение
                </p>
                <div>{{ test.minutes }} минут</div>
            </li>
        </ul>
        <div
            v-if="loading"
            class="row"
            style="display: flex; justify-content: center;"
        >
            <div
                style="width: 3rem; height: 3rem; color: #fabe4b!important;"
                class="spinner-grow text-light"
                role="status"
            >
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div class="timer-block" v-if="!loading && !completed">
            <div class="row">
                <p>
                    до окончания теста
                </p>
                <Timer
                    :hours="hours"
                    :minutes="minutes"
                    :seconds="seconds"
                    v-on:late="submit"
                />
            </div>
        </div>
        <div v-if="test_good && completed" class="tests-good tests mb-3">
            <div>
                <button
                    type="button"
                    style="color:white;"
                    class="btn-active btn btn-good"
                >
                    Тест сдан
                </button>
                <p>
                    верных ответов <b>{{ correct_answers }}</b>
                </p>
            </div>
            <div>
                <button
                    v-if="available"
                    @click="startTest"
                    type="button"
                    style="color: black"
                    class="btn-active"
                >
                    Сдать еще раз
                </button>
            </div>
        </div>
        <div v-if="test_bad && completed" class="tests-bad tests mb-3">
            <div>
                <button
                    style="color:white;"
                    type="button"
                    class="btn-active btn btn-bad"
                >
                    Тест не сдан
                </button>
                <p>
                    верных ответов <b>{{ correct_answers }}</b>
                </p>
            </div>
            <div>
                <button
                    v-if="available"
                    @click="startTest"
                    type="button"
                    class="btn-active"
                    style="color: black"
                >
                    Пересдать
                </button>
            </div>
        </div>
        <div v-if="!loading && completedAndRequired" id="test">
            <div class="row">
                <div
                    class="col-12"
                    v-for="(question, index) in questions"
                    :key="index"
                >
                    <question-one
                        v-if="question.type == 'one'"
                        :question="question"
                        :questionsintest="questions.length"
                        :completed="completed"
                        :index="++index"
                        :answers="answer_list"
                        v-on:answer="handlerAnswers"
                    ></question-one>
                    <question-many
                        v-if="question.type == 'many'"
                        :question="question"
                        :questionsintest="questions.length"
                        :completed="completed"
                        :index="++index"
                        :answers="answer_list"
                        v-on:answer="handlerAnswers"
                    ></question-many>
                    <question-write
                        v-if="question.type == 'write'"
                        :question="question"
                        :questionsintest="questions.length"
                        :completed="completed"
                        :index="++index"
                        :answers="answer_list"
                        v-on:answer="handlerAnswers"
                    ></question-write>
                </div>
            </div>
        </div>
        <!-- <div class="col-12" v-if="!loading && completed">
            <div v-for="(item, index) in answer_list" :key="index + 'o'">
                {{ ++index }}. {{ item.answer ? "верно" : "неверно" }}
            </div>
        </div> -->
        <div v-if="!loading && !completed" class="test-button__blok">
            <button type="submit" style="color: white" class="test-button">
                Сдать тест
            </button>
        </div>
    </form>
</template>
<script>
import Timer from "./Timer";
import QuestionOne from "./QuestionOneProd.vue";
import QuestionMany from "./QuestionManyProd.vue";
import QuestionWrite from "./QuestionWriteProd.vue";

export default {
    props: ["test", "questionscount", "section"],

    created() {
        //this.getQuestions();
        this.startTest();
    },

    data() {
        return {
            attempt: {},
            loading: false,
            completed: false,
            questions: [],
            answer_list: [],
            test_good: false,
            test_bad: false,
            correct_answers: "",
            // timer
            hours: 0,
            minutes: 30,
            seconds: 0,
            // результаты
            result: null,
            // attempt count < 3
            available: true
        };
    },

    computed: {
        completedAndRequired: function() {
            if (!this.completed) {
                return true;
            }

            return this.test.is_required != 1;
        }
    },

    methods: {
        startTest() {
            this.questions = [];
            this.getQuestions();
            this.setTimeInMinutes();
            this.test_good = false;
            this.test_bad = false;
            this.completed = false;
            // this.loading = true;
            // this.completed = false;
            // this.test_good = false;
            // this.test_bad = false;
            // this.answer_list = [];
            // axios
            //     .post(`/start-test/${this.test.id}`)
            //     .then(resp => {
            //         this.attempt = resp.data;
            //         /*const finished_at = new Date(this.attempt.finished_at);
            //         const now = new Date();
            //         let diff = finished_at - new Date();
            //         if (diff < 0) {
            //             let timezone = now.getTimezoneOffset();
            //             if (timezone < 0) {
            //                 timezone *= -1;
            //             }
            //             diff = diff + timezone * 60000;
            //         }
            //         this.setTime(diff);*/
            //         this.setTimeInMinutes();
            //         this.loading = false;
            //     })
            //     .catch(error => {
            //         console.log(error);
            //         this.loading = false;
            //     });
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
        setTime(timeInMiliseconds) {
            const hours = Math.floor(timeInMiliseconds / 1000 / 60 / 60);

            const minutes = Math.floor(
                (timeInMiliseconds / 1000 / 60 / 60 - hours) * 60
            );
            const seconds = Math.floor(
                ((timeInMiliseconds / 1000 / 60 / 60 - hours) * 60 - minutes) *
                    60
            );

            if (!isNaN(hours) && hours >= 0) {
                this.hours = hours;
            }

            if (!isNaN(minutes) && minutes >= 0) {
                this.minutes = minutes;
            }

            if (!isNaN(seconds) && seconds >= 0) {
                this.seconds = seconds;
            }
        },
        handlerAnswers(data) {
            const index = this.answer_list
                .map(item => item.question_index)
                .indexOf(data.question_index);

            if (index === -1) {
                return this.answer_list.push(data);
            }

            return (this.answer_list[index] = data);
        },
        getQuestions() {
            this.loading = true;
            axios
                .get(`/test/${this.test.id}/json`)
                .then(res => {
                    let questions = res.data.data.questions.data;

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
        submit() {
            this.loading = true;
            this.completed = true;
            const neededCorrect = this.test.min_correct;
            let actualCorrect = 0;

            this.answer_list.forEach(item => {
                if (item.answer) {
                    actualCorrect++;
                }
            });

            let isGood = false;

            if (neededCorrect <= actualCorrect) {
                isGood = true; //this.test_good = true;
            } else {
                isGood = false; //this.test_bad = true;
            }

            axios
                .post("/complete", {
                    test_id: this.test.id,
                    correct: actualCorrect,
                    questions: this.questions.length,
                    is_passed: isGood
                })
                .then(res => {
                    this.available = res.data.available;
                    this.correct_answers = actualCorrect;
                    if (isGood) {
                        this.test_good = true;
                    } else {
                        this.test_bad = true;
                    }
                    this.loading = false;
                })
                .catch(err => {
                    console.log(err);
                });
        }
    },
    components: {
        Timer,
        QuestionOne,
        QuestionMany,
        QuestionWrite
    }
};
</script>
