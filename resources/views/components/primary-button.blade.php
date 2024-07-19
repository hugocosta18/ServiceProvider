<button {{ $attributes->merge(['type' => 'submit', 'class' => 'font-bold text-gray-800 bg-green-400 hover:bg-green-500 px-6 py-3 rounded-md mr-4', 'style' => 'background-color: #B197FC;']) }}>
    {{ $slot }}
</button>
