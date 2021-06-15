<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('css/bulma.css')}}">
    <title>Laravel</title>
</head>
<body class="has-background-dark" style="min-height: 49.8vw;">

<div id="app" class="container pt-5">
    <form action="" method="post" @submit.prevent="storeProject" @keydown="form.errors.clear($event.target.name)">
        @csrf
        <div class="control">
            <input type="hidden" v-model="form.projectId">
            <label for="project" class="has-text-light">Project Name</label>
            <input type="text" name="project" class="input mb-2 mt-1 column is-half" v-model="form.project"
                   placeholder="Project Name">
            <span v-if="form.errors.has('project')" v-text="form.errors.get('project')" class="help is-danger"></span>
        </div>

        <div>
            <label for="description" class="has-text-light">Project Description</label>
            <textarea name="description" class="textarea mb-2 mt-1 column is-full" v-model="form.description"
                      placeholder="Project Description"></textarea>
            <span v-if="form.errors.has('description')" v-text="form.errors.get('description')"
                  class="help is-danger"></span>
        </div>

        <input type="submit" class="button is-primary mt-3" value="submit" name="submitButton"
               :disabled="form.errors.any()">
        <a href="#" class="button is-info mt-3" @click.prevent="updateProject()" v-if="form.projectId">Update</a>
        <a href="#" class="button is-danger mt-3" @click.prevent="form.reset()">Clear All</a>
    </form>
    @include('projects.list')
</div>
<script src="{{asset('js/app.js')}}"></script>
</body>
</html>
