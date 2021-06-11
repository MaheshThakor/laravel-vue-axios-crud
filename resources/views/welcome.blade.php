<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.2/css/bulma-rtl.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Laravel</title>
</head>
<body class="has-background-dark" style="min-height: 49.8vw;">

<div id="app" class="container pt-5">

    <form action="" method="post" @submit.prevent="storeProject" @keydown="form.errors.clear($event.target.name)">
        @csrf

        <div class="control">
            <input type="hidden" v-model="form.projectId">
            <label for="project" class="has-text-light">Project Name</label>
            <input type="text" name="project" class="input mb-2 mt-1 column is-half" v-model="form.project" placeholder="Project Name">
            <span v-if="form.errors.has('project')" v-text="form.errors.get('project')" class="help is-danger"></span>
        </div>

        <div>
            <label for="description" class="has-text-light">Project Description</label>
            <textarea name="description" class="textarea mb-2 mt-1 column is-full" v-model="form.description" placeholder="Project Description"></textarea>
            <span v-if="form.errors.has('description')" v-text="form.errors.get('description')" class="help is-danger"></span>
        </div>

        <input type="submit" class="button is-primary mt-3" value="submit" name="submitButton" :disabled="form.errors.any()">
        <a href="#" class="button is-info mt-3" @click.prevent="updateProject()" v-if="form.projectId">Update</a>
        <a href="#" class="button is-danger mt-3" @click.prevent="form.reset()">Clear All</a>

    </form>
    @include('projects.list')
</div>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://vuejs.org/js/vue.js"></script>
<script>
    class Errors {
        constructor() {
            this.errors = {};
        }

        has(field) {
            return this.errors.hasOwnProperty(field);
        }

        any() {
            return Object.keys(this.errors).length > 0;
        }

        get(field) {
            if (this.errors[field]) {
                return this.errors[field][0];
            }
        }

        record(error) {
            this.errors = error;
        }

        clear(field) {
            if (field) {
                delete this.errors[field];
                return;
            }
            this.errors = {};
        }
    }

    class Form {
        constructor(data) {
            this.projects = {};
            this.originalData = data;
            for (let field in data) {
                this[field] = data[field];
            }
            this.errors = new Errors();
        }

        data() {
            let data = {};
            for(let property in this.originalData){
                data[property] = this[property];
            }
            return data;
        }

        reset() {
            for (let field in this.originalData) {
                this[field] = '';
            }
            this.errors.clear();

        }

        forEdit(id, name, details) {
             this.projectId = id;
             this.project = name;
             this.description = details;
        }

        get(url){
            return this.submit('get',url)
        }

        post(url){
            return this.submit('post',url)
        }

        patch(url){
            return this.submit('patch',url)
        }

        put(url){
            return this.submit('put',url)
        }

        delete(url){
            return this.submit('delete',url)
        }

        submit(requestType, url) {

            return new Promise((resolve, reject) => {

                axios[requestType](url, this.data())
                    .then(response => {
                        this.onSuccess(response.data);
                        resolve(response.data);
                    })
                    .catch(error => {
                        this.onFail(error.response.data.errors);
                        reject(error.response.data.errors);
                    });

            });
        }

        onSuccess(data) {
            this.projects = data;
            this.reset();
        }

        onFail(errors) {
            this.errors.record(errors);
        }
    }

    new Vue({
        el: '#app',
        data: {
            form: new Form({
                projectId: '',
                project: '',
                description: '',
            })
        },
        mounted() {
            this.form.post('/get-projects');
        },
        methods: {
            storeProject() {
                this.form.post('/create-projects')
                    .then(data => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Project has been saved',
                            showConfirmButton: false,
                            timer: 1000
                        })
                    })
                    .catch(errors => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Something Went Wrong',
                            text: errors,
                            showConfirmButton: false,
                            timer: 1000
                        })
                    });
            },
            updateProject() {
                this.form.submit('post', '/store-projects')
                    .then(data => console.log(data))
                    .catch(errors => console.log(errors));

            },
            deleteProject(id) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: true
                })

                swalWithBootstrapButtons.fire({
                    title: 'Delete Record?',
                    text: "Are You Sure To Delete Record ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.form.submit('get', '/destroy-projects/'+ id)
                            .then(data => console.log(data))
                            .catch(errors => console.log(errors));

                        swalWithBootstrapButtons.fire({
                                icon: 'success',
                                title: 'Record Is Deleted',
                                showConfirmButton: false,
                                timer: 1000
                        })
                    } else if (
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire({
                                icon: 'error',
                                title: 'Record Is Safe',
                                showConfirmButton: false,
                                timer: 1000
                        }
                        )
                    }
                })
            },
        }
    });
</script>
</body>
</html>
