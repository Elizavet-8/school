<template>
    <section class="content">
        <div class="filters" style="display:flex;align-items:end;">
            <div class="form-group mr-2">
                <label>ФИО</label>
                <input
                    v-model="name"
                    name="name"
                    type="text"
                    class="form-control"
                />
            </div>

            <div class="form-group mr-2">
                <label for="inputStatus2">Учебное заведение</label>
                <select
                    v-model="school_id"
                    id="inputStatus2"
                    class="form-control custom-select"
                >
                    <option value="" selected>не указано</option>
                    <option
                        :key="'school' + school.id"
                        v-for="school in schools"
                        :value="school.id"
                        selected
                        >{{ school.title }}</option
                    >
                </select>
            </div>

            <div class="form-group mr-2">
                <label for="inputStatus2">Класс</label>
                <select
                    v-model="grade"
                    id="inputStatus2"
                    class="form-control custom-select"
                >
                    <option value="" selected>не указано</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                </select>
            </div>

            <div class="form-group">
                <button
                    type="button"
                    class="btn btn-success float-right mt-2"
                    @click="getData"
                >
                    Применить
                </button>
            </div>
        </div>

        <!-- Default box -->
        <div class="card" v-if="!loading">
            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th>
                                #
                            </th>
                            <th>
                                ФИО
                            </th>
                            <th>
                                Учебное заведение
                            </th>
                            <th>
                                Класс
                            </th>
                            <th>
                                Роли
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr :key="user.id" v-for="(user, index) in users">
                            <td>
                                {{ ++index }}
                            </td>
                            <td style="max-width: 300px">
                                {{ user.name }}
                            </td>
                            <td style="max-width: 300px">
                                {{
                                    user.school
                                        ? user.school.title
                                        : "не указано"
                                }}
                            </td>
                            <td>
                                {{ user.grade ? user.grade : "не указано" }}
                            </td>
                            <td>
                                <div
                                    :key="'role' + key"
                                    v-for="(role, key) in user.roles"
                                >
                                    {{ role.name }}
                                </div>
                            </td>
                            <td class="project-actions text-right">
                                <a
                                    class="btn btn-info btn-sm"
                                    :href="`/admin/user/${user.id}/courses`"
                                >
                                    <i class="fas fa-book-open"></i> Курсы
                                </a>
                                <button
                                    type="button"
                                    class="btn btn-info btn-sm"
                                    data-toggle="modal"
                                    data-target="#modal-user"
                                    @click="selectUser(user)"
                                >
                                    <i class="fas fa-eye"> </i>
                                </button>
                                <a
                                    class="btn btn-primary btn-sm"
                                    :href="`/admin/user/${user.id}/edit`"
                                >
                                    <i class="fas fa-pencil-alt"> </i>
                                </a>

                                <button
                                    type="button"
                                    class="btn btn-danger btn-sm delete-btn"
                                    data-toggle="modal"
                                    data-target="#modal-user-delete"
                                    @click="selectUser(user)"
                                >
                                    <i class="fas fa-trash"> </i>
                                </button>
                            </td>
                        </tr>

                        <!-- modal -->
                        <div class="modal fade" id="modal-user">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">
                                            {{
                                                selectedUser
                                                    ? selectedUser.name
                                                    : "не указано"
                                            }}
                                        </h4>
                                        <button
                                            type="button"
                                            class="close"
                                            data-dismiss="modal"
                                            aria-label="Close"
                                        >
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>
                                            <strong>ФИО: </strong
                                            >{{
                                                selectedUser
                                                    ? selectedUser.name
                                                    : "не указано"
                                            }}
                                        </p>
                                        <p>
                                            <strong>e-mail: </strong
                                            >{{
                                                selectedUser
                                                    ? selectedUser.email
                                                    : "не указано"
                                            }}
                                        </p>
                                        <p>
                                            <strong>Дата рождения: </strong
                                            >{{
                                                selectedUser
                                                    ? selectedUser.birth
                                                    : "не указано"
                                            }}
                                        </p>
                                        <p>
                                            <strong>Пол: </strong>
                                            {{
                                                selectedUser
                                                    ? selectedUser.sex
                                                    : "не указано"
                                            }}
                                        </p>
                                        <p>
                                            <strong>Город: </strong
                                            >{{
                                                selectedUser
                                                    ? selectedUser.city
                                                    : "не указано"
                                            }}
                                        </p>
                                        <p>
                                            <strong>Место учебы: </strong
                                            >{{
                                                selectedUser &&
                                                selectedUser.school
                                                    ? selectedUser.school.title
                                                    : "не указано"
                                            }}
                                        </p>
                                        <p>
                                            <strong>Класс: </strong
                                            >{{
                                                selectedUser
                                                    ? selectedUser.grade
                                                    : "не указано"
                                            }}
                                        </p>
                                    </div>
                                    <div
                                        class="modal-footer justify-content-center"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-default"
                                            data-dismiss="modal"
                                        >
                                            Закрыть
                                        </button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>

                        <div class="modal fade" id="modal-user-delete">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">
                                            {{
                                                selectedUser
                                                    ? selectedUser.name
                                                    : "не указано"
                                            }}
                                        </h4>
                                        <button
                                            type="button"
                                            class="close"
                                            data-dismiss="modal"
                                            aria-label="Close"
                                        >
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>
                                            Вы уверены, что хотите удалить
                                            пользователя
                                            {{
                                                selectedUser
                                                    ? " " + selectedUser.name
                                                    : " не указано"
                                            }}?
                                        </p>
                                    </div>
                                    <div
                                        class="modal-footer justify-content-center"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-default"
                                            data-dismiss="modal"
                                        >
                                            Закрыть
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-danger"
                                            data-dismiss="modal"
                                            @click="deleteUser"
                                        >
                                            Удалить
                                        </button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- loading -->
        <div v-if="loading" class="row">
            <div class="col-md-12" style="display:flex;justify-content:center">
                <h4>Загрузка...</h4>
            </div>
        </div>

        <div class="w100 d-flex justify-content-center">
            <pagination
                :limit="3"
                :data="laravelData"
                @pagination-change-page="getData"
            ></pagination>
        </div>
    </section>
