<button {{ $attributes->merge(['type' => 'button', 'class' => 'font-bold text-gray-800 bg-yellow-400 hover:bg-yellow-500 px-6 py-3 rounded-md', 'style' => 'background-color: #FFD43B;']) }}>
    {{ $slot }}
</button>
