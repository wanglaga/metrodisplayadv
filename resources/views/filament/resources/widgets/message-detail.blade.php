<div class="space-y-4 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
    <div>
        <p class="text-sm font-medium text-gray-400">Waktu Pesan :</p>
        <p class="text-base text-gray-900 dark:text-gray-100">{{ $message->created_at->timezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY, HH.mm') }}

        </p>
    </div>
    <div>
        <p class="text-sm font-medium text-gray-400">Nama :</p>
        <p class="text-base text-gray-900 dark:text-gray-100">{{ $message->name }}</p>
    </div>

    <div>
        <p class="text-sm font-medium text-gray-400">Email :</p>
        <p class="text-base text-gray-900 dark:text-gray-100">{{ $message->email }}</p>
    </div>

    <div>
        <p class="text-sm font-medium text-gray-400">No HP :</p>
        <p class="text-base text-gray-900 dark:text-gray-100">{{ $message->phone_number }}</p>
    </div>

    <hr class="border-gray-200 dark:border-gray-700">

    <div>
        <p class="text-sm font-medium text-gray-400">Pesan :</p>
        <p class="text-base text-gray-900 dark:text-gray-100 whitespace-pre-line">
            {{ $message->content }}
        </p>
    </div>
</div>
