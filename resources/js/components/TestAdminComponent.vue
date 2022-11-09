<template>
    <div>
        <div
            class="modal fade"
            id="questionModal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="questionModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">
                            {{ modalTitle }}
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                            @click="dismissModal"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form v-on:submit.prevent="saveQuestion">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="content">Вопрос</label>
                                <input
                                    class="form-control"
                                    type="text"
                                    placeholder="Введите вопрос"
                                    id="content"
                                    v-model="content"
                                    required
                                />
                            </div>
                            <div
                                v-if="indexForEdit === null"
                                class="form-group"
                            >
                                <label for="exampleFormControlSelect1"
                                >Тип</label
                                >
                                <select
                                    class="form-control"
                                    id="exampleFormControlSelect1"
                                    v-model="type"
                                >
                                    <option value="one"
                                    >Один верный ответ
                                    </option
                                    >
                                    <option value="many"
                                    >Много верных ответов
                                    </option
                                    >
                                    <option value="write"
                                    >Верный ответ вписывается
                                    </option
                                    >
                                </select>
                            </div>
                            <button
                                @click="addAnswer"
                                type="button"
                                class="btn btn-secondary"
                                v-if="type != 'write'"
                            >
                                Добавить ответ
                            </button>
                            <button
                                @click="removeAnswer"
                                type="button"
                                class="btn btn-danger"
                                v-if="type != 'write'"
                            >
                                Удалить ответ
                            </button>
                            <div
                                class="form-group mt-3"
                                v-for="(answer, key) in answers"
                                :key="key"
                            >
                                <input
                                    class="form-control"
                                    type="text"
                                    placeholder="Введите ответ"
                                    v-model="answers[key].text"
                                    required
                                />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal"
                                @click="dismissModal"
                            >
                                Закрыть
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Сохранить
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <template v-if="!loading">
            <form v-on:submit.prevent="save">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="title">Название</label>
                            <input
                                class="form-control"
                                placeholder="Введите название теста"
                                id="title"
                                min="1"
                                v-model="title"
                                required
                            />
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="exampleFormControlSelect2">Тип</label>
                            <select
                                class="form-control"
                                id="exampleFormControlSelect2"
                                v-model="section_id"
                            >
                                <option :value="1">Теория</option>
                                <option :value="2"
                                >Дополнительные материалы
                                </option
                                >
                                <option :value="3">Практика</option>
                                <option :value="4">Домашнее задание</option>
                                <option :value="5">Контроль</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="exampleFormControlSelect4"
                            >Обязателен для завершения темы</label
                            >
                            <select
                                class="form-control"
                                id="exampleFormControlSelect4"
                                v-model="is_required"
                            >
                                <option :value="0">Нет</option>
                                <option :value="1">Да</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="order">Номер теста в секции</label>
                            <input
                                class="form-control"
                                type="number"
                                placeholder="Введите число"
                                id="order"
                                min="1"
                                required
                                v-model="order"
                            />
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="minutes">Продолжительность</label>
                            <input
                                class="form-control"
                                type="number"
                                placeholder="Введите число"
                                id="minutes"
                                min="1"
                                required
                                v-model="minutes"
                            />
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="form-group">
                            <label for="min_correct"
                            >Кол-во верных ответов для успешной сдачи
                                теста</label
                            >
                            <input
                                class="form-control"
                                type="number"
                                placeholder="Введите число"
                                id="min_correct"
                                min="1"
                                required
                                v-model="min_correct"
                                v-bind:class="{
                                    'is-invalid': error
                                }"
                            />
                            <span class="error invalid-feedback">{{
                                    error
                                }}</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-outline-primary">
                            Сохранить
                        </button>
                        <button
                            type="button"
                            class="btn btn-outline-info"
                            @click="openCreateModal"
                        >
                            Добавить вопрос
                        </button>
                    </div>
                </div>
            </form>
            <div class="row  mt-3">
                <div class="col-12">
                    <h4>Вопросы</h4>
                </div>
                <div
                    class="col-12"
                    v-for="(question, index) in questions"
                    :key="index"
                >
                    <question-one
                        v-if="question.type == 'one'"
                        :question="question"
                        :index="++index"
                        :admin="true"
                        v-on:answer="handlerAnswers"
                    ></question-one>
                    <question-many
                        v-if="question.type == 'many'"
                        :question="question"
                        :index="++index"
                        :admin="true"
                        v-on:answer="handlerAnswers"
                    ></question-many>
                    <question-write
                        v-if="question.type == 'write'"
                        :question="question"
                        :index="++index"
                        :admin="true"
                        v-on:answer="handlerAnswers"
                    ></question-write>
                    <div
                        style="display:flex;flex-direction:column"
                        class="mb-1"
                    >
                        <label :for="'comment' + index"
                        >Комментарий при неверном ответе</label
                        >
                        <input
                            :id="'comment' + index"
                            v-model="question.comment"
                            type="text"
                        />
                    </div>

