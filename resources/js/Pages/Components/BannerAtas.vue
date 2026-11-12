<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue'

const currentTime = ref('')
const bannerUrl = '/asset/banneratas-01.jpg'
const logoUrl = '/asset/kpnlogo.png'

function updateTime() {
    currentTime.value = new Intl.DateTimeFormat('ms-MY', {
        timeZone: 'Asia/Kuala_Lumpur',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false,
    }).format(new Date())
}

const ucapan = computed(() => {
    const jam = Number(
        new Intl.DateTimeFormat('en-US', {
            timeZone: 'Asia/Kuala_Lumpur',
            hour: '2-digit',
            hour12: false,
        }).format(new Date())
    )

    if (jam >= 5 && jam < 12) {
        return 'Selamat Pagi'
    }

    if (jam >= 12 && jam < 15) {
        return 'Selamat Tengah Hari'
    }

    if (jam >= 15 && jam < 19) {
        return 'Selamat Petang'
    }

    return 'Selamat Malam'
})

let timer

onMounted(() => {
    updateTime()
    timer = setInterval(updateTime, 1000)
})

onUnmounted(() => {
    clearInterval(timer)
})
</script>

<template>

    <div class="relative overflow-hidden h-[200px] rounded-2xl shadow-sm border border-purple-100">

        <!-- BACKGROUND -->
        <img :src="bannerUrl"" class=" absolute inset-0 w-full h-full object-cover object-center"
            alt="Banner Background">

        <!-- OVERLAY -->
        <div class="absolute inset-0 bg-black/10"></div>


        <!-- CONTENT -->
        <div class="relative z-10 h-full px-8 md:px-12 py-7 flex flex-col justify-between mt-5">

            <div>

                <!-- UCAPAN -->
                <h1 class="text-4xl md:text-5xl font-bold font-['Poppins'] text-purple-900 tracking-wide">
                    {{ ucapan }}! 👋
                </h1>


                <!-- WAKTU -->
                <div
                    class="inline-flex items-center mt-3 px-4 py-2 rounded-xl bg-white/20 backdrop-blur-md border border-white/30 text-white shadow-lg">

                    <span class="font-semibold text-base md:text-lg">
                        {{ currentTime }}
                    </span>

                </div>

            </div>


            <!-- LOGO KPN -->
            <img :src="logoUrl"
                class="absolute right-6 w-24 h-24 md:w-28 md:h-28 object-contain bg-white/50 rounded-full p-2 shadow-md"
                alt="Kementerian Perpaduan Negara">

        </div>

    </div>

</template>
