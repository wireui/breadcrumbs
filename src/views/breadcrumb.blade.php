<div
    class="flex items-center text-slate-600"
    x-data="{
        page: @js($page),
        breadcrumb: @js($breadcrumb),

        init() {
            document.addEventListener('breadcrumb', ({ detail }) => {
                this.breadcrumb = detail
            })
        }
    }"
>
    <p x-text="page" class="font-semibold tracking-wider sm:pr-4 sm:border-r sm:border-gray-300"></p>

    <div class="hidden sm:flex items-center gap-2 pl-3.5">
        <a href="{{ $home }}">
            <!-- Heroicons home/outline -->
            <svg class="w-5 h-5 text-primary-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
        </a>

        <template x-for="item in breadcrumb" :key="item.url + item.label">
            <div class="flex items-center gap-2 text-primary-600 last:text-gray-400">
                <!-- Heroicons chevron-right/outline -->
                <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>

                <a x-text="item.label" :href="item.url && item.url"></a>
            </div>
        </template>
    </div>
</div>
