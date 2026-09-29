<div
    x-data="{
        open:false,
        type:'warning',
        title:'',
        message:'',
        form:null,
        confirmText:'Teruskan',
        openModal(type,title,message,form,confirmText='Teruskan'){
            this.type=type;
            this.title=title;
            this.message=message;
            this.form=form;
            this.confirmText=confirmText;
            this.open=true;
        },
        confirm(){
            if(this.form){
                this.form.submit();
            }
            this.open=false;
        }
    }"
    x-on:open-alert.window="openModal($event.detail.type,$event.detail.title,$event.detail.message,$event.detail.form,$event.detail.confirmText)"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-[9999] flex items-center justify-center p-4 font-['Poppins']"
>
    <div
        x-show="open"
        x-transition.opacity
        class="absolute inset-0 bg-black/30 backdrop-blur-sm"
        @click="open=false"
    ></div>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        class="relative w-full max-w-sm bg-white rounded-3xl shadow-2xl p-6"
    >

        <div class="flex justify-center">

            <div
                x-show="type === 'warning'"
                class="w-20 h-20 text-red-500 flex items-center justify-center"
            >
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>

            </div>

            <div
                x-show="type === 'email'"
                class="w-20 h-20 text-purple-600 flex items-center justify-center"
            >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                </svg>

            </div>

        </div>

        <div class="text-center">

            <h3
                x-text="title"
                class="text-lg font-bold text-gray-900"
            ></h3>

            <p
                x-text="message"
                class="mt-2 text-sm text-gray-500 leading-6"
            ></p>

        </div>

        <div class="flex gap-3 mt-6">

            <button
                type="button"
                @click="open=false"
                class="flex-1 px-4 py-2.5 rounded-xl bg-gray-100 text-gray-700 text-sm font-semibold hover:bg-gray-200 transition"
            >
                Batal
            </button>

            <button
                type="button"
                @click="confirm()"
                x-text="confirmText"
                :class="type === 'warning'
                    ? 'bg-red-600 hover:bg-red-700'
                    : 'bg-purple-700 hover:bg-purple-800'"
                class="flex-1 px-4 py-2.5 rounded-xl text-white text-sm font-semibold transition"
            >
            </button>

        </div>

    </div>
</div>
