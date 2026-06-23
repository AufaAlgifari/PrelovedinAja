<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Cart;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CheckoutPaymentTest extends TestCase
{
    use DatabaseTransactions;

    public function test_checkout_page_loads_for_available_product(): void
    {
        $buyer = User::factory()->create([
            'email' => 'buyer@mhs.unsoed.ac.id',
            'no_kampus' => 'H1D024002',
        ]);
        $seller = User::factory()->create([
            'email' => 'seller@mhs.unsoed.ac.id',
            'no_kampus' => 'H1D024003',
        ]);
        $product = Product::factory()->create([
            'seller_id' => $seller->id,
            'status' => 'Available',
        ]);

        $response = $this->actingAs($buyer)->get("/checkout/{$product->id}");
        $response->assertStatus(200);
        $response->assertSee($product->title);
    }

    public function test_checkout_fails_if_product_already_sold(): void
    {
        $buyer = User::factory()->create([
            'email' => 'buyer@mhs.unsoed.ac.id',
            'no_kampus' => 'H1D024002',
        ]);
        $product = Product::factory()->create([
            'status' => 'Sold',
        ]);

        $response = $this->actingAs($buyer)->postJson("/checkout/{$product->id}", [
            'metode_pengiriman' => 'cod',
            'metode_pembayaran' => 'qris',
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'error' => 'Maaf, produk ini baru saja dibeli oleh pengguna lain.'
        ]);
    }

    public function test_checkout_creates_transaction_and_updates_product_status(): void
    {
        $buyer = User::factory()->create([
            'email' => 'buyer@mhs.unsoed.ac.id',
            'no_kampus' => 'H1D024002',
        ]);
        $seller = User::factory()->create([
            'email' => 'seller@mhs.unsoed.ac.id',
            'no_kampus' => 'H1D024003',
        ]);
        $product = Product::factory()->create([
            'seller_id' => $seller->id,
            'status' => 'Available',
            'price' => 100000,
        ]);

        // Add to cart first to test that it gets deleted
        Cart::create([
            'user_id' => $buyer->id,
            'product_id' => $product->id,
        ]);

        $response = $this->actingAs($buyer)->postJson("/checkout/{$product->id}", [
            'buyer_id' => $buyer->id,
            'metode_pengiriman' => 'cod',
            'metode_pembayaran' => 'qris',
        ]);

        // The transaction record MUST be created in the database
        $this->assertDatabaseHas('transactions', [
            'user_id' => $buyer->id,
            'product_id' => $product->id,
            'amount' => 100000,
            'metode_pengiriman' => 'cod',
            'metode_pembayaran' => 'qris',
            'status' => 'pending',
        ]);

        // The product status MUST be marked as Sold
        $product->refresh();
        $this->assertEquals('Sold', $product->status);

        // The product MUST be deleted from the cart
        $this->assertDatabaseMissing('carts', [
            'user_id' => $buyer->id,
            'product_id' => $product->id,
        ]);
    }
}
