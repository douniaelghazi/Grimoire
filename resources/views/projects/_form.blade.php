@php $project ??= null; @endphp

<div class="space-y-6">
    @if(isset($isResearcherOnly) && $isResearcherOnly)
        <div class="space-y-2">
            <label for="avancement" class="block text-sm font-medium text-gray-700">Avancement (%)</label>
            <input id="avancement" name="avancement" type="number" min="0" max="100"
                value="{{ old('avancement', $project?->avancement) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            @error('avancement')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    @else
        <div class="space-y-2">
            <label for="title" class="block text-sm font-medium text-gray-700">Titre</label>
            <input id="title" name="title" type="text"
                value="{{ old('title', $project?->title) }}"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
            @error('title')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea id="description" name="description" rows="4"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $project?->description) }}</textarea>
            @error('description')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div class="space-y-2">
                <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
                <select id="status" name="status"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="encours" {{ old('status', $project?->status) === 'encours' ? 'selected' : '' }}>En cours</option>
                    <option value="cloture" {{ old('status', $project?->status) === 'cloture' ? 'selected' : '' }}>Clôturé</option>
                </select>
                @error('status')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-2">
                <label for="avancement" class="block text-sm font-medium text-gray-700">Avancement (%)</label>
                <input id="avancement" name="avancement" type="number" min="0" max="100"
                    value="{{ old('avancement', $project?->avancement) }}"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                @error('avancement')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    @endif
</div>
