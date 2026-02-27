<x-layout :title="$form->title">
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $form->title }}</h1>
                @if($form->description)
                    <p class="text-gray-600 mb-8">{{ $form->description }}</p>
                @endif

                @if(session('success'))
                    <div class="bg-green-50 text-green-700 p-4 rounded-lg mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('forms.submit', $form->slug) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    @if($form->fields)
                        @foreach($form->fields as $field)
                            @php
                                $type = $field['type'] ?? 'text';
                                $label = $field['name'] ?? 'Untitled Field';
                                $name = Str::slug($label, '_');
                                $required = $field['required'] ?? false;
                                $options = isset($field['options']) ? (is_array($field['options']) ? $field['options'] : explode(',', $field['options'])) : [];
                            @endphp

                            <div class="flex flex-col gap-1">
                                <label for="{{ $name }}" class="text-sm font-medium text-gray-700">
                                    {{ $label }} @if($required) <span class="text-red-500">*</span> @endif
                                </label>

                                @if($type === 'textarea')
                                    <textarea name="{{ $name }}" id="{{ $name }}" rows="4"
                                        class="rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500" {{ $required ? 'required' : '' }}>{{ old($name) }}</textarea>
                                @elseif($type === 'select')
                                    <select name="{{ $name }}" id="{{ $name }}"
                                        class="rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500" {{ $required ? 'required' : '' }}>
                                        <option value="">-- Pilih --</option>
                                        @foreach($options as $option)
                                            @php $optValue = is_array($option) ? ($option['option'] ?? '') : $option; @endphp
                                            <option value="{{ $optValue }}" {{ old($name) == $optValue ? 'selected' : '' }}>
                                                {{ $optValue }}</option>
                                        @endforeach
                                    </select>
                                @elseif($type === 'radio')
                                    <div class="space-y-2 mt-1">
                                        @foreach($options as $option)
                                            @php $optValue = is_array($option) ? ($option['option'] ?? '') : $option; @endphp
                                            <div class="flex items-center gap-2">
                                                <input type="radio" name="{{ $name }}" id="{{ $name }}_{{ $loop->index }}"
                                                    value="{{ $optValue }}"
                                                    class="border-gray-300 text-primary-600 focus:ring-primary-500" {{ $required ? 'required' : '' }} {{ old($name) == $optValue ? 'checked' : '' }}>
                                                <label for="{{ $name }}_{{ $loop->index }}"
                                                    class="text-sm text-gray-600">{{ $optValue }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif($type === 'checkbox')
                                    <div class="space-y-2 mt-1">
                                        @foreach($options as $option)
                                            @php $optValue = is_array($option) ? ($option['option'] ?? '') : $option; @endphp
                                            <div class="flex items-center gap-2">
                                                <input type="checkbox" name="{{ $name }}[]" id="{{ $name }}_{{ $loop->index }}"
                                                    value="{{ $optValue }}"
                                                    class="rounded border-gray-300 text-primary-600 focus:ring-primary-500" {{ is_array(old($name)) && in_array($optValue, old($name)) ? 'checked' : '' }}>
                                                <label for="{{ $name }}_{{ $loop->index }}"
                                                    class="text-sm text-gray-600">{{ $optValue }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif($type === 'date')
                                    <input type="date" name="{{ $name }}" id="{{ $name }}"
                                        class="rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                                        value="{{ old($name) }}" {{ $required ? 'required' : '' }}>
                                @elseif($type === 'file')
                                    <input type="file" name="{{ $name }}" id="{{ $name }}"
                                        class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100"
                                        {{ $required ? 'required' : '' }}>
                                @else
                                    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
                                        class="rounded-lg border-gray-300 focus:border-primary-500 focus:ring-primary-500"
                                        value="{{ old($name) }}" {{ $required ? 'required' : '' }}>
                                @endif

                                @error($name)
                                    <p class="text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                    @endif

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl shadow-lg shadow-primary-600/20 transition transform active:scale-95">
                            Kirim
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>