<script setup lang="ts">
import { watch } from 'vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import { Package, Info, DollarSign, Camera, Image as ImageIcon } from 'lucide-vue-next';


const props = defineProps<{ 
    form: any; 
    maestros: any[]; 
    isEditing?: boolean; 
}>();


watch(() => props.form.sku, (newSku) => {
    if (!props.isEditing) {
        const m = props.maestros.find(x => x.sku === newSku);
        if (m) {
            props.form.nombre_comercial = m.nombre_tecnico.replace('[SIMULACIÓN] ', '');
            props.form.nombre_generico = m.principio_activo;
            props.form.concentracion = m.concentracion || 'N/A';
            props.form.forma_farmaceutica = m.categoria || 'Tabletas';
        }
    }
});


const getPreviewUrl = (file: File) => {
    return URL.createObjectURL(file);
};
</script>

<template>
    <div class="space-y-8 text-foreground">
        
        <!-- SECCIÓN 1: VÍNCULO CON CENTRAL -->

        <div class="bg-primary/5 p-5 rounded-2xl border border-primary/10" :class="{'opacity-70': isEditing}">
            <div class="flex items-center gap-2 mb-4">
                <Package class="size-4 text-primary" />
                <span class="text-[10px] font-black uppercase tracking-widest">Identificador de Trazabilidad</span>
            </div>
            
            <Label for="sku" class="text-[9px] uppercase ml-1">SKU del Almacén Central</Label>
            

            <select 
                v-if="!isEditing"
                v-model="form.sku"
                id="sku"
                class="w-full mt-1.5 border-border bg-background rounded-xl text-sm h-12 px-4 focus:ring-2 focus:ring-primary/30 outline-none transition"
            >
                <option value="" disabled>Seleccione un producto disponible...</option>
                <option v-for="m in maestros" :key="m.sku" :value="m.sku">
                    {{ m.sku }} — {{ m.nombre_tecnico }} (Stock: {{ m.stock_disponible }} uds.)
                </option>
            </select>


            <Input 
                v-else 
                v-model="form.sku" 
                readonly 
                class="mt-1.5 bg-muted font-mono" 
            />
            
            <p v-if="isEditing" class="text-[9px] text-muted-foreground mt-1 uppercase italic">
                * El SKU no puede modificarse para garantizar la trazabilidad con Central.
            </p>
            <InputError :message="form.errors.sku" class="mt-1" />
        </div>

        <!-- SECCIÓN 2: DATOS COMERCIALES -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <Info class="size-4 text-primary" />
                    <span class="text-[10px] font-black uppercase tracking-widest">Ficha de Venta</span>
                </div>
                <div>
                    <Label for="nc" class="text-[10px] uppercase">Nombre Comercial</Label>
                    <Input v-model="form.nombre_comercial" id="nc" class="mt-1 h-11" />
                    <InputError :message="form.errors.nombre_comercial" />
                </div>
                <div>
                    <Label for="ng" class="text-[10px] uppercase">Nombre Genérico</Label>
                    <Input v-model="form.nombre_generico" id="ng" class="mt-1 h-11" />
                    <InputError :message="form.errors.nombre_generico" />
                </div>
            </div>

            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <DollarSign class="size-4 text-gold-500" />
                    <span class="text-[10px] font-black uppercase tracking-widest text-gold-500">Precio y Visibilidad</span>
                </div>
                <div>
                    <Label for="pw" class="text-[10px] uppercase font-black text-gold-600">Precio Web (S/)</Label>
                    <Input v-model="form.precio_web" type="number" step="0.01" id="pw" class="mt-1 h-11 border-gold-500/30 bg-gold-500/5 text-lg font-black text-gold-600" />
                    <InputError :message="form.errors.precio_web" />
                </div>
                <div class="grid grid-cols-2 gap-4 pt-2">
                    <label class="flex items-center gap-3 p-3 bg-muted/30 rounded-xl cursor-pointer hover:bg-muted/50 transition border border-transparent hover:border-border">
                        <input type="checkbox" v-model="form.requiere_receta" class="rounded border-border text-primary" />
                        <span class="text-[10px] font-black uppercase tracking-tighter">Receta Médica</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 bg-muted/30 rounded-xl cursor-pointer hover:bg-muted/50 transition border border-transparent hover:border-border">
                        <input type="checkbox" v-model="form.disponible" class="rounded border-border text-emerald-500" />
                        <span class="text-[10px] font-black uppercase tracking-tighter">Visible</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- SECCIÓN 3: IMAGEN Y DESCRIPCIÓN -->
        <div class="space-y-4">
            <div class="flex items-center gap-2">
                <Camera class="size-4 text-primary" />
                <span class="text-[10px] font-black uppercase tracking-widest">Contenido Multimedia</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                <div class="md:col-span-1 space-y-3">
                    <div class="relative aspect-square bg-muted rounded-2xl border-2 border-dashed border-border flex items-center justify-center overflow-hidden group transition-all hover:border-primary/50">
                        

                        <img v-if="form.imagen" :src="getPreviewUrl(form.imagen)" class="object-cover w-full h-full" />
                        <img v-else-if="form.imagen_url_actual" :src="form.imagen_url_actual" class="object-cover w-full h-full" />
                        <div v-else class="text-center p-4">
                            <ImageIcon class="size-8 mx-auto text-muted-foreground/20 mb-2" />
                            <p class="text-[8px] font-black uppercase text-muted-foreground">Sin Imagen</p>
                        </div>


                        <input 
                            type="file" 
                            @input="form.imagen = ($event.target as HTMLInputElement).files?.[0]" 
                            class="absolute inset-0 opacity-0 cursor-pointer z-10" 
                            accept="image/*"
                        />
                        
                        <div class="absolute inset-0 bg-black/60 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                            <Camera class="size-5 text-white mb-1" />
                            <span class="text-[9px] font-black text-white uppercase tracking-widest">Cambiar Foto</span>
                        </div>
                    </div>
                    <InputError :message="form.errors.imagen" />
                </div>
                
                <div class="md:col-span-3">
                    <Label class="text-[10px] uppercase ml-1">Descripción Comercial para el Cliente</Label>
                    <textarea 
                        v-model="form.descripcion"
                        rows="7"
                        class="w-full mt-1.5 bg-background border-border rounded-2xl p-4 text-sm focus:ring-2 focus:ring-primary/20 outline-none transition resize-none"
                        placeholder="Describa los beneficios, modo de uso o precauciones..."
                    ></textarea>
                    <InputError :message="form.errors.descripcion" />
                </div>
            </div>
        </div>


        <slot name="actions" />
    </div>
</template>