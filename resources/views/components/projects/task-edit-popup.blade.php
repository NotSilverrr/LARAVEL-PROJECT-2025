<div class="modal-content bg-gray-800 p-10 rounded-[1.5rem] w-11/12 max-w-6xl max-h-[90vh] overflow-y-auto">
    <button class="modal-close text-white text-3xl ml-auto mb-4">&times;</button>
    <h2 class="text-white text-2xl font-bold mb-10 text-center">{{ 'Modifier la tâche ' . $task->title ?? 'Modifier une tâche' }}</h2>
    <form action="{{ $action }}" method="POST" class="flex flex-col gap-0">
        @csrf
        @isset($method)
            @method($method)
        @endisset
        <div class="flex flex-col md:flex-row gap-8">
            <div class="flex-1 flex flex-col gap-6">
                <div>
                    <label for="priority" class="block text-gray-100 text-sm font-bold mb-2">@lang('messages.task_priority')</label>
                    <select name="priority" id="priority" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="" disabled>@lang('messages.choose_priority')</option>
                        <option value="low" {{ old('priority', $task->priority ?? '') == 'low' ? 'selected' : '' }}>@lang('messages.low_priority')</option>
                        <option value="medium" {{ old('priority', $task->priority ?? '') == 'medium' ? 'selected' : '' }}>@lang('messages.medium_priority')</option>
                        <option value="high" {{ old('priority', $task->priority ?? '') == 'high' ? 'selected' : '' }}>@lang('messages.high_priority')</option>
                    </select>
                </div>
                <div>
                    <label for="category_id" class="block text-gray-100 text-sm font-bold mb-2">@lang('messages.task_category')</label>
                    <select name="category_id" id="category" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="" disabled>@lang('messages.choose_category')</option>
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}" {{ old('category_id', $task->category_id ?? '') == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="users" class="block text-gray-100 text-sm font-bold mb-2">@lang('messages.member')s assignés</label>
                    <select name="user_ids[]" id="users" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" multiple>
                        @foreach ($project->users as $user)
                            <option value="{{ $user->id }}" {{ in_array($user->id, $task->users->pluck('id')->toArray()) ? 'selected' : '' }}>
                                {{ $user->firstname }} {{ $user->lastname }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="groups" class="block text-gray-100 text-sm font-bold mb-2">@lang('messages.group')s assignés</label>
                    <select name="group_ids[]" id="groups" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" multiple>
                        @foreach ($groups as $group)
                            <option value="{{ $group->id }}" {{ in_array($group->id, $task->groups->pluck('id')->toArray()) ? 'selected' : '' }}>
                                {{ $group->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="date_start" class="block text-gray-100 text-sm font-bold mb-2">@lang('messages.date_start')</label>
                    <input type="date" id="date_start" name="date_start" value="{{ old('date_start', isset($task->date_start) ? $task->date_start->format('Y-m-d') : '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div>
                    <label for="date_end" class="block text-gray-100 text-sm font-bold mb-2">@lang('messages.date_end')</label>
                    <input type="date" id="date_end" name="date_end" value="{{ old('date_end', isset($task->date_end) ? $task->date_end->format('Y-m-d') : '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div>
                    <label for="status" class="block text-gray-100 text-sm font-bold mb-2">@lang('messages.task_status')</label>
                    <select name="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="todo" {{ old('status', $task->status ?? '') == 'todo' ? 'selected' : '' }}>@lang('messages.status_todo')</option>
                        <option value="in_progress" {{ old('status', $task->status ?? '') == 'in_progress' ? 'selected' : '' }}>@lang('messages.status_in_progress')</option>
                        <option value="done" {{ old('status', $task->status ?? '') == 'done' ? 'selected' : '' }}>@lang('messages.status_done')</option>
                    </select>
                </div>
            </div>
            <div class="flex-1 flex flex-col gap-6">
                <div>
                    <label for="title" class="block text-gray-100 text-sm font-bold mb-2">@lang('messages.task_title')</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $task->title ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>
                <div class="flex-1">
                    <label for="description" class="block text-gray-100 text-sm font-bold mb-2">@lang('messages.task_description')</label>
                    <textarea id="description" name="description" rows="17" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-100 bg-gray-700 leading-tight focus:outline-none focus:shadow-outline resize-y" required>{{ old('description', $task->description ?? '') }}</textarea>
                </div>
            </div>
        </div>
        <input type="hidden" name="column_id" id="column_id" value="{{ old('column_id', $task->column_id ?? '') }}">
        <button type="submit" class="block px-8 py-3 rounded-[1rem] bg-gradient-to-b from-[#E04E75] to-[#902340] hover:bg-gradient-to-t text-white text-lg font-semibold mt-8 w-full">{{ $button ?? __('messages.update') }}</button>
    </form>
    <form action="{{ route('projects.tasks.destroy', ['project' => $project->id, 'task' => $task->id]) }}" method="POST" class="mt-4">
        @csrf
        @method('DELETE')
        <button type="submit" class="block px-8 py-3 rounded-[1rem] bg-gradient-to-b from-red-500 to-red-800 hover:bg-gradient-to-t text-white text-lg font-semibold w-full">{{ __('messages.delete') }}</button>
    </form>
</div>