<!--                    <input :id="'fileUpload' + index" @change="uploadFile(index)" style="height: 46px;" type="file"-->
<!--                           class="form-control document_attachment_doc">-->

                    <div class="row">
                        <img
                            v-if="question.img_url"
                            class="m-2"
                            :src="question.img_url"
                            style="max-width:300px"
                            alt="test-img"
                        />

                    </div>

                    <div style="color:red">{{ question.file_error }}</div>
<!--                    <input-->
<!--                        @change="uploadFile(index)"-->
<!--                        :id="'fileUpload' + index"-->
<!--                        type="file"-->
<!--                        class="document_attachment_doc"-->
<!--                    />-->
                    <input
                        @change="uploadFile(index)"
                        :id="'fileUpload' + index"
                        type="file"
                        class="document_attachment_doc"
                    />
                    <img class="preview" id="preview" src=""/>
                    <button
                        v-if="!question.img_url"
                        type="button"
                        class="btn btn-outline-primary"
                    >
                        Добавить изображение
                    </button>

                    <button
                        v-if="question.img_url"
                        @click="removeImage(index)"
                        type="button"
                        class="btn btn-outline-warning"
                    >
                        Удалить изображение
                    </button>
                    <button
                        @click="openEditModal(index)"
                        type="button"
                        class="btn btn-outline-info"
                    >
                        Редактировать вопрос
                    </button>
                    <button
                        @click="removeQuestion(index)"
                        type="button"
                        class="btn btn-outline-danger"
                    >
                        Удалить вопрос
                    </button>
                </div>
            </div>
        </template>

        <div v-if="loading" class="row">
            <div class="col-md-12" style="display:flex;justify-content:center">
                <h4>Загрузка...</h4>
            </div>
        </div>
    </div>
</template>

<script>
import QuestionOne from "./QuestionOne.vue";
import QuestionMany from "./QuestionMany.vue";
import QuestionWrite from "./QuestionWrite.vue";

