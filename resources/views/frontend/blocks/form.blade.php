<div class="flex justify-center mt-4">
    {{-- ✅ Success Message --}}
    @if (session('success'. $data['form'][0]['id']))
        <div class="alert alert-success w-auto max-w-lg rounded-xl shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>{{ session('success'. $data['form'][0]['id']) }}</span>
        </div>
    @endif

    {{-- ❌ Error Messages --}}
    @if ($errors->any())
        <div class="alert alert-error w-auto max-w-lg rounded-xl shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M6 18L18 6M6 6l12 12" />
            </svg>
            <div>
                <span class="font-semibold">Please fix the following:</span>
                <ul class="list-disc list-inside text-sm mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</div>
<div class="flex justify-center px-4" id="{{ $index }}">
    
    <form class="bg-white p-6 rounded-xl shadow-lg w-full max-w-2xl space-y-5" method="POST"
        action="{{ route('forms.submit', $data['form'][0]['id']) }}">
        @csrf
        <h2 class="text-xl font-semibold text-center text-gray-800">{{ $data['title']['value'] ?? '' }}</h2>
        @foreach ($data['form'][0]['formFields'] ?? [] as $field)
            {{-- @php $field->options = $field->options ? json_decode($field->options) : [] @endphp --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    {{ $field->label }}
                    @if (in_array('required', (array) $field->validation))
                        <span class="text-red-500">*</span>
                    @endif
                </label>

                @switch($field->type)
                    @case('text')
                        <input type="text" name="{{ $field->name }}" placeholder="{{ $field->placeholder }}"
                            @if (in_array('required', (array) $field->validation)) required @endif
                            class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    @break

                    @case('email')
                        <input type="email" name="{{ $field->name }}" placeholder="{{ $field->placeholder }}"
                            @if (in_array('required', (array) $field->validation)) required @endif
                            class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    @break

                    @case('textarea')
                        <textarea name="{{ $field->name }}" rows="4" placeholder="{{ $field->placeholder }}"
                            @if (in_array('required', (array) $field->validation)) required @endif
                            class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    @break

                    @case('radio')
                        @foreach ($field->options ?? [] as $option)
                            <label class="inline-flex items-center mr-4">
                                <input type="radio" name="{{ $field->name }}" value="{{ $option['key'] }}"
                                    class="form-radio text-blue-600" />
                                <span class="ml-2">{{ $option['value'] }}</span>
                            </label>
                        @endforeach
                    @break

                    @case('checkbox')
                        @foreach ($field->options ?? [] as $option)
                            <label class="inline-flex items-center mr-4">
                                <input type="checkbox" name="{{ $field->name }}[]" value="{{ $option['key'] }}"
                                    class="form-checkbox text-blue-600" />
                                <span class="ml-2">{{ $option['value'] }}</span>
                            </label>
                        @endforeach
                    @break

                    @case('select')
                        <select name="{{ $field->name }}"
                            class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option disabled selected>Select an option</option>
                            @foreach ($field->options ?? [] as $option)
                                <option value="{{ $option['key'] }}">{{ $option['value'] }}</option>
                            @endforeach
                        </select>
                    @break

                    @case('file')
                        <input type="file" name="{{ $field->name }}"
                            class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    @break

                    @default
                        <input type="text" name="{{ $field->name }}" placeholder="Unsupported field type"
                            class="w-full border border-red-300 px-4 py-2 rounded-lg text-red-500 bg-red-50" />
                @endswitch
            </div>
        @endforeach

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
            Submit
        </button>
    </form>
</div>
