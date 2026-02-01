<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cocina = Category::create(['name' => 'Cocina']);
        $mccafe = Category::create(['name' => 'McCafé']);
        $servicio = Category::create(['name' => 'Servicio']);

        //  COCINA

        // 1. Almíbar
        $p = $cocina->products()->create(['name' => 'Almíbar', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Recipiente tapado o bolsa abierta', 'duration_minutes' => 10080]); // 7 días

        // 2. Bacon en fetas
        $p = $cocina->products()->create(['name' => 'Bacon en fetas', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Bolsa abierta en refrigerador', 'duration_minutes' => 7200]); // 5 días
        $p->expirationRules()->create(['location' => 'Mesa de condimentación', 'duration_minutes' => 360]);  // 6 horas

        // 3. Carnes 10:1 / 4:1
        $p = $cocina->products()->create(['name' => 'Carnes 10:1 / 4:1', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Congelador pequeño', 'duration_minutes' => 120]);     // 2 horas
        $p->expirationRules()->create(['location' => 'Congelador de aire forzado', 'duration_minutes' => 1440]); // 24 horas
        $p->expirationRules()->create(['location' => 'En UHC', 'duration_minutes' => 15]);           // 15 minutos

        // 4. Cebolla Deshidratada
        $p = $cocina->products()->create(['name' => 'Cebolla Deshidratada', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Rehidratada en refrigerador', 'duration_minutes' => 1440]); // 24 horas
        $p->expirationRules()->create(['location' => 'Mesa de condimentación', 'duration_minutes' => 240]);  // 4 horas

        // 5. Cebolla Grillada
        $p = $cocina->products()->create(['name' => 'Cebolla Grillada', 'active' => true]);
        $p->expirationRules()->create(['location' => 'En UHC', 'duration_minutes' => 240]); // 4 horas

        // 6. Cebolla Fresca
        $p = $cocina->products()->create(['name' => 'Cebolla Fresca', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Bolsa abierta en refrigerador', 'duration_minutes' => 1440]); // 24 horas
        $p->expirationRules()->create(['location' => 'Mesa de condimentación', 'duration_minutes' => 120]);  // 2 horas

        // 7. Donuts (Probablemente McCafé, pero está en la lista general)
        $p = $cocina->products()->create(['name' => 'Donuts', 'active' => true]);
        $p->expirationRules()->create(['location' => 'A temperatura ambiente', 'duration_minutes' => 1440, 'defrosting' => 1, 'defrosting_time' => 90]); // 24 horas

        // 8. Ensaladas
        $p = $cocina->products()->create(['name' => 'Ensaladas', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Refrigerador o vitrina', 'duration_minutes' => 840]); // 14 horas (máximo)

        // 9. Huevos
        $p = $cocina->products()->create(['name' => 'Huevos', 'active' => true]);
        $p->expirationRules()->create(['location' => 'A temperatura ambiente', 'duration_minutes' => 30]);
        $p->expirationRules()->create(['location' => 'En UHC', 'duration_minutes' => 20]);

        // 10. Kétchup granel
        $p = $cocina->products()->create(['name' => 'Kétchup granel', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Bolsa abierta en refrigerador', 'duration_minutes' => 2880]); // 48 horas
        $p->expirationRules()->create(['location' => 'Mesa de condimentación', 'duration_minutes' => 1440]); // 24 horas

        // 11. Lechuga picada
        $p = $cocina->products()->create(['name' => 'Lechuga picada', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Bolsa abierta en refrigerador', 'duration_minutes' => 1440]); // 24 horas
        $p->expirationRules()->create(['location' => 'Mesa de condimentación', 'duration_minutes' => 120]);  // 2 horas

        // 12. Lomo Canadiense
        $p = $cocina->products()->create(['name' => 'Lomo Canadiense', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Bolsa abierta en refrigerador', 'duration_minutes' => 4320]); // 3 días

        // 13. Mayonesa granel
        $p = $cocina->products()->create(['name' => 'Mayonesa granel', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Bolsa abierta en refrigerador', 'duration_minutes' => 2880]); // 48 horas
        $p->expirationRules()->create(['location' => 'Mesa de condimentación', 'duration_minutes' => 120]);  // 2 horas

        // 14. Factureras

        $p = $cocina->products()->create(['name' => 'Factura', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Congelador pequeño', 'duration_minutes' => 120]); // 2 horas
        $p->expirationRules()->create(['location' => 'Horneadas en rack o vitrina', 'duration_minutes' => 360]); // 6 horas
        $p->category()->attach($mccafe->id);


        // 15. McNuggets
        $p = $cocina->products()->create(['name' => 'McNuggets', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Congelador de pared', 'duration_minutes' => 60]);   // 1 hora
        $p->expirationRules()->create(['location' => 'Congelador de aire forzado', 'duration_minutes' => 1440]); // 24 horas
        $p->expirationRules()->create(['location' => 'En UHC', 'duration_minutes' => 20]);

        // 16. McPollo
        $p = $cocina->products()->create(['name' => 'McPollo', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Congelador de pared', 'duration_minutes' => 60]);   // 1 hora
        $p->expirationRules()->create(['location' => 'Congelador de aire forzado', 'duration_minutes' => 1440]); // 24 horas
        $p->expirationRules()->create(['location' => 'En UHC', 'duration_minutes' => 30]);

        // 17. Mezcla de sal y pimienta
        $p = $cocina->products()->create(['name' => 'Mezcla de sal y pimienta', 'active' => true]);
        $p->expirationRules()->create(['location' => 'En jarra en sector de parrilla', 'duration_minutes' => 10080]); // 7 días
        $p->expirationRules()->create(['location' => 'Salero', 'duration_minutes' => 1440]); // Nota: El PDF dice "Desechar en el cierre", puse 24hs como placeholder.

        // 18. Mostaza granel
        $p = $cocina->products()->create(['name' => 'Mostaza granel', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Bolsa abierto en refrigerador', 'duration_minutes' => 10080]); // 7 días
        $p->expirationRules()->create(['location' => 'Mesa de condimentación', 'duration_minutes' => 1440]); // 24 horas

        // 19. Pan Criollo (Kayser)
        $p = $cocina->products()->create(['name' => 'Pan Criollo (Kayser)', 'active' => true]);
        $p->expirationRules()->create(['location' => 'A temperatura ambiente', 'duration_minutes' => 2880, 'defrosting' => 1, 'defrosting_time' => 360]); // 48 horas

        // 20. Pan para Celíacos
        $p = $cocina->products()->create(['name' => 'Pan para Celíacos', 'active' => true]);
        $p->expirationRules()->create(['location' => 'A temperatura ambiente', 'duration_minutes' => 4320, 'defrosting' => 1, 'defrosting_time' => 120]); // 72 horas


        // 21. Pechuga Grill
        $p = $cocina->products()->create(['name' => 'Pechuga Grill', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Congelador de pared', 'duration_minutes' => 60]);   // 1 hora
        $p->expirationRules()->create(['location' => 'Congelador de aire forzado', 'duration_minutes' => 1440]); // 24 horas
        $p->expirationRules()->create(['location' => 'En UHC', 'duration_minutes' => 60]);           // 1 hora

        // 22. Pepinos
        $p = $cocina->products()->create(['name' => 'Pepinos', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Bolsa abierta en refrigerador', 'duration_minutes' => 5760]); // 4 días
        $p->expirationRules()->create(['location' => 'Mesa de condimentación', 'duration_minutes' => 1440]); // 24 horas

        // 23. Pollo Crispy
        $p = $cocina->products()->create(['name' => 'Pollo Crispy', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Congelador de pared', 'duration_minutes' => 60]);   // 1 hora
        $p->expirationRules()->create(['location' => 'Congelador de aire forzado', 'duration_minutes' => 1440]); // 24 horas
        $p->expirationRules()->create(['location' => 'En UHC', 'duration_minutes' => 30]);

        // 24. Queso Cheddar
        $p = $cocina->products()->create(['name' => 'Queso Cheddar', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Bolsa abierta en refrigerador', 'duration_minutes' => 1440]); // 24 horas
        $p->expirationRules()->create(['location' => 'Mesa de condimentación', 'duration_minutes' => 120]);  // 2 horas

        // 25. Queso en cubos
        $p = $cocina->products()->create(['name' => 'Queso en cubos', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Bolsa abierta en refrigerador', 'duration_minutes' => 1440]); // 24 horas

        // 26. Salsa Barbacoa
        $p = $cocina->products()->create(['name' => 'Salsa Barbacoa', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Abierto en refrigerador', 'duration_minutes' => 5760]); // 4 días
        $p->expirationRules()->create(['location' => 'A temperatura ambiente', 'duration_minutes' => 1440]); // 24 horas

        // 27. Salsa BigMac
        $p = $cocina->products()->create(['name' => 'Salsa BigMac', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Mesa de condimentación', 'duration_minutes' => 1440]); // 24 horas

        // 28. Salsa Spicy
        $p = $cocina->products()->create(['name' => 'Salsa Spicy', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Abierto en refrigerador', 'duration_minutes' => 5760]); // 4 días
        $p->expirationRules()->create(['location' => 'A temperatura ambiente', 'duration_minutes' => 240]); // 4 horas

        // 29. Salsa Tasty
        $p = $cocina->products()->create(['name' => 'Salsa Tasty', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Abierto en refrigerador', 'duration_minutes' => 4320]); // 72 horas
        $p->expirationRules()->create(['location' => 'A temperatura ambiente', 'duration_minutes' => 240]); // 4 horas

        // 30. Tomates
        $p = $cocina->products()->create(['name' => 'Tomates', 'active' => true]);
        $p->expirationRules()->create(['location' => 'A temperatura ambiente', 'duration_minutes' => 120]); // 2 horas

        // 31. Queso Cheddar fundido
        $p = $cocina->products()->create(['name' => 'Queso Cheddar fundido', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Bolsa abierta en refrigerador', 'duration_minutes' => 7200]); // 5 días
        $p->expirationRules()->create(['location' => 'A temperatura ambiente', 'duration_minutes' => 240]); // 4 horas


    }
}
