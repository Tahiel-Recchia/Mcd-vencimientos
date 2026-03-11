<?php

namespace Tests\Feature;

use App\Models\ActiveTimer;
use App\Http\Controllers\DashboardController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;


class DashboardTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function deleteTimerTest(): void{
        $dashboard = DashboardController::factory()->create();
        $timer = ActiveTimer::find(1);
    }

    use RefreshDatabase;

    /** @test */
    public function redirige_al_inicio_si_no_hay_categoria_en_sesion()
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect(route('index'));
    }

    /** @test */
    public function muestra_el_dashboard_correctamente_con_los_timers_activos()
    {

        // 1. ARRANGE: Preparamos los datos
        $categoria = Category::factory()->create(['name' => 'Cocina']);

        // Creamos un timer activo y lo vinculamos a esta categoría
        $timerActivo = ActiveTimer::factory()->customCategory($categoria)->create(['is_active' => true]);

        // Creamos un timer inactivo (para asegurar que el controlador lo filtra)
        $timerInactivo = ActiveTimer::factory()->customCategory($categoria)->create(['is_active' => false]);

        // 2. ACT: Simulamos la petición HTTP "inyectando" la categoría en la sesión
        $response = $this->withSession(['category' => $categoria->id])
            ->get('/dashboard');

        // 3. ASSERT: Verificamos qué nos devolvió el controlador

        // A. La página cargó bien (Código HTTP 200 OK)
        $response->assertStatus(200);

        // B. Nos devolvió la vista de Blade correcta
        $response->assertViewIs('dashboard');

        // C. La vista recibió la variable 'timers'
        $response->assertViewHas('timers');

        // D. Verificamos que la vista SOLO tiene el timer activo, no el inactivo
        // Extraemos la variable $timers que el controlador le pasó a la vista
        $timersEnLaVista = $response->original->gatherData()['timers'];

        $this->assertCount(1, $timersEnLaVista);
        $this->assertEquals($timerActivo->id, $timersEnLaVista->first()->id);
    }

    /** @test */
public function cuando_un_timer_se_elimina_se_elimina_de_la_vista(){
    $category = Category::factory()->create(['name' => 'Cocina']);

    $timerA = ActiveTimer::factory()->customCategory($category)->create(['is_active' => true]);
    $timerB = ActiveTimer::factory()->customCategory($category)->create(['is_active' => true]);


    $response = $this->withSession(['category' => $category->id])
        ->get('/dashboard');

    $timersInView = $response->original->gatherData()['timers'];

    $this->assertCount(2, $timersInView);

    $deleteResponse = $this->delete('/active-timers/' . $timerA->id . '/' . $category->id);

    $newResponse = $this->withSession(['category' => $category->id])
        ->get('/dashboard');

    $deleteResponse->assertJson(['status' => 'ok']);


    $timersInView = $newResponse->original->gatherData()['timers'];

    $this->assertCount(1, $timersInView);
}

    /** @test */
    public function al_importar_un_timer_se_muestre_en_la_otra_categoria()
    {
        $categoryA = Category::factory()->create(['name' => 'Cocina']);
        $categoryB = Category::factory()->create(['name' => 'Servicio']);

        $timerA = ActiveTimer::factory()->customCategory($categoryA)->create(['is_active' => true]);

        $this->post('/import-timer/'. $timerA->id .'/' . $categoryB->id);


        $response = $this->withSession(['category' => $categoryB->id])->get('/dashboard');
        $timersOnView = $response->original->gatherData()['timers'];

        $this->assertCount(1, $timersOnView);
        $this->assertTrue($timersOnView->contains('group_id', $timerA->group_id));

        $response = $this->withSession(['category' => $categoryA->id])->get('/dashboard');
        $timersOnView = $response->original->gatherData()['timers'];

        $this->assertCount(1, $timersOnView);
        $this->assertTrue($timersOnView->contains('id', $timerA->id));
    }

    /** @test */
    public function que_no_se_pueda_importar_un_timer_existente_en_una_categoria()
    {
        $categoryA = Category::factory()->create(['name' => 'Cocina']);

        $timerA = ActiveTimer::factory()->customCategory($categoryA)->create(['is_active' => true]);

        $response = $this->post('/import-timer/'. $timerA->id .'/' . $categoryA->id);
        $response->assertJson(['success' => false, 'message' => 'El timer ya existe en esa categoría']);
    }

    /** @test */
    public function que_se_actualice_la_fecha_de_vencimiento_al_actualizar_un_timer()
    {
        $categoryA = Category::factory()->create(['name' => 'Cocina']);

        $timerA = ActiveTimer::factory()->customCategory($categoryA)->minusOneHour()->create(['is_active' => true]);

        $this->assertDatabaseHas('active_timers', [
            'id' => $timerA->id,
            'is_active' => true,
            'started_at' => now()->subHours(1),
        ]);

        $this->put('/updateTimer/' . $timerA->id);

        $this->assertDatabaseHas('active_timers', [
            'id' => $timerA->id,
            'is_active' => true,
            'started_at' => now(),
        ]);


    }

    /** @test */
    public function que_se_puedan_obtener_las_categorias_de_un_timer(){
        $product = Product::factory()->create(['name' => 'Papas']);
        $timerA = ActiveTimer::factory()->customProduct($product)->create(['is_active' => true]);
        $categoryA = Category::factory()->create(['name' => 'Cocina']);
        $categoryB = Category::factory()->create(['name' => 'Servicio']);
        $product->category()->attach($categoryA);
        $product->category()->attach($categoryB);

        $response = $this->get('/timers/'. $timerA->id .'/categories');
        $data = $response->json();
        $categories = $data['options'];
        dd($data);
        $this->assertTrue(in_array($categoryA->id, $categories));
        $this->assertTrue(in_array($categoryB->id, $categories));

    }
}
