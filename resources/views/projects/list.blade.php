<ul class="has-background-dark has-text-light column is-two-fifths mt-2">
    <li v-if="!form.projects.length" class="has-background-danger-dark column is-full">No Projects Available</li>
    <li v-show="form.projects.length" v-for="project in form.projects" class="column is-full">
        <div class="column is-full">
            <h1 v-text="project.project"
                class="has-background-success column is-two-thirds display is-inline-block"></h1>
            <button class="button is-info fas fa-bars display is-inline-block"
                    @click.prevent="form.forEdit(project.id,project.project,project.description)">Edit
            </button>
            <a href="#" class="button is-danger fas fa-bars display is-inline-block"
               @click.prevent="deleteProject(project.id)">Delete</a>
            <p v-text="project.description" class="has-background-success-dark column is-full"></p>
        </div>
    </li>
</ul>
