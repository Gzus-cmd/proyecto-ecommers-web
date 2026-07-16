<script setup lang="ts">
import { Truck, CheckCircle2 } from 'lucide-vue-next';


const props = defineProps<{ status: number }>();

const progressWidth = () => {
    if (props.status === 1) return '10%';
    if (props.status === 2) return '50%';
    return '100%';
};
</script>

<template>
    <div class="w-full py-10 px-4">
        <div class="relative w-full h-1.5 bg-gray-100 rounded-full">

            <div 
                class="absolute top-0 left-0 h-full bg-[#5790AB] transition-all duration-1000 ease-in-out rounded-full"
                :style="{ width: progressWidth() }"
            ></div>


            <div 
                class="absolute -top-7 transition-all duration-1000 ease-in-out"
                :style="{ left: `calc(${progressWidth()} - 20px)` }"
            >
                <div class="flex flex-col items-center">
                    <span v-if="status === 2" class="text-[8px] font-black bg-[#072D44] text-white px-2 py-0.5 rounded-full mb-1 animate-pulse uppercase tracking-tighter">En Ruta</span>
                    <Truck 
                        class="size-7 text-[#072D44]" 
                        :class="{ 'animate-bounce': status === 2 }" 
                    />
                </div>
            </div>


            <div class="absolute top-0 left-0 w-full flex justify-between">
                <div class="size-3 bg-[#5790AB] rounded-full -mt-0.5 ring-4 ring-white"></div>
                <div class="size-3 bg-gray-200 rounded-full -mt-0.5 ring-4 ring-white" :class="{ '!bg-[#5790AB]': status >= 2 }"></div>
                <div class="size-3 bg-gray-200 rounded-full -mt-0.5 ring-4 ring-white" :class="{ '!bg-green-500': status === 3 }"></div>
            </div>
        </div>

        <div class="flex justify-between mt-4 text-[9px] font-black uppercase text-gray-400 tracking-widest">
            <span>Pedido Recibido</span>
            <span>Despachando</span>
            <span :class="{ 'text-green-600': status === 3 }">Entregado</span>
        </div>
    </div>
</template>