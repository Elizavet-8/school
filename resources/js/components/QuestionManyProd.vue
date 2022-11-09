<template>
    <div class="test-block">
        <div class="test-number number">
            {{ index }} <b>/ {{ questionsintest }}</b>
        </div>

        <div class="test-main test-signs-of-paralysis-paresis">
            <p class="test-caption">
                {{ question.content }}
                <span>
                    Выберите несколько вариантов
                </span>
            </p>
            <img
                v-if="question.img_url"
                class="mb-3"
                :src="question.img_url"
                alt="test-img"
                style="max-width:100%"
            />
            <div class="test-compliance">
                <div class="compliance-block" style="margin-left:0">
                    <div class="radio test-radio">
                        <div>
                            <div
                                class="answer-item"
                                v-for="(answer, key) in question.answers"
                                :key="key"
                            >
                                <input
                                    :id="key + '-checkbox-' + index"
                                    type="checkbox"
                                    :name="key + '-checkbox-' + index"
                                    :value="answer.text"
                                    v-model="checked"
                                    :disabled="completed"
                                />
                                <label
                                    :for="key + '-checkbox-' + index"
                                    v-bind:class="{
                                        correct: check(answer.text) == 1,
                                        incorrect: check(answer.text) == 0
                                    }"
                                >
                                    {{ answer.text }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div
                style="color:red"
                v-if="completed && isCorrect == false && question.comment"
            >
                {{ question.comment }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["question", "index", "questionsintest", "completed", "answers"],
    created() {
        if (this.completed) {
            this.checked = this.currentQuestionAnswer.actual;
        }
        const correct = JSON.parse(this.question.correct);
        this.correct = correct[0].result;

        this.$emit("answer", {
            answer: this.equalsIgnoreOrder(this.checked, this.correct),
            actual: this.checked,
            question_index: this.question.id
        });
    },
    data: function() {
        return {
            correct: [],
            checked: []
        };
    },
    watch: {
        checked: {
            handler: function(newVal, oldVal) {
                this.$emit("answer", {
                    answer: this.equalsIgnoreOrder(this.checked, this.correct),
                    actual: this.checked,
                    question_index: this.question.id
                });
            },
            deep: true
        }
    },
    methods: {
        isCorrect() {
            return this.equalsIgnoreOrder(this.checked, this.correct);
        },
        equalsIgnoreOrder(a, b) {
            if (!a || !b) {
                return false;
            }
            if (a.length !== b.length) return false;
            const uniqueValues = new Set([...a, ...b]);
            for (const v of uniqueValues) {
                const aCount = a.filter(e => e === v).length;
                const bCount = b.filter(e => e === v).length;
                if (aCount !== bCount) return false;
            }
            return true;
        },
        check(answer) {
            if (!this.completed) {
                return null;
            }

            if (
                this.checked.includes(answer) &&
                this.correct.includes(answer)
            ) {
                return 1;
            }

            if (
                this.checked.includes(answer) &&
                !this.correct.includes(answer)
            ) {
                return 0;
            }

            if (
                !this.checked.includes(answer) &&
                !this.correct.includes(answer)
            ) {
                return 1;
            }

            return 0;
        }
    },
    computed: {
        currentQuestionAnswer() {
            if (!this.completed) {
                return null;
            }

            return this.answers.find(x => x.question_index == this.question.id);
        }
    }
};
</script>
