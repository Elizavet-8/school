<template>
    <form v-on:submit.prevent="save">
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
        "roles"
    ],
    mounted() {
        this.start = moment(this.date).format("YYYY-MM-DD");
        this.course_id = this.courses[0].id;
    },
    data() {
        return {
            start: new Date(),
            course_id: null,
            is_admin: false,
            start_time: "00:00",
            end_time: "00:00",
        }
    },
    methods: {
        save() {
            const startDateObj = this.parseTime(this.start_time);
            const endDateObj = this.parseTime(this.end_time);

            axios
                .post("/admin/api/lessons", {
                    course_id: this.course_id,
                    started_at: new Date(startDateObj),
                    ended_at: new Date(endDateObj),
                })
                .then((res) => {
                    console.log(res);
                })
                .catch((err) => {
                    //this.loading = false;
                    console.log(err);
                });
        },
        parseTime(time) {
            const arrayOfStrings = time.split(":");
            const hours = parseInt(arrayOfStrings[0]);
            const minutes = parseInt(arrayOfStrings[1]);
            let newDateObj = moment(this.start).add(minutes, "m").toDate();
            newDateObj = moment(this.start).add(hours, "h").toDate();
            return newDateObj;
        }
    }
}
</script>