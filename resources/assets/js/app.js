import Vue from 'vue';
import axios from "axios";
import Form from "./core/Form";
import Example from './components/Example';

const Swal = window.swal = require('sweetalert2');

window.axios = axios;
window.Form = Form;

new Vue({
    el: '#app',
    components: {
        Example
    },
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
            this.form.post('/store-projects')
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Project has been Updated',
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
                    this.form.submit('get', '/destroy-projects/' + id)
                        .then(data => {

                        })
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
