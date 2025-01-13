@php
    $type = $getState(); // The type value (e.g., 'radio', 'text', etc.)
@endphp

<div class="text-center">
    @if ($type->value === 'radio')
        <input type="radio" disabled
            class="text-blue-500 bg-gray-100 border-gray-300 rounded cursor-not-allowed focus:ring-2 focus:ring-blue-500" />
    @elseif($type->value === 'checkbox')
        <input type="checkbox" disabled
            class="text-blue-500 bg-gray-100 border-gray-300 rounded cursor-not-allowed focus:ring-2 focus:ring-blue-500" />
    @elseif($type->value === 'text')
        <input type="text" disabled value="Sample Text"
            class="px-4 py-2 text-gray-700 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500" />
    @elseif($type->value === 'textarea')
        <textarea disabled rows="1" style="resize: none;"
            class="px-4 py-2 text-gray-700 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500">Sample Text</textarea>
    @elseif($type->value === 'select')
        <select disabled
            class="px-4 py-2 text-gray-700 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500">
            <option>Select</option>
        </select>
    @elseif($type->value === 'email')
        <input type="email" disabled value="example@example.com"
            class="px-4 py-2 text-gray-700 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500" />
    @elseif($type->value === 'number')
        <input type="number" disabled value="0"
            class="px-4 py-2 text-gray-700 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500" />
    @elseif($type->value === 'date')
        <input type="date" disabled
            class="px-4 py-2 text-gray-700 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500" />
    @elseif($type->value === 'time')
        <input type="time" disabled
            class="px-4 py-2 text-gray-700 bg-gray-100 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500" />
    @else
        <span class="text-red-500">Unsupported type</span>
    @endif
</div>
