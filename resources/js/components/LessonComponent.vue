<template>
    <form v-on:submit.prevent="save">
        <div v-if="(errors.length > 0)" class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <ul>
                <li
                    v-for="error in errors"
                    :key="error" 
                    class="ml-2"             
                >{{ error }}</li>
            </ul>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <a href="/" class="btn btn-secondary">Назад</a>
                <input type="submit" value="Сохранить" class="btn btn-success float-right">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Обязательные параметры</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Курс</label>
                            <select
                                class="form-control custom-select"
                                v-model="course_id"
                            >
                                <option
                                    v-for="course in courses"
                                    :key="course.id"
                                    :value="course.id"
                                >
                                    {{ course.title }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Дата</label>
                            <input
                                v-model="start"
                                name="start"
                                type="date"
                                class="form-control"
                            />
                        </div>
                        <div class="form-group">
                            <label>Время начала</label>
                            <input
                                v-model="start_time"
                                name="start_time"
                                type="time"
                                class="form-control"
                            />
                        </div>
                        <div class="form-group">
                            <label>Время окончания</label>
                            <input
                                v-model="end_time"
                                name="end_time"
                                type="time"
                                class="form-control"
                            />
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>

            <div class="col-md-6">
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Опциональные параметры</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Модуль</label>
                                <select
                                    class="form-control custom-select"
                                    v-model="chapter_id"
                                >
                                    <option
                                        v-for="chapter in chapters"
                                        :key="chapter.id"
                                        :value="chapter.id"
                                    >
                                        {{ chapter.title }}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Темы</label><br>
                                <div v-for="theme in themes" :key="'theme'+theme.id">
                                    <input
                                        type="checkbox" 
                                        :id="('theme'+theme.title)" 
                                        :value="theme.id" 
                                        v-model="selected_themes">
                                    <label
                                        :for="('theme'+theme.title)">{{ theme.title }}</label>
                                    </div>
                            </div>
                            <div class="form-group">
                                <label>Материалы</label><br>
                                <div class="row mb-1" v-for="(material, key) in materials" :key="'material'+key">
                                    <div class="col-3">
                                        <input v-model="materials[key].title" class="form-control" type="text" placeholder="Название">
                                    </div>
                                    <div class="col-4">
                                        <input v-model="materials[key].url" class="form-control" type="text" placeholder="Ссылка">
                                    </div>
                                    <div class="col-3">
                                        <select
                                            class="form-control custom-select"
                                            v-model="materials[key].theme_id"
                                        >
                                            <option
                                                v-for="selected_theme in selected_themes"
                                                :key="'selectedtheme'+selected_theme"
                                                :value="selected_theme"
                                            >
                                                {{ selected_theme }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <button @click.prevent="removeTemplate(key)" type="button" class="btn btn-danger">☓</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button @click.prevent="addFileTemplate" type="button" class="btn btn-primary">Добавить</button>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
        </div>
    </form>
</template>

<script>
import moment from "moment";

export default {
    name: "LessonComponent",
    props: [
        "date",
        "courses",
        "roles",
        "lesson",
        "oldthemes"
    ],
    mounted() {
        if (this.lesson) {
            this.course_id = this.lesson.course_id;

            const started = new Date(this.lesson.started_at);
            this.start = moment(started).format("YYYY-MM-DD");
            const ended = new Date(this.lesson.ended_at);

            this.start_time = this.makeTime(started);
            this.end_time = this.makeTime(ended);

            /*if (this.oldthemes.length > 0) {
                this.oldthemes.forEach(oldtheme => {
                    this.selected_themes.push(oldtheme.id); 
               });
            }*/
        } else {
            this.course_id = this.courses[0].id;
            this.start = moment(this.date).format("YYYY-MM-DD");
        }
    },
    data() {
        return {
            start: new Date(),
            course_id: null,
            chapters: [],
            chapter_id: null,
            themes: [],
            selected_themes: [],
            is_admin: false,
            start_time: "00:00",
            end_time: "00:00",
            errors: [],
            // materials
            materials: [{
                title: "",
                url: "",
                theme_id: null
            }]
        }
    },
    watch: {
        course_id: function (newCourseId, oldCourseId) {
            this.getChapters(newCourseId);
        },
        chapter_id: function (newChapterId, oldChapterId) {
            this.getThemes(newChapterId);

            if (oldChapterId == null && this.oldthemes.length > 0 && this.oldthemes[0].chapter_id == newChapterId) {
                this.oldthemes.forEach(oldtheme => {
                        this.selected_themes.push(oldtheme.id); 
                });
            } else {
                this.selected_themes = [];
            }
        },
        selected_themes: {
            handler: function() {
            },
            deep: true
        }
    },
    methods: {
        removeTemplate(index) {
            this.materials.splice(index, 1);
        },
        addFileTemplate() {
            this.materials.push(
                {
                    title: "",
                    url: "",
                    theme_id: null
                }
            );
        },
        getChapters(courseId) {
            axios
                .get(`/admin/api/course/${courseId}/chapters`)
                .then((res) => {
                    this.chapters = res.data;
                    if (this.chapters.length > 0) {
                        this.chapter_id = this.chapters[0].id;
                    }
                })
                .catch((err) => {
                    console.log(err);
                });   
        },
        getThemes(chapterId) {
            axios
                .get(`/admin/api/chapter/${chapterId}/themes`)
                .then((res) => {
                    this.themes = res.data;
                })
                .catch((err) => {
                    console.log(err);
                });
        },
        save() {
            const startDateObj = this.parseTime(this.start_time);
            const endDateObj = this.parseTime(this.end_time);
            this.errors = [];

            if (this.lesson) {
                axios
                    .patch(`/admin/api/lessons/${this.lesson.id}`, {
                        course_id: this.course_id,
                        started_at: new Date(startDateObj),
                        ended_at: new Date(endDateObj),
                        themes: this.selected_themes
                    })
                    .then((res) => {
                        console.log(res);
                    })
                    .catch((err) => {
                        const errors = err.response.data.errors;

                        Object.values(errors).forEach(error => {
                            this.errors = [...this.errors, ...error]
                        });
                    });
            } else {
                axios
                    .post("/admin/api/lessons", {
                        course_id: this.course_id,
                        started_at: new Date(startDateObj),
                        ended_at: new Date(endDateObj),
                        themes: this.selected_themes
                    })
                    .then((res) => {
                        console.log(res);
                    })
                    .catch((err) => {
                        const errors = err.response.data.errors;

                        Object.values(errors).forEach(error => {
                            this.errors = [...this.errors, ...error]
                        });
                    });
            }

           
        },
        parseTime(time) {
            const arrayOfStrings = time.split(":");
            const hours = parseInt(arrayOfStrings[0]);
            const minutes = parseInt(arrayOfStrings[1]);
            let newDateObj = moment(this.start)
                .add(minutes, "m")
                .add(hours, "h")
                .toDate();
            return newDateObj;
        },
        makeTime(time) {
            let minutes;
            let hours;

            time.getMinutes() < 10
                ? (minutes = "0" + time.getMinutes())
                : (minutes = "" + time.getMinutes());

            let finalHours = time.getHours() + 3;

            if (finalHours == 24) {
                finalHours = 0;
            }

            finalHours < 10
                ? (hours = "0" + finalHours)
                : (hours = "" + finalHours);

            return "" + hours + ":" + minutes;
        }
    }
}
</script>