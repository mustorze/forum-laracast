<div class="panel panel-default" v-if="editing">
    <div class="panel-heading">
        <div class="level">
            <input type="text" class="form-control" v-model="form.title">
        </div>
    </div>

    <div class="panel-body">
        <div class="form-group">
            <wysiwyg name="body" v-model="form.body" :value="form.body"></wysiwyg>
        </div>
    </div>

    <div class="panel-footer">
        <div class="level">
            <button class="btn btn-xs level-item" @click="editing = true" v-show="!editing">Edit</button>
            <button class="btn btn-xs btn-primary level-item" @click="update">Update</button>
            <button class="btn btn-xs level-item" @click="cancel">Cancel</button>

            @can ('update', $thread)
                <form class="ml-a" action="{{ $thread->path() }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-link">Delete Thread</button>
                </form>
            @endcan
        </div>
    </div>
</div>

<div class="panel panel-default" v-if="!editing">
    <div class="panel-heading">
        <div class="level">
            <img src="{{ $thread->creator->avatar_path }}" alt="{{ $thread->creator->name }}" width="25" class="mr-1">
            <span class="flex">
                <a href="{{ route('profiles.show', $thread->creator->name) }}">
                    {{ $thread->creator->name }}
                </a> posted: <span v-text="form.title"></span>
            </span>
        </div>
    </div>

    <div class="panel-body" v-html="form.body">
    </div>

    <div class="panel-footer" v-if="authorize('owns', thread)">
        <button class="btn btn-xs" @click="editing = true">Edit</button>
    </div>
</div>