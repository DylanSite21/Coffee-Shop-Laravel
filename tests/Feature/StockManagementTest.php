<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $manager;
    protected User $customer;
    protected Category $category;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->manager = User::create([
            'name' => 'Manager User',
            'email' => 'manager@test.com',
            'password' => bcrypt('password'),
            'role' => 'manager',
        ]);

        $this->customer = User::create([
            'name' => 'Customer User',
            'email' => 'customer@test.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);

        $this->category = Category::create([
            'name' => 'Coffee',
            'slug' => 'coffee',
            'is_active' => true,
        ]);
    }

    public function test_admin_can_create_menu_with_stock_and_update_it(): void
    {
        $this->actingAs($this->admin);

        $response = $this->post(route('admin.menus.store'), [
            'category_id' => $this->category->id,
            'name' => 'Kopi Tubruk',
            'price' => 15000,
            'stock' => 50,
            'status' => 'approved',
            'is_available' => 1,
        ]);

        $response->assertRedirect(route('admin.menus.index'));
        $this->assertDatabaseHas('menus', [
            'name' => 'Kopi Tubruk',
            'stock' => 50,
        ]);

        $menu = Menu::where('name', 'Kopi Tubruk')->first();

        $this->put(route('admin.menus.update', $menu), [
            'category_id' => $this->category->id,
            'name' => 'Kopi Tubruk Updated',
            'price' => 17000,
            'stock' => 25,
            'status' => 'approved',
            'is_available' => 1,
        ]);

        $this->assertDatabaseHas('menus', [
            'name' => 'Kopi Tubruk Updated',
            'stock' => 25,
        ]);
    }

    public function test_manager_can_view_stock_in_menus_list(): void
    {
        $menu = Menu::create([
            'category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'name' => 'Latte Art',
            'price' => 25000,
            'stock' => 12,
            'status' => 'approved',
            'is_available' => true,
        ]);

        $this->actingAs($this->manager);
        $response = $this->get(route('manager.menus.index'));

        $response->assertStatus(200);
        $response->assertSee('12');
        $response->assertSee('Stok');
    }

    public function test_user_cannot_add_out_of_stock_item_to_cart(): void
    {
        $outOfStockMenu = Menu::create([
            'category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'name' => 'Cold Brew Sold Out',
            'price' => 30000,
            'stock' => 0,
            'status' => 'approved',
            'is_available' => true,
        ]);

        $this->actingAs($this->customer);
        $response = $this->post(route('user.cart.store'), [
            'menu_id' => $outOfStockMenu->id,
            'quantity' => 1,
        ]);

        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('cart_items', [
            'menu_id' => $outOfStockMenu->id,
        ]);
    }

    public function test_user_cannot_add_quantity_exceeding_stock(): void
    {
        $limitedMenu = Menu::create([
            'category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'name' => 'Special Geisha',
            'price' => 75000,
            'stock' => 3,
            'status' => 'approved',
            'is_available' => true,
        ]);

        $this->actingAs($this->customer);
        $response = $this->post(route('user.cart.store'), [
            'menu_id' => $limitedMenu->id,
            'quantity' => 5,
        ]);

        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('cart_items', [
            'menu_id' => $limitedMenu->id,
        ]);
    }

    public function test_user_cannot_checkout_if_item_in_cart_is_out_of_stock(): void
    {
        $menu = Menu::create([
            'category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'name' => 'Croissant',
            'price' => 20000,
            'stock' => 0,
            'status' => 'approved',
            'is_available' => true,
        ]);

        $cart = Cart::create([
            'user_id' => $this->customer->id,
            'total' => 20000,
            'status' => 'active',
        ]);

        CartItem::create([
            'cart_id' => $cart->id,
            'menu_id' => $menu->id,
            'quantity' => 1,
            'price' => 20000,
            'subtotal' => 20000,
        ]);

        $this->actingAs($this->customer);
        $response = $this->post(route('user.checkout.store'), [
            'shipping_address' => 'Jl. Sudirman No 10',
            'phone' => '08123456789',
            'payment_method' => 'cash',
        ]);

        $response->assertRedirect(route('user.cart.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('orders', [
            'user_id' => $this->customer->id,
        ]);
    }

    public function test_manager_confirmation_2_times_deducts_stock_directly(): void
    {
        $menu = Menu::create([
            'category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'name' => 'Signature Blend',
            'price' => 35000,
            'stock' => 20,
            'status' => 'approved',
            'is_available' => true,
        ]);

        $order = Order::create([
            'order_number' => 'ORD-TEST-12345',
            'user_id' => $this->customer->id,
            'total' => 70000,
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => 'cash',
            'shipping_address' => 'Jl. Thamrin No 5',
            'phone' => '081298765432',
        ]);

        OrderDetail::create([
            'order_id' => $order->id,
            'menu_id' => $menu->id,
            'quantity' => 3,
            'price' => 35000,
            'subtotal' => 70000,
        ]);

        $this->actingAs($this->manager);

        // 1st confirmation: Manager accepts order (pending -> processing)
        $acceptResponse = $this->post(route('manager.orders.accept', $order));
        $acceptResponse->assertSessionHas('success');
        
        $order->refresh();
        $this->assertEquals('processing', $order->status);

        // Stock should NOT be deducted yet on 1st confirmation
        $menu->refresh();
        $this->assertEquals(20, $menu->stock);

        // 2nd confirmation: Manager completes order (processing -> completed)
        $completeResponse = $this->post(route('manager.orders.complete', $order));
        $completeResponse->assertSessionHas('success');

        $order->refresh();
        $this->assertEquals('completed', $order->status);

        // Stock MUST be deducted directly by the ordered quantity (20 - 3 = 17)
        $menu->refresh();
        $this->assertEquals(17, $menu->stock);
    }

    public function test_user_view_displays_stok_habis_without_showing_stock_number(): void
    {
        $outOfStockMenu = Menu::create([
            'category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'name' => 'Affogato Special',
            'price' => 32000,
            'stock' => 0,
            'status' => 'approved',
            'is_available' => true,
        ]);

        $this->actingAs($this->customer);

        // Menu detail page
        $showResponse = $this->get(route('user.menus.show', $outOfStockMenu));
        $showResponse->assertStatus(200);
        $showResponse->assertSee('Stok Habis');
        $showResponse->assertSee('disabled');
        // Assert user does NOT see stock number like "0 Unit" or "Stok: 0"
        $showResponse->assertDontSee('0 Unit');

        // Home page
        $homeResponse = $this->get(route('home'));
        $homeResponse->assertStatus(200);
        $homeResponse->assertSee('Affogato Special');
        $homeResponse->assertSee('Stok Habis');
    }

    public function test_stock_reaches_zero_properly_on_final_order(): void
    {
        $menu = Menu::create([
            'category_id' => $this->category->id,
            'user_id' => $this->admin->id,
            'name' => 'Last Cup of Java',
            'price' => 20000,
            'stock' => 2,
            'status' => 'approved',
            'is_available' => true,
        ]);

        $order = Order::create([
            'order_number' => 'ORD-LAST-001',
            'user_id' => $this->customer->id,
            'total' => 40000,
            'status' => 'processing',
            'payment_status' => 'pending',
            'payment_method' => 'cash',
            'shipping_address' => 'Jl. Merdeka No 1',
            'phone' => '0811223344',
        ]);

        OrderDetail::create([
            'order_id' => $order->id,
            'menu_id' => $menu->id,
            'quantity' => 2,
            'price' => 20000,
            'subtotal' => 40000,
        ]);

        $this->actingAs($this->manager);
        $this->post(route('manager.orders.complete', $order));

        $menu->refresh();
        $this->assertEquals(0, $menu->stock);
        $this->assertFalse($menu->isInStock());
    }
}