export default {
    props: ["theme", "test"],
    components: {
        QuestionOne,
        QuestionMany,
        QuestionWrite
    },
    created() {
        if (this.test) {
            this.minutes = this.test.minutes;
            this.min_correct = this.test.min_correct;
            this.section_id = this.test.section_id;
            this.title = this.test.title;
            this.order = this.test.order;
            this.is_required = this.test.is_required;
            this.getQuestions();
        }
    },
    data: function () {
        return {
            loading: false,
            minutes: 30,
            min_correct: 1,
            questions: [],
            modalTitle: "",
            content: "",
            type: "one",
            answers: [],
            correct: [],
            answer_list: [],
            section_id: 1,
            title: "",
            order: "",
            is_required: 0,
            indexForEdit: null,
            editInProcess: false,
            // error
            error: ""
        };
    },
    watch: {
        type: {
            handler: function (newVal, oldVal) {
                if (this.indexForEdit !== null && !this.editInProcess) {
                    return;
                }

                if (newVal == "write") {
                    this.answers = [];
                } else {
                    this.answers = [{text: ""}, {text: ""}];
                }

                if (newVal == "many") {
                    this.correct = [{result: []}];
                }

                if (newVal == "one") {
                    this.correct = [{result: -1}];
                }

                if (newVal == "write") {
                    this.correct = [{result: ""}];
                }
            }
        },
        questions: {
            handler: function (newVal, oldVal) {
            },
            deep: true
        },
        answers: {
            handler: function (newVal, oldVal) {
            },
            deep: true
        },
        correct: {
            handler: function (newVal, oldVal) {
            },
            deep: true
        },
        answer_list: {
            handler: function (newVal, oldVal) {
            },
            deep: true
        }
    },
    methods: {
        dismissModal() {
            this.indexForEdit = null;
            this.editInProcess = false;
        },
        // chooseFiles(index) {
        //     document.getElementById("fileUpload" + index).value = "";
        //     document.getElementById("fileUpload" + index).click();
        // },
        uploadFile(index) {
            const questionIndex = --index;
            this.questions[questionIndex].file_loading = true;
            //this.btnFileLoading = "Загрузка...";
            let selectedFile = event.target.files[0];
            let formData = new FormData();
            formData.append("image", selectedFile, selectedFile.name);

            axios
                .post("/admin/temp/image", formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(response => {
                    this.questions[questionIndex].img_url = response.data;
                    //this.img_url = response.data.img_url;
                    //this.file_loading = false;
                    //this.btnFileLoading = "Загрузить фото";
                })
                .catch(error => {
                    //const errors = error.response.data.errors;
                    this.questions[questionIndex].file_error =
                        error.response.data.errors.image[0];
                    //this.file_loading = false;
                });
        },
        removeImage(index) {
            const currentImageUrl = this.questions[--index].img_url;
            this.questions[index].img_url = "";

            axios
                .post("/admin/temp/image/delete", {
                    img_url: currentImageUrl
                })
                .then(response => {
                })
                .catch(error => {
                });
        },
        getQuestions() {
            this.loading = true;
            axios
                .get(`/admin/test/${this.test.id}`)
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
        handlerAnswers(data) {
            const index = this.answer_list
                .map(item => item.question_index)
                .indexOf(data.question_index);

            if (index === -1) {
                return this.answer_list.push(data);
            }

            return (this.answer_list[index] = data);
        },
        removeQuestion(index) {
            this.removeImage(index);
            this.questions.splice(--index, 1);
        },
        saveQuestion() {
            if (this.indexForEdit === null) {
                this.questions.push({
                    content: this.content,
                    answers: this.answers,
                    correct: JSON.stringify(this.correct),
                    type: this.type,
                    comment: "",
                    img_url: "",
                    file_loading: false,
                    file_error: ""
                });
            } else {
                const questionIndex = this.indexForEdit;

                this.questions[questionIndex].content = this.content;
                this.questions[questionIndex].type = this.type;
                this.questions[questionIndex].answers = this.answers;

                // } else {
                //     const comment = this.questions[questionIndex].comment;
                //     const img_url = this.questions[questionIndex].img_url;

                //     this.questions.splice(questionIndex, 1);

                //     this.questions.push({
                //         content: this.content,
                //         answers: this.answers,
                //         correct: JSON.stringify([{ result: [] }]),
                //         type: this.type,
                //         comment: "",
                //         img_url: "",
                //         file_loading: false,
                //         file_error: ""
                //     });
                // }

                this.editInProcess = false;
            }
            this.indexForEdit = null;
            $("#questionModal").modal("hide");
        },
        addAnswer() {
            if (this.answers.length < 16) {
                this.answers.push({text: ""});
            }
        },
        removeAnswer() {
            if (this.answers.length > 2) {
                this.answers.pop();
            }
        },
        openCreateModal() {
            $("#questionModal").modal("show");
            this.modalTitle = "Cоздание вопроса";
            this.content = "";
            this.type = "one";
            this.answers = [{text: ""}, {text: ""}];
            this.correct = [{result: -1}];
        },
        openEditModal(index) {
            const questionIndex = --index;
            this.indexForEdit = questionIndex;
            this.modalTitle = "Редактирование вопроса";
            this.content = this.questions[questionIndex].content;
            this.type = this.questions[questionIndex].type;
            this.answers = this.questions[questionIndex].answers;

            $("#questionModal").modal("show");
            setTimeout(() => {
                this.editInProcess = true;
            }, 0);
        },
        save() {
            this.error = "";

            if (this.questions.length < this.min_correct) {
                return (this.error =
                    "Количество требуемых ответов не может быть больше количества вопросов");
            }

            this.loading = true;

            const formattedQuestions = JSON.parse(
                JSON.stringify(this.questions)
            );

            formattedQuestions.forEach((question, index) => {
                question.correct = [{result: this.answer_list[index].answer}];
            });

            if (this.test) {
                axios
                    .patch(`/admin/test/${this.test.id}`, {
                        title: this.title,
                        order: this.order,
                        minutes: this.minutes,
                        min_correct: this.min_correct,
                        theme_id: this.theme.id,
                        questions: formattedQuestions,
                        section_id: this.section_id,
                        is_required: this.is_required
                    })
                    .then(res => {
                        window.location.href = `/admin/theme/${this.theme.id}/tests`;
                    })
                    .catch(err => {
                        this.loading = false;
                    });
            } else {
                axios
                    .post("/admin/test", {
                        title: this.title,
                        order: this.order,
                        minutes: this.minutes,
                        min_correct: this.min_correct,
                        theme_id: this.theme.id,
                        questions: formattedQuestions,
                        section_id: this.section_id,
                        is_required: this.is_required
                    })
                    .then(res => {
                        window.location.href = `/admin/theme/${this.theme.id}/tests`;
                    })
                    .catch(err => {
                        this.loading = false;
                    });
            }
        }
    }
};
</script>
