<template>
    <div>
        <div>{{ index }}. {{ question.content }}</div>
        <div
            class="form-check"
            v-for="(answer, index) in question.answers"
            :key="index"
        >
            <input
                class="form-check-input"
                type="checkbox"
                :id="index"
                :value="answer.text"
                v-model="checked"
            />
            <label class="form-check-label">
                {{ answer.text }}
            </label>
        </div>
    </div>
</template>

<script>
export default {
    props: ["question", "index", "admin"],
    created() {
        let correct;

        correct = JSON.parse(this.question.correct);

        if (this.admin) {
            this.checked = correct[0].result;
        }
        this.correct = correct[0].result;

        if (!this.admin) {
            this.$emit("answer", {
                answer: this.equalsIgnoreOrder(this.checked, this.correct),
                question_index: this.question.id
            });
        } else {
            this.$emit("answer", {
                answer: this.checked,
                question_index: this.index
            });
        }
    },
    data: function() {
        return {
            checked: [],
            correct: []
        };
    },
    watch: {
        checked: {
            handler: function(newVal, oldVal) {
                if (!this.admin) {
                    this.$emit("answer", {
                        answer: this.equalsIgnoreOrder(
                            this.checked,
                            this.correct
                        ),
                        question_index: this.question.id
                    });
                } else {
                    this.$emit("answer", {
                        answer: this.checked,
                        question_index: this.index
                    });
                }
            },
            deep: true
        },
        question: {
            handler: function(newVal, oldVal) {
                this.checked = [];
                this.correct = [];
            },
            deep: true
        }
    },
    methods: {
        equalsIgnoreOrder(a, b) {
            if (a.length !== b.length) return false;
            const uniqueValues = new Set([...a, ...b]);
            for (const v of uniqueValues) {
                const aCount = a.filter(e => e === v).length;
                const bCount = b.filter(e => e === v).length;
                if (aCount !== bCount) return false;
            }
            return true;
        }
    }
};
</script>
