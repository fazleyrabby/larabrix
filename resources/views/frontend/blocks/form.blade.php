<div class="flex justify-center px-4" id="{{ $index }}">
  <form class="bg-white p-6 rounded-xl shadow-lg w-full max-w-2xl space-y-5" method="POST">
    @csrf
    <h2 class="text-xl font-semibold text-center text-gray-800">{{ $data['title'] }}</h2>

    @foreach ($data['form']['formFields'] as $field)
      {{-- @php $field->options = $field->options ? json_decode($field->options) : [] @endphp --}}
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
          {{ $field->label }}
          @if(in_array('required', (array) $field->validation))
            <span class="text-red-500">*</span>
          @endif
        </label>

        @switch($field->type)

          @case('text')
            <input 
              type="text" 
              name="{{ $field->name }}" 
              placeholder="{{ $field->placeholder }}" 
              @if(in_array('required', (array) $field->validation)) required @endif
              class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
            @break

          @case('textarea')
            <textarea 
              name="{{ $field->name }}" 
              rows="4" 
              placeholder="{{ $field->placeholder }}" 
              @if(in_array('required', (array) $field->validation)) required @endif
              class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            @break

          @case('radio')
            @foreach ($field->options as $option)
              <label class="inline-flex items-center mr-4">
                <input type="radio" name="{{ $field->name }}" value="{{ $option['key'] }}" class="form-radio text-blue-600" />
                <span class="ml-2">{{ $option['value'] }}</span>
              </label>
            @endforeach
            @break

          @case('checkbox')
            @foreach ($field->options ? json_decode($field->options, true) : [] as $option)
              <label class="inline-flex items-center mr-4">
                <input type="checkbox" name="{{ $field->name }}[]" value="{{ $option['key'] }}" class="form-checkbox text-blue-600" />
                <span class="ml-2">{{ $option['value'] }}</span>
              </label>
            @endforeach
            @break

          @case('select')
            <select 
              name="{{ $field->name }}" 
              class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
              <option disabled selected>Select an option</option>
              @foreach ($field->options ? json_decode($field->options, true) : [] as $option)
                <option value="{{ $option['key'] }}">{{ $option['value'] }}</option>
              @endforeach
            </select>
            @break

          @case('file')
            <input type="file" name="{{ $field->name }}" 
              class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
            @break

          @default
            <input 
              type="text" 
              name="{{ $field->name }}" 
              placeholder="Unsupported field type" 
              class="w-full border border-red-300 px-4 py-2 rounded-lg text-red-500 bg-red-50" />
        @endswitch
      </div>
    @endforeach

    <button type="submit"
            class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
      Submit
    </button>
  </form>
</div>