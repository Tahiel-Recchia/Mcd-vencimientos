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
        $isla = Category::create(['name' => 'Isla']);

        //  COCINA

        // 1. Almíbar
        $p = $cocina->products()->create(['name' => 'Almíbar', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Recipiente tapado o bolsa abierta', 'duration_minutes' => 10080]); // 7 días
        $p->category()->attach($mccafe->id);

        // 2. Bacon en fetas
        $p = $cocina->products()->create(['name' => 'Bacon en fetas', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Bolsa abierta en refrigerador', 'duration_minutes' => 7200]); // 5 días
        $p->expirationRules()->create(['location' => 'Mesa de condimentación', 'duration_minutes' => 360]);  // 6 horas

        // 3. Carnes 10:1
        $p = $cocina->products()->create(['name' => 'Carne 10:1', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Congelador pequeño', 'duration_minutes' => 120]);     // 2 horas
        $p->expirationRules()->create(['location' => 'Congelador de aire forzado', 'duration_minutes' => 1440]); // 24 horas
        $p->expirationRules()->create(['location' => 'En UHC', 'duration_minutes' => 15]);           // 15 minutos

        // 3. Carnes 4:1
        $p = $cocina->products()->create(['name' => 'Carne 4:1', 'active' => true]);
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

        // 7. Donuts
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

        // 14. Facturas

        $p = $cocina->products()->create(['name' => 'Factura', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Congelador pequeño', 'duration_minutes' => 120]); // 2 horas
        $p->expirationRules()->create(['location' => 'Horneadas en rack o vitrina', 'duration_minutes' => 360]); // 6 horas


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
        $p = $cocina->products()->create(['name' => 'Queso en cubos', 'active' => false]);
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

        //MCCAFE

// 1. Aguas frutadas
        $p = $mccafe->products()->create(['name' => 'Aguas frutadas', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Abierto en refrigerador', 'duration_minutes' => 10080]); // 7 días
        $p->expirationRules()->create(['location' => 'Preparado', 'duration_minutes' => 240]); // 4 horas

// 2. Alfajor de maicena
        $p = $mccafe->products()->create(['name' => 'Alfajor de maicena', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Vitrina, recipiente tapado', 'duration_minutes' => 4320, 'defrosting' => 1, 'defrosting_time' => 120]); // 3 días incl. 2hs desc.


// 4. Azúcar
        $p = $mccafe->products()->create(['name' => 'Azúcar', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Bolsa abierta', 'duration_minutes' => 43200]); // 30 días
        $p->expirationRules()->create(['location' => 'Tapado en recipiente', 'duration_minutes' => 10080]); // 7 días

// 5. Cacao en polvo
        $p = $mccafe->products()->create(['name' => 'Cacao en polvo', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Bolsa abierta a temperatura ambiente', 'duration_minutes' => 43200]); // 30 días
        $p->expirationRules()->create(['location' => 'En tamizador', 'duration_minutes' => 10080]); // 7 días
        $p->Category()->attach($servicio->id);

// 6. Café tostado en granos
        $p = $mccafe->products()->create(['name' => 'Café tostado en granos', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Bolsa abierta/molinilla', 'duration_minutes' => 7]); // 7 minutos
        $p->expirationRules()->create(['location' => 'Molido en molinillo', 'duration_minutes' => 10080]); // 7 días

// 7. Cake de chocolate
        $p = $mccafe->products()->create(['name' => 'Cake de chocolate', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Vitrina de refrigerados/ refrigerador', 'duration_minutes' => 4320, 'defrosting' => 1, 'defrosting_time' => 360]); // 3 días incl. 6hs desc.

// 8. Calzone de espinaca, hongos y queso
        $p = $mccafe->products()->create(['name' => 'Calzone de espinaca, h y q', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Refrigerador', 'duration_minutes' => 2880, 'defrosting' => 1, 'defrosting_time' => 420]); // 48 horas incl. 7hs desc.

// 9. Cheesecake
        $p = $mccafe->products()->create(['name' => 'Cheesecake', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Vitrina de refrigerados/refrigerador', 'duration_minutes' => 4320, 'defrosting' => 1, 'defrosting_time' => 360]); // 3 días incl. 6hs desc.

// 10. Chocolate rallado
        $p = $mccafe->products()->create(['name' => 'Chocolate rallado', 'active' => true]);
        $p->expirationRules()->create(['location' => 'En tamizador', 'duration_minutes' => 10080]); // 7 días
        $p->expirationRules()->create(['location' => 'Bolsa abierta a temperatura ambiente', 'duration_minutes' => 43200]); // 30 días

// 11. Crema
        $p = $mccafe->products()->create(['name' => 'Crema', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Hecha en sifón', 'duration_minutes' => 240]); // 4 horas

// 12. Croissant de chocolate
        $p = $mccafe->products()->create(['name' => 'Croissant de chocolate', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Vitrina de panificados, recipiente tapado', 'duration_minutes' => 360]); // 6 horas

// 13. Crumble de manzana
        $p = $mccafe->products()->create(['name' => 'Crumble de manzana', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Vitrina de refrigerados', 'duration_minutes' => 4320, 'defrosting' => 1, 'defrosting_time' => 1440]); // 3 días incl. 24hs desc.

// 14. Donuts
        $p = $mccafe->products()->create(['name' => 'Donuts', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Parte superior del sector caliente de la vitrina', 'duration_minutes' => 720, 'defrosting' => 1, 'defrosting_time' => 90]); // 12 horas incl. 90 min desc.

// 15. Frutos rojos
        $p = $mccafe->products()->create(['name' => 'Frutos rojos', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Abierta en jarra tapada en refrigerador', 'duration_minutes' => 10080]); // 7 dias

// 16. Leche
        $p = $mccafe->products()->create(['name' => 'Leche', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Abierta en refrigerador', 'duration_minutes' => 4320]); // 72 horas
        $p->expirationRules()->create(['location' => 'En jarra de acero inoxidable tapada refrigerado', 'duration_minutes' => 240]); // 4 horas
        $p->expirationRules()->create(['location' => 'Lechera', 'duration_minutes' => 240]); // 4 horas
        $p->Category()->attach($servicio->id);
        $p->Category()->attach($isla->id);


// 17. Leche condensada
        $p = $mccafe->products()->create(['name' => 'Leche condensada', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Envase, abierto refrigerado', 'duration_minutes' => 2880]); // 48 horas

// 18. Medialuna de lomo y queso
        $p = $mccafe->products()->create(['name' => 'Medialuna de lomo y queso', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Vitrina', 'duration_minutes' => 120]); // 2 horas

// 19. Medialunas de manteca/grasa
        $p = $mccafe->products()->create(['name' => 'Medialunas de manteca/grasa', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Vitrina de panificados, recipiente tapado', 'duration_minutes' => 360]); // 6 horas

// 20. Mezcla de Frappé / Vainilla
        $p = $mccafe->products()->create(['name' => 'Mezcla Frappé', 'active' => true]);
        $p->expirationRules()->create(['location' => 'En jarra tapado en refrigerador', 'duration_minutes' => 240]); // 4 horas

        $p = $mccafe->products()->create(['name' => 'Mezcla Vainilla', 'active' => true]);
        $p->expirationRules()->create(['location' => 'En jarra tapado en refrigerador', 'duration_minutes' => 240]); // 4 horas

// 21. Oreo
        $p = $mccafe->products()->create(['name' => 'Oreo', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Bolsa abierta', 'duration_minutes' => 10080]); // 7 días
        $p->expirationRules()->create(['location' => 'En contenedor de plástico cerrado', 'duration_minutes' => 43200]); // 30 días
        $p->expirationRules()->create(['location' => 'Contenedor tapado en máquina de helados', 'duration_minutes' => 1440]);
        $p->Category()->attach($isla->id);

// 22. Pan de queso
        $p = $mccafe->products()->create(['name' => 'Pan de queso', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Vitrina', 'duration_minutes' => 1440, 'defrosting' => 1, 'defrosting_time' => 120]); // 24 horas incl. 2hs desc.

// 23. Poundcakes (banana, chocolate, naranja)
        $p = $mccafe->products()->create(['name' => 'Poundcake banana', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Refrigerador/vitrina', 'duration_minutes' => 7200, 'defrosting' => 1, 'defrosting_time' => 360]); // 5 días incl. 6hs desc.

        $p = $mccafe->products()->create(['name' => 'Poundcakes chocolate', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Refrigerador/vitrina', 'duration_minutes' => 7200, 'defrosting' => 1, 'defrosting_time' => 360]); // 5 días incl. 6hs desc.

        $p = $mccafe->products()->create(['name' => 'Poundcakes naranja', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Refrigerador/vitrina', 'duration_minutes' => 7200, 'defrosting' => 1, 'defrosting_time' => 360]); // 5 días incl. 6hs desc.

// 24. Pulpa de frutilla
        $p = $mccafe->products()->create(['name' => 'Pulpa de frutilla', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Bolsa abierta en refrigerador', 'duration_minutes' => 10080]); // 7 días
        $p->expirationRules()->create(['location' => 'En jarra tapada refrigerada', 'duration_minutes' => 1440]); // 24 horas

// 25. Pulpa de banana
        $p = $mccafe->products()->create(['name' => 'Pulpa de banana', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Bolsa abierta en refrigerador', 'duration_minutes' => 10080]); // 7 días
        $p->expirationRules()->create(['location' => 'En jarra tapada refrigerada', 'duration_minutes' => 1440]); // 24 horas

// 26. Pulpa de limón, menta y jengibre
        $p = $mccafe->products()->create(['name' => 'Pulpa limón, menta y jengibre', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Bolsa abierta refrigerada', 'duration_minutes' => 2880, 'defrosting' => 1, 'defrosting_time' => 720]); // 48 horas incl. 12hs desc.
        $p->expirationRules()->create(['location' => 'En jarra tapada refrigerada', 'duration_minutes' => 1440]); // 24 horas

// 27. Sandwich napolitano de lomo / pollo
        $p = $mccafe->products()->create(['name' => 'Sandwich Napolitano Lomo', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Vitrina', 'duration_minutes' => 120]); // 2 horas

        $p = $mccafe->products()->create(['name' => 'Sandwich Napolitano Pollo', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Vitrina', 'duration_minutes' => 120]); // 2 horas

// 28. Syrup de vainilla
        $p = $mccafe->products()->create(['name' => 'Syrup de vainilla', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Abierto', 'duration_minutes' => 43200]); // 30 días

// 29. Torta argentina
        $p = $mccafe->products()->create(['name' => 'Torta argentina', 'active' => true]);
        $p->expirationRules()->create(['location' => 'En vitrina/refrigerador', 'duration_minutes' => 4320, 'defrosting' => 1, 'defrosting_time' => 360]); // 72 horas incl. 6hs desc.

// 30. Topping de chocolate y dulce de leche
        $p = $mccafe->products()->create(['name' => 'Topping Chocolate', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Bolsa abierta en refrigerador', 'duration_minutes' => 43200]); // 30 días
        $p->expirationRules()->create(['location' => 'En toppineras', 'duration_minutes' => 10080]); // 7 días
        $p->Category()->attach($isla->id);

        $p = $mccafe->products()->create(['name' => 'Topping dulce de leche', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Bolsa abierta en refrigerador', 'duration_minutes' => 43200]); // 30 días
        $p->expirationRules()->create(['location' => 'En toppineras', 'duration_minutes' => 10080]); // 7 días
        $p->Category()->attach($isla->id);

// 31. Tostado
        $p = $mccafe->products()->create(['name' => 'Tostado', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Refrigerado', 'duration_minutes' => 7200, 'defrosting' => 1, 'defrosting_time' => 720]); // 5 días incl. 12hs desc.
        $p->Category()->attach($cocina->id);


// SERVICIO

// 1. Aceite de girasol refinado
        $p = $servicio->products()->create(['name' => 'Aceite de girasol', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Bidón abierto en bodega', 'duration_minutes' => 10080]); // 7 días

// 2. Café
        $p = $servicio->products()->create(['name' => 'Café', 'active' => true]);
        $p->expirationRules()->create(['location' => 'En jarra preparado', 'duration_minutes' => 90]); // 1 hora y media

// 3. Jugo de naranja concentrado
        $p = $servicio->products()->create(['name' => 'Jugo de naranja', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Abierto en refrigerador', 'duration_minutes' => 20160]); // 14 días
        $p->expirationRules()->create(['location' => 'En máquina de jugo', 'duration_minutes' => 10080]); // 7 días

// 4. Pan para celíacos
        $p = $servicio->products()->create(['name' => 'Pan para celíacos', 'active' => true]);
        $p->expirationRules()->create(['location' => 'A temperatura ambiente', 'duration_minutes' => 4320, 'defrosting' => 1, 'defrosting_time' => 120]); // 72 horas incl. 2hs desc.

// 5. Papas
        $p = $servicio->products()->create(['name' => 'Papas', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Encestador automático', 'duration_minutes' => 1440]); // 24 horas
        $p->expirationRules()->create(['location' => 'Congelador pequeño o de pared', 'duration_minutes' => 60]); // 1 hora


// 6. Sal
        $p = $servicio->products()->create(['name' => 'Sal', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Bolsa abierta', 'duration_minutes' => 10080]); // 7 días
        $p->expirationRules()->create(['location' => 'Dentro del salero área de papas', 'duration_minutes' => 1440]);

// 7. Baño María
        $p = $servicio->products()->create(['name' => 'Baño María', 'active' => true]);
        $p->expirationRules()->create(['location' => 'En lechera', 'duration_minutes' => 480]); // 8 horas


// --- ISLA ---

// 1. Conos
        $p = $isla->products()->create(['name' => 'Conos', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Contenedor en máquinas de helados', 'duration_minutes' => 1440]); // 24 horas

// 2. Kit Kat
        $p = $isla->products()->create(['name' => 'Kit Kat', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Fraccionado en CDP/Mostrador o Barras', 'duration_minutes' => 2880]); // 48 horas
        $p->expirationRules()->create(['location' => 'Fraccionado/Barras en Ice Cube', 'duration_minutes' => 1440]); // 24 horas (desechar al cierre)

// 3. Mezcla de Vainilla
        $p = $isla->products()->create(['name' => 'Mezcla de Vainilla', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Bolsa abierta en refrigerador', 'duration_minutes' => 2880]); // 2 días
        $p->expirationRules()->create(['location' => 'Depósito de mezcla en HT', 'duration_minutes' => 20160]); // 14 días (quiebre del ciclo)

// 4. Dulce de Leche
        $p = $isla->products()->create(['name' => 'Dulce de Leche', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Bolsa abierta en refrigerador', 'duration_minutes' => 2880]); // 2 días
        $p->expirationRules()->create(['location' => 'Depósito de mezcla en HT', 'duration_minutes' => 20160]); // 14 días (quiebre del ciclo)

        // Topping de frutilla
        $p = $isla->products()->create(['name' => 'Topping frutilla', 'active' => true]);
        $p->expirationRules()->create(['location' => 'Bolsa abierta en refrigerador', 'duration_minutes' => 43200]); // 30 días
        $p->expirationRules()->create(['location' => 'En toppineras', 'duration_minutes' => 10080]); // 7 días


    }

}
