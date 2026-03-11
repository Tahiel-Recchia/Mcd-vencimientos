<?php

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use App\Models\ActiveTimer;
use App\Models\Category;
use App\Models\Product; // Asumiendo que necesitas crear un producto para el timer
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActiveTimerTest extends TestCase
{
    // Este Trait es MAGIA: Borra la base de datos después de cada test
    // para que siempre empieces con una pizarra limpia.
    use RefreshDatabase;


    #[Test]
    public function se_elimina_el_timer()
    {

        $timer = ActiveTimer::factory()->create(['is_active' => true]);
        $resultado = $timer->deleteTimer();

        $this->assertEquals('Timer desactivado globalmente', $resultado['message']);

        $timer->refresh();
        $this->assertEquals(0, $timer->is_active);
        $this->assertEquals('eliminated', $timer->state);
    }

    #[Test]
    public function obtiene_las_categorias_con_su_estado_de_presencia_correcto()
    {

        $categoryA = Category::factory()->create(['name' => 'Cocina']);
        $categoryB = Category::factory()->create(['name' => 'Servicio']);
        $timer = ActiveTimer::factory()->customCategory($categoryA)->create();
        $timer->product->category()->attach([$categoryA->id, $categoryB->id]);


        $options = $timer->getImportOptions();

        $this->assertCount(2, $options);

        $optionA = $options->firstWhere('id', $categoryA->id);

        $this->assertNotNull($optionA, 'La categoría Cocina debería estar en las opciones');
        $this->assertTrue($optionA['is_present']);
        $this->assertEquals('Cocina', $optionA['name']);

        $optionB = $options->firstWhere('id', $categoryB->id);

        $this->assertNotNull($optionB, 'La categoría Servicio debería estar en las opciones');
        $this->assertFalse($optionB['is_present']);
    }

    #[Test]
    public function que_devuelva_todos_los_timers_eliminados_de_mayor_a_menor(){
        $categoryA = Category::factory()->create(['name' => 'Cocina']);
        $categoryB = Category::factory()->create(['name' => 'Servicio']);
        $productA = Product::factory()->create();
        $productB = Product::factory()->create();
        $productA->category()->attach([$categoryA->id]);
        $productB->category()->attach([$categoryB->id, $categoryA->id]);

        $timerA = ActiveTimer::factory()->eliminated()->customCategory($categoryA)->customProduct($productA)->create(['is_active' => false]);
        $timerB = ActiveTimer::factory()->eliminated()->customCategory($categoryB)->customProduct($productB)->create(['is_active' => false]);
        $timerC = ActiveTimer::factory()->eliminated()->customCategory($categoryB)->customProduct($productB)->create(['is_active' => false]);

        $eliminatedTimers = ActiveTimer::getAllEliminatedTimers();
        dd($eliminatedTimers);

    }
}