</template>

<script>
export default {
    created() {
        this.getSchools();
        this.getData();
    },
    data() {
        return {
            loading: false,
            // filters
            schools: [],
            name: "",
            school_id: "",
            grade: "",
            // pagination
            laravelData: {},
            // table
            users: [],
            // modal
            selectedUser: null
        };
    },
    methods: {
        getSchools() {
            axios
                .get("/admin/api/schools")
                .then(resp => {
                    console.log(resp);
                    this.schools = resp.data;
                })
                .catch(function(resp) {
                    console.log(resp);
                });
        },
        getData(page = 1) {
            this.loading = true;
            axios
                .get("/admin/api/users?page=" + page, {
                    params: {
                        name: this.name,
                        school_id: this.school_id,
                        grade: this.grade
                    }
                })
                .then(resp => {
                    console.log(resp);
                    this.loading = false;
                    this.users = resp.data.data;
                    this.laravelData = resp.data;
                })
                .catch(function(resp) {
                    this.loading = false;
                    console.log(resp);
                });
        },
        selectUser(user) {
            this.selectedUser = user;
        },
        deleteUser() {
            const removeIndex = this.users
                .map(item => item.id)
                .indexOf(this.selectedUser.id);
            this.users.splice(removeIndex, 1);
            axios
                .delete(`/admin/api/users/${this.selectedUser.id}`)
                .then(resp => {
                    console.log(resp);
                    $("#accept-remove").modal("hide");
                })
                .catch(err => {
                    console.log(err);
                    $("#accept-remove").modal("hide");
                });
        }
    }
};
</script>
